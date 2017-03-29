<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('form_object.php');
doInclude('../global/common_data.php');
doInclude('plugins/datagrid2/datagrid.php');
doInclude('plugins/form2/form2.php');
doInclude('libraries/classes/ga/consumable_stock_out.php');
//================ END INCLUDE=====================================
$dataPrivilege = getDataPrivileges(
    basename($_SERVER['PHP_SELF']),
    $bolCanView,
    $bolCanEdit,
    $bolCanDelete,
    $bolCanApprove,
    $bolCanCheck
);
if (!$bolCanView) {
    die(accessDenied($_SERVER['HTTP_REFERER']));
}
//INISIALISASI---------------------------------------------------------------------------------------------------------------
$strWordsFILTERDATA = getWords("Form Filter Data");
$strWordsEntryConsumableStockOut = getWords("entry consumable stock out");
$strWordsConsumableStockOutList = getWords("consumable stock out list");
// Get tanggal hari ini
$strNow = date("Y-m-d");
$DataGrid = "";
$myDataGrid = new cDataGrid("formData", "DataGrid1", "100%", "100%", false, true, false);
//DAFTAR FUNGSI--------------------------------------------------------------------------------------------------------------
function getData($db)
{
    global $dataPrivilege, $bolCanEdit, $bolCanDelete, $bolCanApprove, $bolCanCheck;
    global $f;
    global $DataGrid;
    global $myDataGrid;
    global $strKriteriaCompany;
    //global $arrUserInfo
    $arrData = $f->getObjectValues();
    $strKriteria = "";
    // GENERATE CRITERIA
    if ($arrData['dataIdItem'] != "") {
        $strKriteria .= "AND cso.id_item = '" . $arrData['dataIdItem'] . "'";
    }
    if ($arrData['dataDepartmentCode'] != "") {
        $strKriteria .= "AND cso.department_code = '" . $arrData['dataDepartmentCode'] . "'";
    }
    if ($arrData['dataTransactionDate'] != "") {
        $strKriteria .= "AND cso.transaction_date = '" . $arrData['dataTransactionDate'] . "'";
    }
    if ($arrData['dataItemAmount'] != "") {
        $strKriteria .= "AND cso.item_amount = '" . $arrData['dataItemAmount'] . "'";
    }
    if ($arrData['dataDocNo'] != "") {
        $strKriteria .= "AND cso.remark = '" . $arrData['dataRemark'] . "'";
    }
    if ($db->connect()) {
        $myDataGrid = new cDataGrid("formData", "DataGrid1");
        $myDataGrid->caption = getWords(
            strtoupper(vsprintf(getWords("list of %s"), getWords($dataPrivilege['menu_name'])))
        );
        $myDataGrid->setAJAXCallBackScript(basename($_SERVER['PHP_SELF']));
        $myDataGrid->setCriteria($strKriteria);
        $myDataGrid->addColumnCheckbox(
            new DataGrid_Column("chkID", "id", ['width' => '30'], ['align' => 'center', 'nowrap' => '']),
            false
        );
        //-------------------------------------- BEGIN Data Grid---------------------------------------------------------------------------------//
        $myDataGrid->addColumnNumbering(new DataGrid_Column("No", "", ['width' => '30'], ['nowrap' => '']));
        //$myDataGrid->addColumn(new DataGrid_Column(getWords("employee name"), "employee_name", array('width' => '100'), array('nowrap' => '')));
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("Item"), "item_name", ['width' => '100'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("department code"), "department_code", ['width' => '100'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("transaction Date"), "transaction_date", ['width' => '100'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(
            new DataGrid_Column(getWords("item amount"), "item_amount", ['width' => '50'], ['nowrap' => ''])
        );
        $myDataGrid->addColumn(new DataGrid_Column(getWords("remark"), "remark", ['width' => '150'], ['nowrap' => '']));
        if (!isset($_POST['btnExportXLS']) && $bolCanEdit) {
            $myDataGrid->addColumn(
                new DataGrid_Column(
                    "",
                    "",
                    ["width" => "60"],
                    ['align' => 'center', 'nowrap' => ''],
                    false,
                    false,
                    "",
                    "printEditLink()",
                    "",
                    false /*show in excel*/
                )
            );
        }
        foreach ($arrData AS $key => $value) {
            $myDataGrid->strAdditionalHtml .= generateHidden($key, $value, "");
        }
        //-----------------BEGIN Jika Punya Hak Akses Hapus-----------------------------//
        if ($bolCanDelete) {
            $myDataGrid->addSpecialButton(
                "btnDelete",
                "btnDelete",
                "submit",
                "Delete",
                "onClick=\"javascript:return myClient.confirmDelete();\"",
                "deleteData()"
            );
        }
        //---------------- END Jika Punya Hak Akses Hapus-------------------------//
        $myDataGrid->addButtonExportExcel(
            "Export Excel",
            $dataPrivilege['menu_name'] . ".xls",
            getWords($dataPrivilege['menu_name'])
        );
        $myDataGrid->getRequest();
        //get Data and set to Datagrid's DataSource by set the data binding (bind method)
        $strSQLCOUNT = "SELECT COUNT(*) AS total FROM ga_consumable_stock_out AS cso LEFT JOIN ga_item AS i ON cso.id_item=i.id ";
        $strSQL = "SELECT i.item_name, cso.* FROM ga_consumable_stock_out as cso LEFT JOIN ga_item AS i ON cso.id_item=i.id";
        $myDataGrid->totalData = $myDataGrid->getTotalData($db, $strSQLCOUNT);
        $dataset = $myDataGrid->getData($db, $strSQL);
        //bind Datagrid with array dataset and branchCode
        $myDataGrid->bind($dataset);
        $DataGrid = $myDataGrid->render();
    } else {
        $DataGrid = "";
    }
    return $DataGrid;
}

//*********************************** FUNGSI TOMBOL EDIT******************************************
function printEditLink($params)
{
    extract($params);
    return "<a href=\"consumable_stock_out_edit.php?dataID=" . $record['id'] . "\">" . getWords('edit') . "</a>";
}

//******************************* END FUNGSI TOMBOL EDIT *******************************************
function deleteData()
{
    global $myDataGrid;
    $arrKeys = [];
    foreach ($myDataGrid->checkboxes as $strValue) {
        $arrKeys['id'][] = $strValue;
    }
    $tblDelete = new cGaConsumableStockOut();
    $tblDelete->deleteMultiple($arrKeys);
    $myDataGrid->message = $tblDelete->strMessage;
}

//************************************************END deleteData **************************************
//================================================== BEGIN MAIN PROGRAM =============================================================================
$db = new CdbClass;
if ($db->connect()) {
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
    $strReadonly = (scopeCBDataEntry($strDataEmployee, $_SESSION['sessionUserRole'], $arrUserInfo)) ? "readonly" : "";
    //generate form untuk select trip type
    $f = new clsForm("formFilter", 1, "100%", "");
    $f->caption = strtoupper($strWordsFILTERDATA);
    $f->addHidden("dataID", $strDataID);
    $f->addSelect(
        getWords("item"),
        "dataIdItem",
        getDataListItem(""),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false
    );
    $f->addSelect(
        getWords("department code"),
        "dataDepartmentCode",
        getDataListDepartment(""),
        ["style" => "width:$strDefaultWidthPx"],
        "",
        false
    );
    $f->addInput(
        getWords("transaction date"),
        "dataTransactionDate",
        null,
        ["style" => "width:$strDateWidth"],
        "date",
        false,
        true,
        true
    );
    $f->addInput(
        getWords("item amount"),
        "dataItemAmount",
        null,
        ["style" => "width:$strDateWidth"],
        "numeric",
        false,
        true,
        true
    );
    $f->addInput(
        getWords("remark"),
        "dataRemark",
        null,
        ["style" => "width:$strDateWidth"],
        "string",
        false,
        true,
        true
    );
    $f->addSubmit("btnShow", getWords("show"), "", true, true, "", "", "");
    $f->addButton(
        "btnAdd",
        getWords("Clear"),
        ["onClick" => "location.href='" . basename($_SERVER['PHP_SELF'] . "';")]
    );
    $formInput = $f->render();
    getData($db);
}
$tbsPage = new clsTinyButStrong;
//write this variable in every page
$strPageTitle = $dataPrivilege['menu_name'];
$pageIcon = "../images/icons/" . $dataPrivilege['icon_file'];
$strTemplateFile = getTemplate(str_replace(".php", ".html", basename($_SERVER['PHP_SELF'])));
//------------------------------------------------
//Load Master Template
$tbsPage->LoadTemplate($strMainTemplate);
$tbsPage->Show();
//============================================= END MAIN PROGRAM ==========================================================================================
?>