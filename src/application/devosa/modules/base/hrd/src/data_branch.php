<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('../global/common_data.php');
doInclude('plugins/datagrid2/datagrid.php');
doInclude('plugins/form2/form2.php');
doInclude('libraries/classes/hrd/hrd_branch.php');
$dataPrivilege = getDataPrivileges(
    basename($_SERVER['PHP_SELF']),
    $bolCanView,
    $bolCanEdit,
    $bolCanDelete,
    $bolCanApprove
);
if (!$bolCanView) {
    die(accessDenied($_SERVER['HTTP_REFERER']));
}
$db = new CdbClass;
$strDataID = getPostValue('dataID');
$isNew = ($strDataID == "");
$strSet = "branch";
$i = 1;
if ($bolCanEdit) {
    $f = new clsForm("formInput", 1, "100%", "");
    $f->caption = strtoupper($strWordsINPUTDATA);
    $f->addHidden("dataID", $strDataID);
    $f->addInput(
        getWords("branch code"),
        "dataCode",
        "",
        ["size" => 30, "maxlength" => 31],
        "string",
        true,
        true,
        true
    );
    $f->addInput(
        getWords("branch name"),
        "dataName",
        "",
        ["size" => 30, "maxlength" => 127],
        "string",
        true,
        true,
        true
    );
    $f->addInput(
        getWords("local time difference (min)"),
        "dataLocalTimeDifference",
        "",
        ["size" => 30, "maxlength" => 3],
        "integer",
        false,
        true
    );
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        //rubah Outlet ke Outsource, agar tidak merubah setting, maka hanya tampilan yang dirubah
        $tempvalue = getSetting($strSet . $i . "_allowance_name");
        $tempvalue = preg_replace("/Outlet/", "Outsource", $tempvalue);
        $f->addInput($tempvalue, $strSet . $i, "0", ["size" => 30, "maxlength" => 10], "numeric", false, true, true);
    }
    $f->addSubmit(
        "btnSave",
        getWords("save"),
        ["onClick" => "javascript:myClient.confirmSave();"],
        true,
        true,
        "",
        "",
        "saveData()"
    );
    $f->addButton("btnAdd", getWords("add new"), ["onClick" => "javascript:myClient.editData('0');"]);
    $formInput = $f->render();
} else {
    $formInput = "";
}
$myDataGrid = new cDataGrid("formData", "DataGrid1");
$myDataGrid->caption = strtoupper($strWordsLISTOF . " " . getWords($dataPrivilege['menu_name']));
$myDataGrid->setAJAXCallBackScript(basename($_SERVER['PHP_SELF']));
$myDataGrid->addColumnCheckbox(
    new DataGrid_Column("chkID", "id", ['width' => '30'], ['align' => 'center', 'nowrap' => ''])
);
$myDataGrid->addColumnNumbering(new DataGrid_Column(getWords("no"), "", ['width' => '30'], ['nowrap' => '']));
$myDataGrid->addColumn(
    new DataGrid_Column(getWords("branch code"), "branch_code", ['width' => '150'], ['nowrap' => ''])
);
$myDataGrid->addColumn(new DataGrid_Column(getWords("branch name"), "branch_name", ""));
$myDataGrid->addColumn(
    new DataGrid_Column(
        getWords("local time difference (min)"),
        "local_time_difference",
        ['width' => '150'],
        ['nowrap' => '']
    )
);
for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
    //rubah Outlet ke Outsource, agar tidak merubah setting, maka hanya tampilan yang dirubah
    $tempvalue = getSetting($strSet . $i . "_allowance_name");
    $tempvalue = preg_replace("/Outlet/", "Outsource", $tempvalue);
    $myDataGrid->addColumn(
        new DataGrid_Column(
            $tempvalue,
            $ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i,
            ['width' => '100'],
            ['align' => 'right'],
            true,
            true,
            "",
            "formatNumber()"
        )
    );
}
if ($bolCanEdit) {
    $myDataGrid->addColumn(
        new DataGrid_Column(
            "",
            "",
            ['width' => '60'],
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
if ($bolCanDelete) {
    $myDataGrid->addSpecialButton(
        "btnDelete",
        "btnDelete",
        "submit",
        getWords("delete"),
        "onClick=\"javascript:return myClient.confirmDelete();\"",
        "deleteData()"
    );
}
$myDataGrid->addButtonExportExcel(
    getWords("export excel"),
    $dataPrivilege['menu_name'] . ".xls",
    getWords($dataPrivilege['menu_name'])
);
$myDataGrid->getRequest();
//--------------------------------
//get Data and set to Datagrid's DataSource by set the data binding (bind method)
$strSQLCOUNT = "SELECT COUNT(*) AS total FROM hrd_branch ";
$strSQL = "SELECT * FROM hrd_branch ";
$myDataGrid->totalData = $myDataGrid->getTotalData($db, $strSQLCOUNT);
$dataset = $myDataGrid->getData($db, $strSQL);
//bind Datagrid with array dataset
$myDataGrid->bind($dataset);
$DataGrid = $myDataGrid->render();
$strConfirmSave = getWords("do you want to save this entry?");
$tbsPage = new clsTinyButStrong;
//write this variable in every page
$strPageTitle = getWords($dataPrivilege['menu_name']);
$pageIcon = "../images/icons/" . $dataPrivilege['icon_file'];
$strPageDesc = getWords("branch data management");
$pageHeader = pageHeader($pageIcon, $strPageTitle, $strPageDesc);
$strTemplateFile = getTemplate(str_replace(".php", ".html", basename($_SERVER['PHP_SELF'])));
//------------------------------------------------
//Load Master Template
$tbsPage->LoadTemplate($strMainTemplate);
$tbsPage->Show();
//--------------------------------------------------------------------------------
function printEditLink($params)
{
    global $ARRAY_ALLOWANCE_SET, $strSet;
    extract($params);
    $strResult = "";
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        $strResult .= "<input type=hidden name='detailAllowance" . $i . "_$counter' id='detailAllowance" . $i . "_$counter' value='" . $record[$ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i] . "' />";
    }
    return "
      <input type=hidden name='detailID$counter' id='detailID$counter' value='" . $record['id'] . "' />
      <input type=hidden name='detailCode$counter' id='detailCode$counter' value='" . $record['branch_code'] . "' />
      <input type=hidden name='detailName$counter' id='detailName$counter' value='" . $record['branch_name'] . "' />
      <input type=hidden name='detailLocalTimeDifference$counter' id='detailLocalTimeDifference$counter' value='" . $record['local_time_difference'] . "' />
      <a href=\"javascript:myClient.editData('$counter" . "|$strSet|" . MAX_ALLOWANCE_SET . "')\">" . getWords(
        'edit'
    ) . "</a>" . $strResult;
}

function printFormat($params)
{
    extract($params);
    return number_format($record['branch']);
}

// fungsi untuk menyimpan data
function saveData()
{
    global $f;
    global $isNew;
    global $strSet;
    global $ARRAY_ALLOWANCE_SET;
    $strmodified_byID = $_SESSION['sessionUserID'];
    $dataHrdBranch = new cHrdBranch();
    $data = [
        "branch_code"           => $f->getValue('dataCode'),
        "local_time_difference" => $f->getValue('dataLocalTimeDifference'),
        "branch_name"           => $f->getValue('dataName')
    ];
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        $data[$ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i] = $f->getValue($strSet . $i);
    }
    // simpan data -----------------------
    $bolSuccess = false;
    if ($isNew) {
        // data baru
        $bolSuccess = $dataHrdBranch->insert($data);
    } else {
        $bolSuccess = $dataHrdBranch->update(/*pk*/
            "id='" . $f->getValue('dataID') . "'", /*data to update*/
            $data
        );
    }
    if ($bolSuccess) {
        if ($isNew) {
            $f->setValue('dataID', $dataHrdBranch->getLastInsertId());
        } else {
            $f->setValue('dataID', $f->getValue('dataID'));
        }
    }
    if ($bolSuccess) {
        $f->message = $dataHrdBranch->strMessage;
    } else {
        $f->message = "Duplikasi Data Outlet Code";
    }
} // saveData
// fungsi untuk menghapus data
function deleteData()
{
    global $myDataGrid;
    $arrKeys = [];
    foreach ($myDataGrid->checkboxes as $strValue) {
        $arrKeys['id'][] = $strValue;
    }
    $dataHrdBranch = new cHrdBranch();
    $dataHrdBranch->deleteMultiple($arrKeys);
    $myDataGrid->message = $dataHrdBranch->strMessage;
} //deleteData
?>