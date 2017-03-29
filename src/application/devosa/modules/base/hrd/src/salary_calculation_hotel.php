<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('libraries/helper/employee_function.php');
doInclude('form_object.php');
doInclude('salary_func.php');
doInclude('plugins/model/model.php');
doInclude('plugins/datagrid2/datagrid.php');
doInclude('libraries/classes/hrd/hrd_basic_salary_set.php');
$dataPrivilege = getDataPrivileges(
    basename($_SERVER['PHP_SELF']),
    $bolCanView,
    $bolCanEdit,
    $bolCanDelete,
    $bolCanApprove,
    $bolCanCheck,
    $bolCanAcknowledge
);
if (!$bolCanView) {
    die(accessDenied($_SERVER['HTTP_REFERER']));
}
$strDisplay = ($bolCanEdit) ? "table-row" : "none";
//---- INISIALISASI ----------------------------------------------------
$strDataDetail = "";
$strWordsCompany = getWords("company");
$strWordsSalaryDate = getWords("salary calculation date");
$strWordsAttendanceDate = getWords("period for salary");
$strWordsAttendanceDateSC = getWords("period for variable service charge");
$strWordsPeriodForTHR = getWords("period for THR");
$strWordsSalarySet = getWords("salary set");
$strWordsIrregular = getWords("irregular");
$strWordsHideIfBlank = getWords("hide if blank");
$strWordsStartCalculation = getWords("start calculation");
$strWordsRevenue = getWords("total revenue");
$strWordsNote = getWords("note");
$strHidden = "";
$strButtons = "";
$intTotalData = 0;
//----------------------------------------------------------------------
//--- DAFTAR FUNSI------------------------------------------------------
// menyimpan perintah perhitungan gaji
// output : ID perhitungan gaji, jika sukses, jika gagal, return ""
function saveData($db, &$strError)
{
    global $_REQUEST;
    global $error;
    global $_SESSION;
    $strDataTHRDateFrom = (isset($_REQUEST['dataTHRDateFrom'])) ? $_REQUEST['dataTHRDateFrom'] : "";
    $strDataTHRDateThru = (isset($_REQUEST['dataTHRDateThru'])) ? $_REQUEST['dataTHRDateThru'] : "";
    $strDataDateFrom = (isset($_REQUEST['dataDateFrom'])) ? $_REQUEST['dataDateFrom'] : date("Y-m-d");
    $strDataDateThru = (isset($_REQUEST['dataDateThru'])) ? $_REQUEST['dataDateThru'] : date("Y-m-d");
    $strDataDateFromSC = (isset($_REQUEST['dataDateFromSC'])) ? $_REQUEST['dataDateFromSC'] : date("Y-m-d");
    $strDataDateThruSC = (isset($_REQUEST['dataDateThruSC'])) ? $_REQUEST['dataDateThruSC'] : date("Y-m-d");
    $strDataDate = (isset($_REQUEST['dataDate'])) ? $_REQUEST['dataDate'] : date("Y-m-d");
    $strDataCompany = (isset($_REQUEST['dataCompany'])) ? $_REQUEST['dataCompany'] : "";
    $strDataRevenue = (isset($_REQUEST['dataRevenue'])) ? $_REQUEST['dataRevenue'] : 0;
    $bolIrregular = (isset($_REQUEST['dataIrregular'])) ? true : false;
    $bolHideBlank = (isset($_REQUEST['dataHideBlank'])) ? true : false;
    $strDataNote = (isset($_REQUEST['dataNote'])) ? $_REQUEST['dataNote'] : "";
    //$strDataTaxRate     = (isset($_REQUEST['dataTaxRate']))     ? $_REQUEST['dataTaxRate']      : "";
    $strDataIDSalarySet = (isset($_REQUEST['dataIDSalarySet'])) ? $_REQUEST['dataIDSalarySet'] : "";
    if (!validStandardDate($strDataTHRDateFrom) && $strDataTHRDateFrom != "") {
        $strError = $error['invalid_date'] . " " . $strDataTHRDateFrom;
        return 0;
    } else if (!validStandardDate($strDataTHRDateThru) && $strDataTHRDateFrom != "") {
        $strError = $error['invalid_date'] . " " . $strDataTHRDateThru;
        return 0;
    } else if (!validStandardDate($strDataDateFrom)) {
        $strError = $error['invalid_date'] . " " . $strDataDateFrom;
        return 0;
    } else if (!validStandardDate($strDataDateThru)) {
        $strError = $error['invalid_date'] . " " . $strDataDateThru;
        return 0;
    } else if (!validStandardDate($strDataDate)) {
        $strError = $error['invalid_date'] . " " . $strDataDate;
        return 0;
    }
    if ($strDataCompany == "") {
        $strError = "please choose one company to start salary calculation";
        return 0;
    }
    $intID = "";
    doInclude('cls_salary_calculation_hotel.php');
    $objSalary = new clsSalaryCalculationHotel(
        $db,
        "",
        $bolIrregular,
        $strDataDate,
        ["id_company" => $strDataCompany],
        $strDataDateFrom,
        $strDataDateThru,
        $strDataDateFromSC,
        $strDataDateThruSC
    );
    $objSalary->setSalaryDate(
        $strDataDate,
        $strDataDateFrom,
        $strDataDateThru,
        $strDataTHRDateFrom,
        $strDataTHRDateThru,
        $strDataDateFromSC,
        $strDataDateThruSC,
        $strDataCompany,
        $strDataIDSalarySet,
        $bolHideBlank,
        $strDataNote,
        $strDataRevenue
    );
    $objSalary->saveData();
    $intID = $objSalary->strDataID;
    unset($objSalary);
    return $intID;
}// saveData
// fungsi untuk menghapus data
function deleteData()
{
    global $db;
    global $myDataGrid;
    $arrKeys = [];
    $db->execute("begin");
    $isSuccess = false;
    $counter = 0;
    foreach ($myDataGrid->checkboxes as $strValue) {
        $counter++;
        $strSQL = "";
        $strSQL .= "
        DELETE FROM hrd_salary_master_allowance WHERE id_salary_master = '$strValue'; 
        DELETE FROM hrd_salary_master_deduction WHERE id_salary_master = '$strValue'; 
        DELETE FROM hrd_salary_deduction WHERE id_salary_master = '$strValue'; 
        DELETE FROM hrd_salary_allowance WHERE id_salary_master = '$strValue'; 
        DELETE FROM hrd_salary_detail WHERE id_salary_master = '$strValue'; 
        DELETE FROM hrd_salary_master WHERE id = '$strValue'; 
        DELETE FROM hrd_leave_allowance WHERE  id_salary_master = '$strValue';  
      ";
        $isSuccess = $db->execute($strSQL);
        if (!$isSuccess) {
            break;
        }
    }
    if ($isSuccess) {
        $db->execute("commit");
        $myDataGrid->message = $counter . " record(s) " . getWords("salary data deleted!");
    } else {
        $db->execute("rollback");
        $myDataGrid->errorMessage = getWords("failed to delete salary data!");
    }
} //deleteData
// fungsi untuk verify, check, deny, atau approve
function changeStatus($db, $intStatus)
{
    global $_REQUEST;
    global $_SESSION;
    //global $ARRAY_CURRENCY;
    if (!is_numeric($intStatus)) {
        return false;
    }
    $strUpdate = "";
    $strSQL = "";
    $strmodified_byID = $_SESSION['sessionUserID'];
    $strUpdate = getStatusUpdateString($intStatus);
    foreach ($_REQUEST as $strIndex => $strValue) {
        if (substr($strIndex, 0, 15) == 'DataGrid1_chkID') {
            $strSQLx = "SELECT status, salary_date, id_company
                    FROM hrd_salary_master WHERE id = '$strValue' ";
            $resDb = $db->execute($strSQLx);
            if ($rowDb = $db->fetchrow($resDb)) {
                //the status should be increasing
                //if (isProcessable($rowDb['status'], $intStatus))
                if (($intStatus == -1) || (($rowDb['status'] < $intStatus) && ($rowDb['status'] != -1))) {
                    $strSQL .= "UPDATE hrd_salary_master SET $strUpdate status = '$intStatus'  ";
                    $strSQL .= "WHERE id = '$strValue'; ";
                    writeLog(
                        ACTIVITY_EDIT,
                        MODULE_PAYROLL,
                        getCompanyCode($rowDb['id_company']) . " - " . $rowDb['salary_date'],
                        $intStatus
                    );
                }
            }
        }
        $resExec = $db->execute($strSQL);
    }
} //changeStatus
//----------------------------------------------------------------------
//class inheritance from cDataGrid
class cDataGrid2 extends cDataGrid
{

    /*you can inherit this function to created your own TR class or style*/
    function printOpeningRow($intRows, $rowDb)
    {
        $strResult = "";
        $strClass = "";//getCSSClassName($rowDb['status'], false);
        if (($intRows % 2) == 0) {
            $strResult .= "
            <tr $strClass valign=\"top\">";
        } else {
            $strResult .= "
            <tr $strClass valign=\"top\">";
        }
        return $strResult;
    }
}

// fungsi getData dengan datagrid
function getDataGrid($db, $strCriteria, $bolLimit = true, $isFullView = false)
{
    global $bolPrint;
    global $dataPrivilege, $bolCanView, $bolCanEdit, $bolCanDelete, $bolCanApprove, $bolCanCheck, $bolCanAcknowledge;
    global $intTotalData;
    global $myDataGrid;
    $tblSalary = new cModel("hrd_salary_master", getWords("salary calculation"));
    $DEFAULTPAGELIMIT = getSetting("rows_per_page");
    if (!is_numeric($DEFAULTPAGELIMIT)) {
        $DEFAULTPAGELIMIT = 50;
    }
    if ($bolPrint) {
        $myDataGrid = new cDataGrid2("formData", "DataGrid1", "", "", false, false, false, false);
    } else {
        $myDataGrid = new cDataGrid2("formData", "DataGrid1", "100%", "", $bolLimit, false, true);
        $myDataGrid->caption = getWords("list of salary calculation");
    }
    $myDataGrid->disableFormTag();
    //$myDataGrid->setAJAXCallBackScript(basename($_SERVER['PHP_SELF']));
    $myDataGrid->pageSortBy = "id DESC";
    $myDataGrid->setCriteria($strCriteria);
    //end of class initialization
    if (!isset($_REQUEST['btnExportXLS'])) {
        $myDataGrid->addColumnCheckbox(
            new DataGrid_Column("chkID", "id", ['width' => 15], ['align' => 'center', 'nowrap' => ''])
        );
    }
    $myDataGrid->addColumnNumbering(new DataGrid_Column("No", "", ['width' => 30], ['nowrap' => '']));
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("company"),
            "id_company",
            ["width" => 70],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "printCompanyName()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(new DataGrid_Column("id", "id", ['width' => 15], ['align' => 'center', 'nowrap' => '']));
    //$myDataGrid->addColumn(new DataGrid_Column(getWords("currency"), "salary_currency", array("width" => 70),  array("nowrap" => "nowrap"), true, true, "", "printSalaryCurrency()", "string", true, 12));
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("salary date"),
            "salary_date",
            ["width" => 70],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "formatDate()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("date from"),
            "date_from",
            ["width" => 70],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "formatDate()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("date thru"),
            "date_thru",
            ["width" => 70],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "formatDate()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("total revenue for service charge"),
            "revenue",
            ["width" => 70],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "formatNumber()",
            "",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("date from for service charge"),
            "date_from_sc",
            ["width" => 70],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "formatDate()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("date thru for service charge"),
            "date_thru_sc",
            ["width" => 70],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "formatDate()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("irregular income"),
            "irregular",
            ["width" => 50],
            ["align" => "center", "nowrap" => "nowrap"],
            true,
            true,
            "",
            "printActiveSymbol()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("hide if blank"),
            "hide_blank",
            ["width" => 50],
            ["align" => "center", "nowrap" => "nowrap"],
            true,
            true,
            "",
            "printActiveSymbol()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(getWords("note"), "note", [], ["nowrap" => "nowrap"], true, true, "", "", "string", true)
    );
    //$myDataGrid->addColumn(new DataGrid_Column(getWords("tax rate"), "tax_rate", array(),  array("nowrap" => "nowrap"), true, true, "", "", "string", true));
    $myDataGrid->addColumn(
        new DataGrid_Column(getWords("status"), "status", ['width' => '60'], "", true, true, "", "printRequestStatus()")
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("created"),
            "created",
            ["width" => 50],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "formatDate()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("approved"),
            "approved_time",
            ["width" => 50],
            ["nowrap" => "nowrap"],
            true,
            true,
            "",
            "formatDate()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("approved by"),
            "approved_by",
            ["width" => 50],
            ["align" => "center", "nowrap" => "nowrap"],
            true,
            true,
            "",
            "printUserName()",
            "string",
            true,
            12
        )
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("show"),
            "",
            ["width" => 30],
            ["align" => "center"],
            true,
            true,
            "",
            "printShowLink()",
            "string",
            false,
            12
        )
    );
    generateRoleButtons($bolCanEdit, $bolCanDelete, $bolCanCheck, $bolCanApprove, true, true, $myDataGrid);
    //$myDataGrid->addButton("btnPrint", "btnPrint", "submit", getWords("print"), "onClick=\"document.formData.target = '_blank';\"");
    $myDataGrid->addButtonExportExcel(getWords("export excel"), "salarylist.xls", getWords("list of salary"));
    $myDataGrid->getRequest();
    //--------------------------------
    //get Data and set to Datagrid's DataSource by set the data binding (bind method)
    $strOrderBy = $myDataGrid->getSortBy();
    if ($bolLimit) {
        $strPageLimit = $myDataGrid->getPageLimit();
        $intPageNumber = $myDataGrid->getPageNumber();
    } else {
        $strPageLimit = null;
        $intPageNumber = null;
    }
    $myDataGrid->totalData = $tblSalary->findCount($strCriteria);
    $dataset = $tblSalary->findAll(
        $strCriteria,
        "id, id_company, salary_date, date_from, date_thru, date_from_thr, date_thru_thr, date_from_sc, date_thru_sc, revenue, irregular, hide_blank, note, created :: date, approved_time :: date, approved_by,status",
        $strOrderBy,
        $strPageLimit,
        $intPageNumber
    );
    $intTotalData = count($dataset);
    $myDataGrid->bind($dataset);
    return $myDataGrid->render();
}

function printShowLink($params)
{
    extract($params);
    //2011-04-21:agnes;
    return generateHidden("dataID_" . $record['id'], $record['id'], "") . generateButton(
        "btnReferer1" . $record['id'],
        getWords("show"),
        "style=\"background-color:white;border:none;color:blue;width:50px;text-align:left;\"" . getWords(
            "show"
        ),
        "onclick=\"document.formReferer1.dataID.value = '" . $record['id'] . "';document.formReferer1.submit()\""
    );
    #return "<a href='salary_calculation_result.php?dataID=" .$record['id']. "'>" .getWords("show"). "</a>";$value
}

//----MAIN PROGRAM -----------------------------------------------------
$strInfo = "";
$db = new CdbClass;
if ($db->connect()) {
    if (isset($_REQUEST['btnStart'])) {
        if ($bolCanEdit) {
            $strError = "";
            $intID = saveData($db, $strError);
            if ($intID > 0) { // error
                // langsung redirect
                redirectPage("salary_calculation_result_hotel.php?dataID=$intID");
                //echo "<script>postToURL('salary_calculation_result.php', {'dataID':'$intID'})</script>";
                exit();
            } else {
                if ($strError != "") {
                    echo "<script>alert('$strError');</script>";
                }
            }
        }
    }
    // ------ AMBIL DATA KRITERIA -------------------------
    // ------------ GENERATE KRITERIA QUERY,JIKA ADA -------------
    $strKriteria = "";
    $strKriteria .= $strKriteriaCompany;
    $bolLimit = false;
    $bolPrint = false;
    if ($bolCanView) {
        //$strDataDetail = getData($db, $intTotalData, $strKriteria);
        $strDataDetail = getDataGrid($db, $strKriteria);
    } else {
        showError("view_denied");
        $strDataDetail = "";
    }
    // generate data hidden input dan element form input
    $intDefaultWidthPx = 200;
    //getDefaultSalaryPeriode($strDefaultFrom,$strDefaultThru);
    $strDefaultDate = date("Y-m-d");
    $strTempDate = getNextDateNextMonth($strDefaultDate, -1);
    $strTempDate2 = getNextDateNextMonth($strDefaultDate, 1);
    $arrDtLastMonth = explode("-", $strTempDate);
    $arrDtNextMonth = explode("-", $strTempDate2);
    $arrDtThisMonth = explode("-", $strDefaultDate);
    $strDefaultFrom = $arrDtThisMonth[0] . "-" . $arrDtThisMonth[1] . "-" . "01";
    $strDefaultThru = $arrDtThisMonth[0] . "-" . $arrDtThisMonth[1] . "-" . lastday(
            $arrDtThisMonth[1],
            $arrDtThisMonth[0]
        );
    $strDefaultFromSC = $arrDtLastMonth[0] . "-" . $arrDtLastMonth[1] . "-" . "18";
    $strDefaultThruSC = $arrDtThisMonth[0] . "-" . $arrDtThisMonth[1] . "-" . "17";
    if (!validStandardDate($strDefaultDate)) {
        $strDefaultDate = $strDefaultThru;
    }
    $strInputDateFrom = "<input class=\"form-control datepicker\" type=text name=\"dataDateFrom\" id=\"dataDateFrom\" maxlength=10 value=\"$strDefaultFrom\" data-date-format=\"yyyy-mm-dd\">";
    $strInputDateThru = "<input class=\"form-control datepicker\" type=text name=dataDateThru id=dataDateThru maxlength=10 value=\"$strDefaultThru\" data-date-format=\"yyyy-mm-dd\">";
    $strInputSCDateFrom = "<input class=\"form-control datepicker\" type=text name=\"dataDateFromSC\" id=\"dataDateFromSC\" maxlength=10 value=\"$strDefaultFromSC\" data-date-format=\"yyyy-mm-dd\">";
    $strInputSCDateThru = "<input class=\"form-control datepicker\" type=text name=dataDateThruSC id=dataDateThruSC maxlength=10 value=\"$strDefaultThruSC\" data-date-format=\"yyyy-mm-dd\">";
    $strInputTHRDateFrom = "<input class=\"form-control datepicker\" type=text name=dataTHRDateFrom id=dataTHRDateFrom maxlength=10 value=\"\" data-date-format=\"yyyy-mm-dd\">";
    $strInputTHRDateThru = "<input class=\"form-control datepicker\" type=text name=dataTHRDateThru id=dataTHRDateThru maxlength=10 value=\"\" data-date-format=\"yyyy-mm-dd\">";
    $strInputDate = "<input class=\"form-control datepicker\" type=text name=dataDate id=dataDate maxlength=10 value=\"$strDefaultDate\" data-date-format=\"yyyy-mm-dd\">";
    $strInputCompany = getCompanyList(
        $db,
        "dataCompany",
        $strDataCompany,
        $strEmptyOption2,
        $strKriteria2,
        "style=\"width:$intDefaultWidthPx\" "
    );
    $strInputIrregular = generateCheckBox(
            "dataIrregular",
            false,
            "",
            "",
            '<strong>' . $strWordsIrregular
        ) . '</strong>';
    $strInputHideBlank = generateCheckBox(
        "dataHideBlank",
        false,
        "",
        "",
        '<strong>' . $strWordsHideIfBlank . '</strong>'
    );
    $strInputRevenue = generateNumber("dataRevenue", 0);
    $strInputNote = generateTextArea(
        "dataNote",
        getWords("(note)"),
        "rows=1, cols=45 style=\"color:gray\"",
        "onFocus=\"this.value=''\" onBlur=\"if(this.value == '') this.value='" . getWords(
            "(note)"
        ) . "'\""
    );
    $tblBasicSalarySet = new cHrdBasicSalarySet();
    $arrBasicSalarySet = $tblBasicSalarySet->findAll(
        $strKriteriaCompany,
        "id, start_date, id_company",
        "start_date desc",
        null,
        1,
        "id"
    );
    foreach ($arrBasicSalarySet AS $keySet => $arrSet) {
        $arrSetSource[$keySet] = $arrSet['start_date'] . " - " . printCompanyName($arrSet['id_company']);
    }
    $strInputSalarySet = getComboFromArray(
        $arrSetSource,
        "dataIDSalarySet",
        "",
        "",
        "style=\"width:$intDefaultWidthPx\""
    );
}
$tbsPage = new clsTinyButStrong;
//write this variable in every page
$strPageTitle = $dataPrivilege['menu_name'];
$pageIcon = "../images/icons/" . $dataPrivilege['icon_file'];
$strPageDesc = getWords("employee salary calculation");
$pageHeader = pageHeader($pageIcon, $strPageTitle, $strPageDesc);
$strTemplateFile = getTemplate(str_replace(".php", ".html", basename($_SERVER['PHP_SELF'])));
//------------------------------------------------
//Load Master Template
$tbsPage->LoadTemplate($strMainTemplate);
$tbsPage->Show();
?>