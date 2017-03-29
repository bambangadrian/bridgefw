<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('plugins/datagrid2/datagrid.php');
doInclude('plugins/form2/form2.php');
doInclude('libraries/classes/hrd/hrd_salary_grade.php');
doInclude('libraries/classes/hrd/hrd_employee.php');
doInclude('libraries/classes/hrd/hrd_organization.php');
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
$db = new CdbClass;
if ($db->connect()) {
    $dataHrdOrganization = new cHrdOrganization();
    $strDataID = getPostValue('dataID');
    $isNew = ($strDataID == "");
    $strSet = "grade";
    if ($bolCanEdit) {
        $f = new clsForm("formInput", 1, "100%", "");
        $f->caption = strtoupper($strWordsINPUTDATA);
        $f->addHidden("dataID", $strDataID);
        if ($isNew) {
            $f->addInput(
                getWords("grade code"),
                "grade_code",
                "0",
                ["size" => 30, "maxlength" => 31],
                "string",
                true,
                true,
                true
            );
        } else {
            $f->addInput(
                getWords("grade code"),
                "grade_code",
                "0",
                ["size" => 30, "maxlength" => 31, "readOnly" => true],
                "string",
                true,
                true,
                true
            );
        }
        for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
            $f->addInput(
                getSetting($strSet . $i . "_allowance_name"),
                $strSet . $i,
                "0",
                ["size" => 30, "maxlength" => 10],
                "numeric",
                true,
                true,
                true
            );
        }
        $f->addCheckBox(
            getWords("get variable service charge?"),
            "get_add_sc",
            false,
            [],
            "string",
            false,
            true,
            true,
            "",
            "<br>&nbsp;<br>"
        );
        $f->addTextArea(getWords("note"), "note", "", ["cols" => 47, "rows" => 2], "string", false, true, true);
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
        $f->addButton("btnAdd", getWords("add new"), ["onClick" => "javascript:myClient.editData('0|grade|3');"]);
        $formInput = $f->render();
    } else {
        $formInput = "";
    }
    $myDataGrid = new cDataGrid("formData", "DataGrid1");
    $myDataGrid->caption = strtoupper($strWordsLISTOF . " " . getWords($dataPrivilege['menu_name']));
    $myDataGrid->setPageLimit("all");
    $myDataGrid->setAJAXCallBackScript(basename($_SERVER['PHP_SELF']));
    $myDataGrid->addColumnCheckbox(
        new DataGrid_Column("chkID", "id", ['width' => '30'], ['align' => 'center', 'nowrap' => ''])
    );
    $myDataGrid->addColumnNumbering(new DataGrid_Column(getWords("no"), "", ['width' => '30'], ['nowrap' => '']));
    $myDataGrid->addColumn(
        new DataGrid_Column(getWords("grade code"), "grade_code", ['width' => '100'], ['nowrap' => ''])
    );
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getSetting($strSet . $i . "_allowance_name"),
                $ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i,
                ['width' => '150'],
                ['nowrap' => ''],
                true,
                false,
                "",
                "printFormatNumber()"
            )
        );
    }
    $myDataGrid->addColumn(
        new DataGrid_Column(
            getWords("get variable service charge?"),
            "get_add_sc",
            ["width" => 70],
            ['align' => 'center'],
            true,
            false,
            "",
            "printAutoOT()"
        )
    );
    $myDataGrid->addColumn(new DataGrid_Column(getWords("note"), "note", null, ['nowrap' => '']));
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
    $strSQLCOUNT = "SELECT COUNT(*) AS total FROM hrd_salary_grade ";
    $strSQL = "SELECT * FROM hrd_salary_grade ";
    $myDataGrid->totalData = $myDataGrid->getTotalData($db, $strSQLCOUNT);
    $dataset = $myDataGrid->getData($db, $strSQL);
    //bind Datagrid with array dataset
    $myDataGrid->bind($dataset);
    $DataGrid = $myDataGrid->render();
    $strConfirmSave = getWords("do you want to save this entry?");
}
$tbsPage = new clsTinyButStrong;
//write this variable in every page
$strPageTitle = getWords($dataPrivilege['menu_name']);
$pageIcon = "../images/icons/" . $dataPrivilege['icon_file'];
$strPageDesc = getWords("salary grade data management");
$pageHeader = pageHeader($pageIcon, $strPageTitle, $strPageDesc);
$strTemplateFile = getTemplate(str_replace(".php", ".html", basename($_SERVER['PHP_SELF'])));
//------------------------------------------------
//Load Master Template
$tbsPage->LoadTemplate("../templates/master.html");
$tbsPage->Show();
//--------------------------------------------------------------------------------
function printEditLink($params)
{
    global $ARRAY_ALLOWANCE_SET, $strSet;
    extract($params);
    $strResult = "
      <input type=hidden name='detailID$counter' id='detailID$counter' value='" . $record['id'] . "' />
      <input type=hidden name='detailCode$counter' id='detailCode$counter' value='" . $record['grade_code'] . "' />
      <input type=hidden name='detailAddSC$counter' id='detailAddSC$counter' value='" . $record['get_add_sc'] . "' />";
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        $strResult .= "<input type=hidden name='detailAllowance" . $i . "_$counter' id='detailAllowance" . $i . "_$counter' value='" . $record[$ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i] . "' />";
    }
    $strResult .= "<input type=hidden name='detailNote$counter' id='detailNote$counter' value='" . $record['note'] . "' />
      <a href=\"javascript:myClient.editData('$counter" . "|$strSet|" . MAX_ALLOWANCE_SET . "')\">" . getWords(
            'edit'
        ) . "</a>";
    return $strResult;
}

// fungsi untuk menyimpan data
function saveData()
{
    global $f;
    global $db;
    global $error;
    global $isNew;
    global $strSet;
    global $ARRAY_ALLOWANCE_SET;
    $strUpdaterID = $_SESSION['sessionUserID'];
    $dataHrdSalaryGrade = new cHrdSalaryGrade();
    $dataHrdEmployee = new cHrdEmployee();
    $data = [
        "grade_code" => $f->getValue('grade_code'),
        "get_add_sc" => ($f->getValue('get_add_sc') == '') ? null : intval($f->getValue('get_add_sc')),
        "note"       => $f->getValue('note'),
    ];
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        $data[$ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i] = $f->getValue($strSet . $i);
    }
    $strDataCode = $data[$strSet . "_code"];
    // simpan data -----------------------
    $bolSuccess = false;
    if ($isNew) {
        if (isDataExists($db, $ARRAY_ALLOWANCE_SET[$strSet]['table_name'], $strSet . "_code", $strDataCode)) {
            $f->message = $error['duplicate_code'] . " of $strSet -> $strDataCode";
        }
        $bolSuccess = $dataHrdSalaryGrade->insert($data);
    } else {
        $bolSuccess = $dataHrdSalaryGrade->update(/*pk*/
            "id='" . $f->getValue('dataID') . "'", /*data to update*/
            $data
        );
        $dataHrdEmployee->update(
            "grade_code='" . $f->getValue('grade_code') . "'",
            ["grade_code" => $f->getValue('grade_code')]
        );
    }
    if ($bolSuccess) {
        $f->setValue('dataID', $data['grade_code']);
        $f->message = $dataHrdSalaryGrade->strMessage;
    }
    $f->msgClass = ($bolSuccess) ? "bgOK" : "bgError";
} // saveData
// fungsi untuk menghapus data
function deleteData()
{
    global $myDataGrid;
    $arrKeys = [];
    foreach ($myDataGrid->checkboxes as $strValue) {
        $arrKeys['id'][] = $strValue;
    }
    $tblSalaryGrade = new cHrdSalaryGrade();
    $tblSalaryGrade->deleteMultiple($arrKeys);
    $myDataGrid->message = $tblSalaryGrade->strMessage;
} //deleteData
function printFormatNumber($params)
{
    extract($params);
    return number_format($value);
}

function printAutoOT($params)
{
    extract($params);
    if ($value == 't') {
        return "Yes";
    } else {
        return "No";
    }
}

?>