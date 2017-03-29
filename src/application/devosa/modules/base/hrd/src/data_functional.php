<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('plugins/datagrid2/datagrid.php');
doInclude('plugins/form2/form2.php');
doInclude('libraries/classes/hrd/hrd_functional.php');
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
    $strDataID = getPostValue('dataID');
    $isNew = ($strDataID == "");
    $strSet = "functional";
    if ($bolCanEdit) {
        $f = new clsForm("formInput", 1, "100%", "");
        $f->caption = strtoupper(getWords("input data") . " " . getWords("functional"));
        $f->addHidden("dataID", $strDataID);
        $f->addInput(getWords("functional code"), "dataCode", "", ["size" => 20], "string", true, true, true);
        $f->addInput(getWords("functional name"), "dataName", "", ["size" => 50], "string", true, true, true);
        $f->addSelect(
            getWords("Head Code"),
            "dataHeadCode",
            getDataListFunctionalPosition(
                getInitialValue("Functional", " ", $strDataHeadCode),
                true,
                ["value" => "", "text" => "-"]
            ),
            ["style" => "width:$strDefaultWidthPx"],
            "",
            false,
            ($ARRAY_DISABLE_GROUP['division'] == "")
        );
        $f->addSelect(
            getWords("Position(level)"),
            "dataPositionCode",
            getDataListPosition(
                getInitialValue("Position", " ", $strDataPositionCode),
                true,
                ["value" => "", "text" => "-"]
            ),
            ["style" => "width:$strDefaultWidthPx"],
            "",
            false,
            ($ARRAY_DISABLE_GROUP['position'] == "")
        );
        for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
            $f->addInput(
                getSetting($strSet . $i . "_allowance_name"),
                $strSet . $i,
                "0",
                ["size" => 30, "maxlength" => 10],
                "numeric",
                false,
                true,
                true
            );
        }
        $f->addTextArea(getWords("note"), "dataNote", "", ["cols" => 48, "rows" => 2], "string", false, true, true);
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
        $f->addButton("btnAdd", getWords("add new"), ["onClick" => "javascript:myClient.editData('0|functional|3');"]);
        $formInput = $f->render();
    } else {
        $formInput = "";
    }
    $myDataGrid = new cDataGrid("formData", "DataGrid1");
    // $myDataGrid->caption = getWords(strtoupper(vsprintf(getWords("list of"), getWords("functional"))));
    $myDataGrid->caption = strtoupper($strWordsLISTOF . " " . getWords($dataPrivilege['menu_name']));
    $myDataGrid->setAJAXCallBackScript(basename($_SERVER['PHP_SELF']));
    $myDataGrid->addColumnCheckbox(
        new DataGrid_Column("chkID", "functional_code", ['width' => '30'], ['align' => 'center', 'nowrap' => ''])
    );
    $myDataGrid->addColumnNumbering(new DataGrid_Column(getWords("no"), "", ['width' => '30'], ['nowrap' => '']));
    $myDataGrid->addColumn(
        new DataGrid_Column(getWords("code"), "functional_code", ['width' => '130'], ['nowrap' => ''])
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(getWords("functional name"), "functional_name", ['width' => ''], ['nowrap' => ''])
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(getWords("Head Code"), "head_code_name", ['width' => ''], ['nowrap' => ''])
    );
    $myDataGrid->addColumn(
        new DataGrid_Column(getWords("Position Code"), "position_code", ['width' => ''], ['nowrap' => ''])
    );
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        $myDataGrid->addColumn(
            new DataGrid_Column(
                getSetting($strSet . $i . "_allowance_name"),
                $ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i,
                ['width' => '80'],
                ['align' => 'right'],
                true,
                true,
                "",
                "formatNumber()"
            )
        );
    }
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
    $strSQLCOUNT = "SELECT COUNT(*) AS total FROM hrd_functional ";
    $strSQL = "SELECT t1.*,t2.functional_name as head_code_name FROM hrd_functional as t1
                      LEFT JOIN hrd_functional as t2 ON t2.functional_code=t1.head_code";
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
$strPageDesc = getWords("functional data management");
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
    $strResult = "";
    extract($params);
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        $strResult .= "<input type=hidden name='detailAllowance" . $i . "_$counter' id='detailAllowance" . $i . "_$counter' value='" . $record[$ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i] . "' />";
    }
    return "
      <input type=hidden name='detailID$counter' id='detailID$counter' value='" . $record['functional_code'] . "' />
      <input type=hidden name='detailCode$counter' id='detailCode$counter' value='" . $record['functional_code'] . "' />
      <input type=hidden name='detailName$counter' id='detailName$counter' value='" . $record['functional_name'] . "' />
      <input type=hidden name='detailHeadCode$counter' id='detailHeadCode$counter' value='" . $record['head_code'] . "' />
      <input type=hidden name='detailPositionCode$counter' id='detailPositionCode$counter' value='" . $record['position_code'] . "' />
      <input type=hidden name='detailNote$counter' id='detailNote$counter' value='" . $record['note'] . "' />
      <a id=\"edit-$counter\" href=\"javascript:myClient.editData('$counter" . "|$strSet|" . MAX_ALLOWANCE_SET . "')\" class=\"edit-data\">" . getWords(
        'edit'
    ) . "</a>" . $strResult;
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
    $strmodified_byID = $_SESSION['sessionUserID'];
    $dataHrdFunctional = new cHrdFunctional();
    $data = [
        "functional_code" => $f->getValue('dataCode'),
        "functional_name" => $f->getValue('dataName'),
        "head_code"       => $f->getValue('dataHeadCode'),
        "position_code"   => $f->getValue('dataPositionCode'),
        "note"            => $f->getValue('dataNote')
    ];
    //var_dump($data);
    //exit();
    for ($i = 1; $i <= MAX_ALLOWANCE_SET; $i++) {
        $data[$ARRAY_ALLOWANCE_SET[$strSet]['field_name'] . $i] = $f->getValue($strSet . $i);
    }
    $strDataCode = $data[$strSet . "_code"];
    // simpan data -----------------------
    $bolSuccess = false;
    /*  if (isDataExists($db, $ARRAY_ALLOWANCE_SET[$strSet]['table_name'], $strSet."_code", $strDataCode))
      {
        $f->message = $error['duplicate_code']. " of $strSet -> $strDataCode";
      }
      else
      {
        */
    if ($isNew) {
        if (isDataExists($db, $ARRAY_ALLOWANCE_SET[$strSet]['table_name'], $strSet . "_code", $strDataCode)) {
            $f->message = $error['duplicate_code'] . " of $strSet -> $strDataCode";
        } else {
            // data baru
            $bolSuccess = ($dataHrdFunctional->insert($data));
        }
    } else {
        //var_dump($data);
        //exit();
        $bolSuccess = ($dataHrdFunctional->update(/*pk*/
            "functional_code='" . $f->getValue('dataID') . "'", /*data to update*/
            $data
        ));
    }
    if ($bolSuccess) {
        $f->setValue('dataID', $data['functional_code']);
    }
    $f->message = $dataHrdFunctional->strMessage;
    // }
    $f->msgClass = ($bolSuccess) ? "bgOK" : "bgError";
} // saveData
// fungsi untuk menghapus data
function deleteData()
{
    global $myDataGrid;
    $arrKeys = [];
    foreach ($myDataGrid->checkboxes as $strValue) {
        $arrKeys['functional_code'][] = $strValue;
    }
    $dataHrdFunctional = new cHrdFunctional();
    $dataHrdFunctional->deleteMultiple($arrKeys);
    $myDataGrid->message = $dataHrdFunctional->strMessage;
} //deleteData
?>