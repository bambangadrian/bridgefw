<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('libraries/helper/employee_function.php');
doInclude('plugins/form2/form2.php');
doInclude('plugins/datagrid2/datagrid.php');
doInclude('libraries/classes/hrd/hrd_attendance.php');
doInclude('libraries/classes/hrd/hrd_absence_partial.php');
doInclude('libraries/classes/hrd/hrd_absence_detail.php');
doInclude('overtime_func.php');
doInclude('activity.php');
doInclude('form_object.php');
doInclude('attendance_functions.php');
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
$bolPrint = (isset($_REQUEST['btnPrint']) || isset($_REQUEST['btnExportXLS']) || isset($_REQUEST['btnExcel']));
//---- INISIALISASI ----------------------------------------------------
$strWordsATTENDANCEDATA = getWords("attendance data");
$strWordsEntryAttendance = getWords("entry attendance");
$strWordsImportAttendance = getWords("import attendance");
$strWordsAttendanceList = getWords("attendance list");
$strWordsAttendanceReport = getWords("attendance report");
$strWordsDateFrom = getWords("date from");
$strWordsDateThru = getWords("date thru");
$strWordsEmployeeID = getWords("employee id");
$strWordsCompany = getWords("company");
$strWordsShow = getWords("show");
$strWordsDivision = getWords("division");
$strWordsDepartment = getWords("department");
$strWordsSection = getWords("section");
$strWordsSubSection = getWords("subsection");
$strWordsEmployeeStatus = getWords("employee status");
$strWordsActive = getWords("active");
$strWordsOutdated = getWords("outdated");
$strWordsSalary = getWords("salary");
$strWordsActive = getWords("active");
$strConfirmSave = getWords("save");
$strConfirmDelete = getWords("delete");
$DataGrid = "";
$strDataDetail = "";
$strHidden = "";
$intTotalData = 0;
$strButtons = "";
$strButtonsTop = "";
//----------------------------------------------------------------------
//--- DAFTAR FUNSI------------------------------------------------------
// fungsi untuk menampilkan data
function getData($db)
{
    //global $words;
    global $dataPrivilege;
    global $bolCanEdit, $bolCanDelete, $bolCanApprove, $bolCanCheck, $bolCanAcknowledge;
    global $f;
    global $myDataGrid;
    global $DataGrid;
    global $strKriteriaCompany;
    global $strKriteria;
    if ($db->connect()) {
        $arrData = $f->getObjectValues();
        $strKriteria = "";
        $strDateFrom = $arrData['dataDateFrom'];
        $arrDate = explode("/", $strDateFrom);
        $strDateFrom = $arrDate[2] . "-" . $arrDate[0] . "-" . $arrDate[1];
        $strDateThru = $arrData['dataDateThru'];
        $arrDate = explode("/", $strDateThru);
        $strDateThru = $arrDate[2] . "-" . $arrDate[0] . "-" . $arrDate[1];
        //$strDateFrom = $arrData['dataDateFrom'];
        //$strDateThru = $arrData['dataDateThru'];
        $strIDEmployee = getIDEmployee($db, $arrData['dataEmployee']);
        // GENERATE CRITERIA
        if ($arrData['dataEmployee'] != "") {
            $strKriteria .= "AND employee_id = '" . $arrData['dataEmployee'] . "'";
        }
        if ($arrData['dataPosition'] != "") {
            $strKriteria .= "AND position_code = '" . $arrData['dataPosition'] . "'";
        }
        if ($arrData['dataBranch'] != "") {
            $strKriteria .= "AND branch_code = '" . $arrData['dataBranch'] . "'";
        }
        if ($arrData['dataGrade'] != "") {
            $strKriteria .= "AND grade_code = '" . $arrData['dataGrade'] . "'";
        }
        if ($arrData['dataEmployeeStatus'] != "") {
            $strKriteria .= "AND employee_status = '" . $arrData['dataEmployeeStatus'] . "'";
        }
        if ($arrData['dataActive'] != "") {
            $strKriteria .= "AND active = '" . $arrData['dataActive'] . "'";
        }
        /*if ($arrData['dataRequestStatus']!= "") {
          $strKriteria .= "AND status = '".$arrData['dataRequestStatus']."'";
        }*/
        if ($arrData['dataDivision'] != "") {
            $strKriteria .= "AND division_code = '" . $arrData['dataDivision'] . "'";
        }
        if ($arrData['dataDepartment'] != "") {
            $strKriteria .= "AND department_code = '" . $arrData['dataDepartment'] . "'";
        }
        if ($arrData['dataSection'] != "") {
            $strKriteria .= "AND section_code = '" . $arrData['dataSection'] . "'";
        }
        if ($arrData['dataSubSection'] != "") {
            $strKriteria .= "AND sub_section_code = '" . $arrData['dataSubSection'] . "'";
        }
        $strKriteria .= "AND active = '1'";
        $strKriteria .= $strKriteriaCompany;
        $myDataGrid = new cDataGrid("formData", "DataGrid1", "100%", "100%", false, true, false);
        $myDataGrid->caption = getWords(
            strtoupper(vsprintf(getWords("list of %s"), getWords($dataPrivilege['menu_name'])))
        );
        $myDataGrid->setAJAXCallBackScript(basename($_SERVER['PHP_SELF']));
        $myDataGrid->setCriteria($strKriteria);
        //$myDataGrid->addColumnCheckbox(new DataGrid_Column("chkID", "id", array('width' => '30'), array('align'=>'center', 'nowrap' => '')), true /*bolDisableSelfStatusChange*/);
        $myDataGrid->pageSortBy = "attendance_date";
        $myDataGrid->addColumnNumbering(
            new DataGrid_Column("", "", ['rowspan' => '2', 'width' => '30'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("date"), "attendance_date2", ['rowspan' => '2'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("day"),
                "attendance_date",
                ['rowspan' => '2'],
                ['nowrap' => ''],
                true,
                false,
                "",
                "printWDay()"
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("id"), "employee_id", ['rowspan' => '2'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("employee name"), "employee_name", ['rowspan' => '2'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("division"), "division_name", ['rowspan' => '2'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("department"), "department_name", ['rowspan' => '2'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("section"), "section_name", ['rowspan' => '2'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("absence"),
                "absence_code",
                ['rowspan' => '2'],
                ['style' => 'color:red;font-size:11;font-weight:bold', 'nowrap' => '']
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("shift"), "shift_code", ['rowspan' => '2'], ['nowrap' => ''])
        );
        $myDataGrid->addSpannedColumn(getWords("attendance"), 2);
        //tampilan untuk datagrid di browser
        if (!isset($_REQUEST['btnExportXLS'])) {
            $myDataGrid->addColumn(
                new DataGrid_Column(
                    getWords("start"),
                    "attendance_start",
                    ['width' => '75'],
                    ['align' => 'center'],
                    false,
                    false,
                    "",
                    "printInput()",
                    "",
                    false
                )
            );
            $myDataGrid->addColumn(
                new DataGrid_Column(
                    getWords("finish"),
                    "attendance_finish",
                    ['width' => '75'],
                    ['align' => 'center'],
                    false,
                    false,
                    "",
                    "printInput()",
                    "",
                    false
                )
            );
        } else {
            //tampilan untuk datagrid di excel
            $myDataGrid->addColumn(
                new DataGrid_Column(
                    getWords("start"),
                    "attendance_start",
                    ['width' => '75', 'style' => 'display:none'],
                    ['align' => 'center', 'style' => 'display:none'],
                    false,
                    false,
                    "",
                    "",
                    "",
                    true
                )
            );
            $myDataGrid->addColumn(
                new DataGrid_Column(
                    getWords("finish"),
                    "attendance_finish",
                    ['width' => '75', 'style' => 'display:none'],
                    ['align' => 'center', 'style' => 'display:none'],
                    false,
                    false,
                    "",
                    "",
                    "",
                    true
                )
            );
        }
        $myDataGrid->addSpannedColumn(getWords("normal"), 2);
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("start"),
                "normal_start",
                "",
                ['nowrap' => ''],
                true,
                true,
                "",
                "",
                "string",
                true,
                10,
                true
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("finish"),
                "normal_finish",
                "",
                ['nowrap' => ''],
                true,
                true,
                "",
                "",
                "string",
                true,
                10,
                true
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("late"),
                "late",
                ['rowspan' => '2'],
                ['style' => 'color:red;font-size:11;font-weight:bold', 'nowrap' => ''],
                true,
                false,
                "",
                "formatTime()"
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("app. late"),
                "approved_late",
                ['rowspan' => '2', 'width' => '30'],
                ['nowrap' => ''],
                true,
                false,
                "",
                "formatTime()"
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("early"),
                "early",
                ['rowspan' => '2'],
                ['style' => 'color:red;font-size:11;font-weight:bold', 'nowrap' => ''],
                true,
                false,
                "",
                "formatTime()"
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("app. early"),
                "approved_early",
                ['rowspan' => '2', 'width' => '30'],
                ['nowrap' => ''],
                true,
                false,
                "",
                "formatTime()"
            )
        );
        $myDataGrid->addSpannedColumn(getWords("early overtime"), 2);
        $myDataGrid->addColumn(new DataGrid_Column(getWords("start"), "overtime_start_early", "", ['nowrap' => '']));
        $myDataGrid->addColumn(new DataGrid_Column(getWords("finish"), "overtime_finish_early", "", ['nowrap' => '']));
        $myDataGrid->addSpannedColumn(getWords("afternoon overtime"), 2);
        $myDataGrid->addColumn(new DataGrid_Column(getWords("start"), "overtime_start", "", ['nowrap' => '']));
        $myDataGrid->addColumn(new DataGrid_Column(getWords("finish"), "overtime_finish", "", ['nowrap' => '']));
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("total ot"),
                "ot",
                ['rowspan' => '2'],
                ['nowrap' => ''],
                true,
                false,
                "",
                "formatTime()"
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getWords("calculated ot"),
                "calculated_ot",
                ['rowspan' => '2'],
                ['nowrap' => ''],
                true,
                false,
                "",
                "formatTime()"
            )
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("source"), "data_source", ['rowspan' => '2'], ['nowrap' => ''])
        );
        foreach ($arrData AS $key => $value) {
            $myDataGrid->strAdditionalHtml .= generateHidden($key, $value, "");
        }
        if (!isset($_REQUEST['btnExportXLS'])) {
            if ($bolCanEdit) {
                $myDataGrid->addButton(
                    "btnSave",
                    "btnSave",
                    "submit",
                    getWords("save"),
                    "onClick=\"javascript:return myClient.confirmSave();\"",
                    "saveData()"
                );
            }
        }
        $myDataGrid->addButtonExportExcel(
            getWords("export excel"),
            $dataPrivilege['menu_name'] . ".xls",
            getWords($dataPrivilege['menu_name'])
        );
        $myDataGrid->setPageLimit("all");
        $myDataGrid->getRequest();
        //$myDataGrid->hasGrandTotal = true;
        //get approved late or early
        $tblAbsencePartial = new cHrdAbsencePartial();
        $strCriteria = "partial_absence_date BETWEEN '$strDateFrom' AND '$strDateThru' AND status >= " . REQUEST_STATUS_APPROVED . " ";
        if (getIDEmployee($db, $arrData['dataEmployee'])) {
            $strCriteria .= "AND id_employee = '" . getIDEmployee($db, $arrData['dataEmployee']) . "' ";
        } else {
            $strCriteria .= "";
        }
        $dataAbsencePartial = $tblAbsencePartial->findAll($strCriteria, "", "", null, 1, "id");
        foreach ($dataAbsencePartial as $strID => $detailAbsencePartial) {
            $arrAbsencePartial[$detailAbsencePartial['partial_absence_date']][$detailAbsencePartial['id_employee']][$detailAbsencePartial['partial_absence_type']] = $detailAbsencePartial;
        }
        //get absence which cancels late/early
        $strSQL = "SELECT t1.*, cancel_partial_absence, status FROM hrd_absence_detail AS t1 ";
        $strSQL .= "LEFT JOIN hrd_absence_type AS t2 ON t1.absence_type = t2.code ";
        $strSQL .= "LEFT JOIN hrd_absence AS t3 ON t1.id_absence = t3.id ";
        $strSQL .= "WHERE absence_date BETWEEN '$strDateFrom' AND '$strDateThru' AND cancel_partial_absence = TRUE AND status >= " . REQUEST_STATUS_APPROVED . " ";
        $resDb = $db->execute($strSQL);
        while ($rowDb = $db->fetchrow($resDb)) {
            $arrCancelLate[$rowDb['absence_date']][$rowDb['id_employee']] = true;
        }
        $intRows = 0;
        $strResult = "";
        $dataset = [];
        $objAttendanceClass = new clsAttendanceClass($db);
        $objAttendanceClass->resetAttendance();
        $objAttendanceClass->setFilter($strDateFrom, $strDateThru, $strIDEmployee, $strKriteria);
        $objAttendanceClass->getAttendanceResource();
        $objToday = new clsAttendanceInfo($db);
        $intLate = 0;
        $intEarly = 0;
        $intTotalLate = 0;
        $intTotalEarly = 0;
        $intApprovedLate = 0;
        $intApprovedEarly = 0;
        $intTotalApprovedLate = 0;
        $intTotalApprovedEarly = 0;
        $intTotalOT = 0;
        $intTotalCalculatedOT = 0;
        $strCurrDate = $strDateFrom;
        while (dateCompare($strCurrDate, $strDateThru) <= 0) {
            $arrAttendance = (isset($objAttendanceClass->arrAttendance[$strCurrDate])) ? $objAttendanceClass->arrAttendance[$strCurrDate] : [];
            foreach ($objAttendanceClass->arrEmployee as $strIDEmployee => $arrEmployee) {
                $objToday->newInfo($strIDEmployee, $strCurrDate);
                $objToday->initAttendanceInfo($objAttendanceClass);
                if (isset($arrCancelLate[$strCurrDate][$strIDEmployee])) {
                    $intLate = "";
                    $intEarly = "";
                    $intApprovedLate = "";
                    $intApprovedEarly = "";
                } else {
                    if (isset($arrAbsencePartial[$strCurrDate][$strIDEmployee])) {
                        if (isset($arrAbsencePartial[$strCurrDate][$strIDEmployee][PARTIAL_ABSENCE_LATE]) && is_numeric(
                                $arrAbsencePartial[$strCurrDate][$strIDEmployee][PARTIAL_ABSENCE_LATE]['approved_duration']
                            )
                        ) {
                            $intLate = $objToday->intLate - $arrAbsencePartial[$strCurrDate][$strIDEmployee][PARTIAL_ABSENCE_LATE]['approved_duration'];
                            $intApprovedLate = $arrAbsencePartial[$strCurrDate][$strIDEmployee][PARTIAL_ABSENCE_LATE]['approved_duration'];
                            $intLate = ($intLate < 0) ? 0 : "";
                        } else {
                            $intLate = ($objToday->intLate == 0) ? "" : $objToday->intLate;
                            $intApprovedLate = "";
                        }
                        if (isset($arrAbsencePartial[$strCurrDate][$strIDEmployee][PARTIAL_ABSENCE_EARLY]) && is_numeric(
                                $arrAbsencePartial[$strCurrDate][$strIDEmployee][PARTIAL_ABSENCE_EARLY]['approved_duration']
                            )
                        ) {
                            $intEarly = $objToday->intEarly - $arrAbsencePartial[$strCurrDate][$strIDEmployee][PARTIAL_ABSENCE_EARLY]['approved_duration'];
                            $intApprovedEarly = $arrAbsencePartial[$strCurrDate][$strIDEmployee][PARTIAL_ABSENCE_EARLY]['approved_duration'];
                            $intEarly = ($intEarly < 0) ? 0 : "";
                        } else {
                            $intEarly = ($objToday->intEarly == 0) ? "" : $objToday->intEarly;
                            $intApprovedEarly = "";
                        }
                    } else {
                        $intLate = ($objToday->intLate == 0) ? "" : $objToday->intLate;
                        $intEarly = ($objToday->intEarly == 0) ? "" : $objToday->intEarly;
                        $intApprovedLate = "";
                        $intApprovedEarly = "";
                    }
                }
                $arrDate = explode("-", $strCurrDate);
                $printedCurrDate = $arrDate[1] . "/" . $arrDate[2] . "/" . $arrDate[0];
                $dataset[] = [
                    "attendance_date"       => $strCurrDate,
                    "attendance_date2"      => $printedCurrDate,
                    "id_employee"           => $strIDEmployee,
                    "employee_id"           => $arrEmployee['employee_id'],
                    "employee_name"         => $arrEmployee['employee_name'],
                    "division_code"         => $arrEmployee['division_code'],
                    "division_name"         => $arrEmployee['division_name'],
                    "department_code"       => $arrEmployee['department_code'],
                    "department_name"       => $arrEmployee['department_name'],
                    "section_code"          => $arrEmployee['section_code'],
                    "section_name"          => $arrEmployee['section_name'],
                    "absence_code"          => $objToday->strAbsenceCode,
                    "shift_code"            => $objToday->strShiftCode,
                    "attendance_start"      => $objToday->strAttendanceStart,
                    "attendance_finish"     => $objToday->strAttendanceFinish,
                    "normal_start"          => $objToday->strNormalStart,
                    "normal_finish"         => $objToday->strNormalFinish,
                    "late"                  => $intLate,
                    "early"                 => $intEarly,
                    "approved_late"         => $intApprovedLate,
                    "approved_early"        => $intApprovedEarly,
                    "overtime_start_early"  => $objToday->strOvertimeStartEarly,
                    "overtime_finish_early" => $objToday->strOvertimeFinishEarly,
                    "overtime_start"        => $objToday->strOvertimeStart,
                    "overtime_finish"       => $objToday->strOvertimeFinish,
                    "normal_finish"         => $objToday->strNormalFinish,
                    "ot"                    => $objToday->fltTotalOT,
                    "calculated_ot"         => $objToday->totOTCalculated,
                    "data_source"           => $objToday->strDataSource
                ];
            }
            $strCurrDate = getNextDate($strCurrDate);
            $intTotalLate += ((is_numeric($intLate)) ? $intLate : 0);
            $intTotalEarly += ((is_numeric($intEarly)) ? $intEarly : 0);
            $intTotalApprovedLate += ((is_numeric($intApprovedLate)) ? $intApprovedLate : 0);
            $intTotalApprovedEarly += ((is_numeric($intApprovedEarly)) ? $intApprovedEarly : 0);
            $intTotalOT += ((is_numeric($objToday->fltTotalOT)) ? $objToday->fltTotalOT : 0);
            $intTotalCalculatedOT += ((is_numeric($objToday->fltOTCalculated)) ? $objToday->fltOTCalculated : 0);
        }
        $intTotalData = $myDataGrid->totalData = count($dataset);
        //bind Datagrid with array dataset
        $myDataGrid->bind($dataset);
        return $myDataGrid->render();
    }
} // getData
function printWDay($params)
{
    global $bolPrint;
    extract($params);
    $strDay = getNamaHariSingkat(getWDay($value));
    return (($strDay == "Sat" || $strDay == "Sun") && !$bolPrint) ? "<strong><font color=red size=-1>$strDay</font></strong>" : $strDay;
}

function printInput($params)
{
    extract($params);
    return generateInput("_|$field" . "|" . $record['attendance_date'] . "|" . $record['id_employee'], $value);
}

function saveData()
{
    global $myDataGrid;
    global $error;
    global $db;
    global $strKriteria, $strDateFrom, $strDateThru;
    $strError = "";
    $bolSuccess = true;
    $strModifiedByID = $_SESSION['sessionUserID'];
    $arrData = $myDataGrid->checkboxes;
    foreach ($arrData as $key => $value) {
        if ($key[0] == "_") {
            $temp = explode("|", $key);
            $arrAttendance[$temp[2]][$temp[3]][$temp[1]] = $value;
        }
    }
    $objAttendanceClass = new clsAttendanceClass($db);
    foreach ($arrAttendance as $strDate => $arrEmpAttendance) {
        $objAttendanceClass->resetAttendance();
        $objAttendanceClass->setFilter($strDate, $strDate, "", $strKriteria);
        $objAttendanceClass->getAttendanceResource();
        $objToday = new clsAttendanceInfo($db);
        foreach ($arrEmpAttendance as $strIDEmployee => $arrTimeIO) {
            $objToday->newInfo($strIDEmployee, $strDate);
            $objToday->initAttendanceInfo($objAttendanceClass);
            $objToday->strAttendanceStart = $arrTimeIO['attendance_start'];
            $objToday->strAttendanceFinish = $arrTimeIO['attendance_finish'];
            $objToday->bolYesterday = true;
            $objToday->calculateDuration();
            $objToday->calculateLate();
            $objToday->calculateOvertime();
            $objToday->saveCurrentAttendance($objAttendanceClass);
        }
    }
    syncShiftAttendance($db, $strDateFrom, $strDateThru, $strKriteria);
    syncOvertimeApplication($db, $strDateFrom, $strDateThru, "", $strKriteria);
    //$myDataGrid->message = $tblAttendance->strMessage;
} // saveData
//----------------------------------------------------------------------
//----MAIN PROGRAM -----------------------------------------------------
$strInfo = "";
$intDefaultStart = "08:00";
$intDefaultFinish = "17:00";
$db = new CdbClass;
if ($db->connect()) {
    // $a = getDataListPosition(getInitialValue("Position"), true, "<option value=\"aa\">aa</option>");
    // print_r($a);
    // die();
    getUserEmployeeInfo();
    $arrUserList = getAllUserInfo($db);
    $strDataID = getPostValue('dataID');
    scopeData(
        $strDataEmployee,
        $strDataSubSection,
        $strDataSection,
        $strDataDepartment,
        $strDataDivision,
        $_SESSION['sessionUserRole'],
        $arrUserInfo
    );
    //generate form untuk select trip type
    //trip type harus dipilih dulu supaya jenis2 trip allowance dapat ditentukan
    $f = new clsForm("formFilter", 3, "100%", "");
    $f->caption = strtoupper($strWordsFILTERDATA);
    $f->addInput(
        getWords("date from"),
        "dataDateFrom",
        ($strDateFrom = getInitialValue("DateFrom", date("m") . "/01/" . date("Y"))),
        ["style" => "width:$strDateWidth"],
        "date",
        false,
        true,
        true
    );
    $f->addInput(
        getWords("date thru"),
        "dataDateThru",
        ($strDateThru = getInitialValue("DateThru", date("m/d/Y"))),
        ["style" => "width:$strDateWidth"],
        "date",
        false,
        true,
        true
    );
    $f->addInputAutoComplete(
        getWords("employee"),
        "dataEmployee",
        getDataEmployee(getInitialValue("Employee", null, $strDataEmployee)),
        "style=width:$strDefaultWidthPx " . $strEmpReadonly,
        "string",
        false,
        true,
        true,
        "",
        "",
        true,
        null,
        "hrd_ajax_source.php?action=getemployee"
    );
    $f->addLabelAutoComplete("", "dataEmployee", "");
    // $f->addSelect(getWords("request status"), "dataRequestStatus", getDataListRequestStatus(getInitialValue("RequestStatus"), true, array("value" => "", "text" => "", "selected" => true)), array("style" => "width:$strDefaultWidthPx"), "", false, false);
    $f->addLiteral("", "", "");
    $f->addSelect(
        getWords("branch"),
        "dataBranch",
        getDataListBranch(getInitialValue("Branch"), true),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false
    );
    $f->addSelect(
        getWords("level"),
        "dataPosition",
        getDataListPosition(getInitialValue("Position"), true),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false
    );
    $f->addSelect(
        getWords("grade"),
        "dataGrade",
        getDataListSalaryGrade(getInitialValue("Grade"), true),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false
    );
    $f->addSelect(
        getWords("status"),
        "dataEmployeeStatus",
        getDataListEmployeeStatus(
            getInitialValue("EmployeeStatus"),
            true,
            ["value" => "", "text" => "", "selected" => true]
        ),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false
    );
    $f->addSelect(
        getWords("active"),
        "dataActive",
        getDataListEmployeeActive(
            getInitialValue("Active"),
            true,
            ["value" => "", "text" => "", "selected" => true]
        ),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false
    );
    $f->addLiteral("", "", "");
    $f->addSelect(
        getWords("company"),
        "dataCompany",
        getDataListCompany($strDataCompany, $bolCompanyEmptyOption, $arrCompanyEmptyData, $strKriteria2),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false
    );
    $f->addSelect(
        getWords("division"),
        "dataDivision",
        getDataListDivision(getInitialValue("Division", "", $strDataDivision), true),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false,
        ($ARRAY_DISABLE_GROUP['division'] == "")
    );
    $f->addSelect(
        getWords("department "),
        "dataDepartment",
        getDataListDepartment(getInitialValue("Department", "", $strDataDepartment), true),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false,
        ($ARRAY_DISABLE_GROUP['department'] == "")
    );
    $f->addSelect(
        getWords("section"),
        "dataSection",
        getDataListSection(getInitialValue("Section", "", $strDataSection), true),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false,
        ($ARRAY_DISABLE_GROUP['section'] == "")
    );
    $f->addSelect(
        getWords("sub section"),
        "dataSubSection",
        getDataListSubSection(getInitialValue("SubSection", "", $strDataSubSection), true),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false,
        ($ARRAY_DISABLE_GROUP['sub_section'] == "")
    );
    $f->addSubmit("btnShow", getWords("show"), "", true, true, "", "", "");
    $formFilter = $f->render();
    if (validStandardDate_wal($strDateFrom) && validStandardDate_wal(
            $strDateThru
        ) && (isset($_REQUEST['btnSave']) || isset($_REQUEST['btnShow']) || isset($_REQUEST['btnExportXLS']))
    ) {
        //getData($db);
        // tampilkan hanya jika ada permintaan dan data tanggalnya tepat
        $myDataGrid = new cDataGrid("formData", "DataGrid", "100%", "100%", false, false, false);
        $myDataGrid->caption = $dataPrivilege['menu_name'];
        $DataGrid = getData($db);
        $strHidden .= "<input type=hidden name=btnShow value=show>";
    }
}
$tbsPage = new clsTinyButStrong;
//write this variable in every page
$strPageTitle = getWords($dataPrivilege['menu_name']);
if (trim($dataPrivilege['icon_file']) == "") {
    $pageIcon = "../images/icons/blank.gif";
} else {
    $pageIcon = "../images/icons/" . $dataPrivilege['icon_file'];
}
$strPageDesc = getWords('employee attendance entry');
$pageHeader = pageHeader($pageIcon, $strPageTitle, $strPageDesc);
$pageSubMenu = attendanceSubMenu($strWordsEntryAttendance);
$strTemplateFile = getTemplate(str_replace(".php", ".html", basename($_SERVER['PHP_SELF'])));
//------------------------------------------------
//Load Master Template
$tbsPage->LoadTemplate($strMainTemplate);
$tbsPage->Show();
?>
