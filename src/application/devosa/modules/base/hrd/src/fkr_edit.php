<?php
doInclude('../global/session.php');
doInclude('../modules/base/root/global.php');
doInclude('libraries/helper/common_function.php');
doInclude('plugins/datagrid/datagrid.php');
doInclude('plugins/form2/form2.php');
doInclude('../global/date_function.php');
doInclude('../global/common_data.php');
$strWordsApprove = getWords("approve");
$strSet = getWords("strSet");
$emp = getWords("emp");
$salary1 = getWords("salary1");
$salary2 = getWords("salary2");
$salary3 = getWords("salary3");
$bolCanView = true;
$bolCanEdit = true;
$strDataCandidateID = (isset($_REQUEST['dataCandidateID'])) ? $_REQUEST['dataCandidateID'] : "";
$strDataID = (isset($_REQUEST['dataID'])) ? $_REQUEST['dataID'] : "";
$strInitAction = "";
$strDateTime = "";
$strSignatureStyle = "style='display:none'";
$arrData = null;
if ($strDataID != "" || $strDataCandidateID != "") {
    if ($strDataCandidateID != "") {
        $arrData = getDataCandidate($strDataCandidateID);
    } // $arrData = getDataCandidate($strDataCandidateID);
    else {
        $arrData = getData($strDataID);
    }
}
if ($arrData == null) {
    header("location: candidate_search.php");
    exit();
}
$isView = getGetValue("view", 0);
$f = new clsForm("formInput", 2, "100%", "100%");
$f->bolRequiredEntryBeforeSubmit = false;
$f->showCaption = false;
$f->message = getGetValue('message');
$f->action = basename($_SERVER['PHP_SELF']);
//$f->addHelp(getWords("help for")." ".$dataPrivilege['menu_name'], getHelps("master user"), 8, 167, 400, 300);
$f->addHidden("URL_REFERER", $GLOBALS['URL_REFERER']);
$f->addHidden("dataID", $strDataID);
$f->addHidden("dataCandidateID", $strDataCandidateID);
$f->addHidden("id_candidate", $arrData['id_candidate']);
$f->addHidden("status", $arrData['status']);
$f->addHidden("oldRecruitmentID", $arrData['id_recruitment_need']);
$f->addFieldSet(getWords("employee information"), 2);
$f->addInput(
    getWords("name"),
    "employee_name",
    $arrData['employee_name'],
    ["size" => 50, "style" => "width:250px;"],
    "string",
    true,
    true,
    true,
    "",
    "",
    true,
    ["width" => 120]
);
// echo $arrData['employee_id'];
if ($arrData['employee_id'] != "") {
    $employeeID = $arrData['employee_id'];
} else {
    $employeeID = employeeID();
}
$f->addInput(getWords("employee id"), "employee_id", $employeeID, ["size" => 10], "string", false);
$f->addInput(getWords("nickname"), "nickname", $arrData['nickname'], ["size" => 50], "string", false);
//$f->addInput(getWords("position"), "position_code", $arrData['position_code'], array("size" => 50), "string");
$f->addSelect(
    getWords("MRF No."),
    "id_recruitment_need",
    getDataListMRF($arrData['id_recruitment_need'], true, $emptyData, false, $arrData['id_recruitment_need']),
    ["style" => "width:250px;", "onchange" => "myClient.changeMRF()"],
    "string",
    false,
    true,
    true,
    "",
    "",
    true,
    ["width" => 120]
); // common_data.php
$f->addSelect(
    getWords("company"),
    "id_company",
    getDataListCompany($arrData['id_company'], true),
    ["style" => "width:250px;"],
    "string",
    true,
    true,
    true
);
$f->addSelect(
    getWords("branch"),
    "branch_code",
    getDataListBranch($arrData['branch_code'], true),
    ["style" => "width:250px;"],
    "string",
    true,
    true,
    true
);
$f->addSelect(
    getWords("division"),
    "division_code",
    getDataListDivision($arrData['division_code'], true),
    ["style" => "width:250px;", "onChange" => "checkDivision()"],
    "string",
    true,
    true,
    true
);
$f->addSelect(
    getWords("department"),
    "department_code",
    getDataListDepartment($arrData['department_code'], true),
    ["style" => "width:250px;", "onChange" => "checkDepartment()"],
    "string",
    true,
    true,
    true
);
$f->addSelect(
    getWords("section"),
    "section_code",
    getDataListSection($arrData['section_code'], true),
    ["style" => "width:250px;"],
    "string",
    false,
    true,
    true
);
$f->addSelect(
    getWords("sub section"),
    "sub_section_code",
    getDataListSubSection($arrData['sub_section_code'], true),
    ["style" => "width:250px;"],
    "string",
    false,
    true,
    true
);
//$f->addSelect(getWords("area"), "id_wilayah", getDataListWilayah($arrData['id_wilayah'], true), array("style" =>"width:250px;"), "string", false, true, true);
$f->addSelect(
    getWords("grade"),
    "salary_grade_code",
    getDataListSalaryGrade($arrData['salary_grade_code'], true, null, true),
    ["style" => "width:250px;"],
    "string",
    true
);
$f->addSelect(
    getWords("position"),
    "position_code",
    getDataListPosition($arrData['position_code'], true),
    ["style" => "width:250px;"],
    "string",
    false,
    true,
    true
);
$f->addSelect(
    getWords("functional"),
    "functional_code",
    getDataListFunctionalPosition($arrData['functional_code'], true),
    ["style" => "width:250px;"],
    "string",
    false,
    true,
    true
);
$f->addSelect(
    getWords("family status"),
    "family_status_code",
    getDataListFamilyStatus($arrData['family_status_code'], true, null, false),
    [],
    "string",
    true
);
$arrTmp = getDataListEmployeeStatus($arrData['employee_status'], true);
$f->addSelect(getWords("employee status"), "employee_status", $arrTmp, [], "string", true, true, true);
$f->addInput(getWords("transport"), "transport", $arrData['transport'], ["size" => 50], "string", false);
$arrContractMonth = [0, 3, 6, 12];
$arrResult = [];
foreach ($arrContractMonth as $month) {
    $bolCheck = ($month == $arrData['contract_month']);
    $arrResult[] = ["value" => $month, "text" => $month . " " . getWords("months"), "checked" => $bolCheck];
}
$arrResult[0]['text'] = getWords("none");
$f->addRadio(getWords("contract/probation period"), "contract_month", $arrResult, [], "string", true, true, true);
$f->addInput(getWords("join date"), "join_date", $arrData['join_date'], [], "date", true);
$f->addInput(
    getWords("salary adjustment date"),
    "adjustment_date",
    $arrData['adjustment_date'],
    [],
    "date",
    false,
    true,
    true,
    "",
    "<br>" . getWords("please fill if only there is negotiation on salary adjustment in the future")
);
$f->addFieldSet(getWords("bank information"), 1);
$f->addInput(
    getWords("bank account no."),
    "bank_account_no",
    $arrData['bank_account_no'],
    ["size" => 20],
    "string",
    false
);
$f->addInput(
    getWords("bank account name"),
    "bank_account_name",
    $arrData['bank_account_name'],
    ["size" => 20],
    "string",
    false
);
$f->addInput(getWords("branch name") . " (BCA) ", "bank", $arrData['bank'], ["size" => 20], "string", false);
if ($arrData['salary_grade_code'] == "" || isBandAccess($arrData['salary_grade_code'])) {
    $f->addFieldSet(getWords("salary information"), 1);
    $f->addLiteral(
        "",
        "dataDetailSalary",
        getDetailSalary($strDataID, $arrData['salary_grade_code']),
        false
    );//, array(), "integer", false, true, true, "", "year(s) old");
    $f->addFieldSet(getWords("note"), 1);
    $f->addTextArea(getWords("note"), "note", $arrData['note'], ["rows" => 6, "cols" => 120], "string", false);
}
if ($isView) {
    $f->addButton("btnClose", getWords("close"), ["onClick" => "javascript:closeWindow();"], true, true);
    $f->readOnlyForm();
} else {
    if ($bolCanEdit) {
        if ($arrData['status'] < REQUEST_STATUS_APPROVED) {
            $f->addSubmit(
                "btnSave",
                getWords("save"),
                ["onClick" => "return myClient.confirmSave();"],
                true,
                true,
                "",
                "",
                "saveData()"
            );
        } else {
            $f->addSubmit(
                "btnSave",
                getWords("save"),
                ["disabled" => "disabled", "style" => "color:gray"],
                true,
                true,
                "",
                "",
                "saveData()"
            );
        }
    }
    //$f->addButton("btnBack", getWords("back"), array("onClick" => "javascript:location.href='".urldecode($f->getValue('URL_REFERER'))."'"), true,true);
}
//if ($strDataID !="")
//$f->addButton("btnPrint", "Print", array("onClick" => "javascript:location.href='candidate_print.php?dataID=$strDataID'"));
//$f->validateEntryBeforeSubmit=false;
$formInput = $f->render();
$tbsPage = new clsTinyButStrong;
//write this variable in every page
$strPageTitle = getWords("form kesepakatan renumerasi") . " (FKR)";
$pageIcon = "../images/icons/blank.gif";
$strTemplateFile = "templates/fkr_edit.html";
//candidate user
//------------------------------------------------
//Load Master Template
if ($isView) {
    $tbsPage->LoadTemplate("../templates/master_view.html");
} else {
    $tbsPage->LoadTemplate("../templates/master.html");
}
$tbsPage->Show();
//--------------------------------------------------------------------------------
function getData($strDataID)
{
    $tblFKR = new cModel("hrd_fkr");
    if ($strDataID != "") {
        if ($rowDb = $tblFKR->findById($strDataID)) {
            return $rowDb;
        }
    }
    $arrData = $tblFKR->getEmptyRecord();
    return $arrData;
}

function getDataCandidate($strDataCandidateID)
{
    $tblFKR = new cModel("hrd_candidate", getWords("candidate"));
    if ($strDataCandidateID != "") {
        if ($arrData = $tblFKR->findById($strDataCandidateID)) {
            $tbl = new cModel;
            $strSQL = "SELECT * FROM hrd_recruitment_need where id='$arrData[id_recruitment_need]'";
            $resDb = $tbl->query($strSQL);
            foreach ($resDb as $loop) {
                $arrData['department_code'] = $loop['department_code'];
                $arrData['section_code'] = $loop['section_code'];
                $arrData['sub_section_code'] = $loop['sub_section_code'];
                $arrData['branch_code'] = $loop['branch_code'];
                $arrData['division_code'] = $loop['division_code'];
                $arrData['functional_code'] = $loop['functional_code'];
                $arrData['salary_grade_code'] = $loop['grade_code'];
                $arrData['id_company'] = $loop['id_company'];
                $arrData['employee_status'] = $loop['employee_status'];
            }
            $arrData['id_candidate'] = $arrData['id'];
            $arrData['id_recruitment_need'] = $arrData['id_recruitment_need'];
            $arrData['employee_name'] = $arrData['candidate_name'];
            $arrData['nickname'] = $arrData['nickname'];
            $arrData['position_code'] = $arrData['position'];
            // $arrData['section_code'] = '';
            // $arrData['department_code'] = $arrData['department_code'];
            // $arrData['division_code'] = '';
            $arrData['contract_month'] = 0;
            $arrData['employee_id'] = $arrData['employee_id'];
            // $arrData['salary_grade_code'] = '';
            $arrData['family_status_code'] = $arrData['family_status_code'];
            $arrData['superior_name'] = '';
            $arrData['transport'] = $arrData['transport'];
            $arrData['join_date'] = '';
            $arrData['adjustment_date'] = '';
            $arrData['bank_account_no'] = '';
            $arrData['bank_account_name'] = $arrData['candidate_name'];
            $arrData['bank'] = '';
            $arrData['note'] = '';
            $arrData['status'] = 0;
            // $arrData['id_company'] = '';
            $arrData['id_wilayah'] = '';
            return $arrData;
        }
    }
    return null;
}

function getDetailSalary($strDataID, $gradeCode = "")
{
    global $isView;
    $jumlahStart = 0;
    $jumlahNext = 0;
    $tblFKRDetail = new cModel("hrd_fkr_detail");
    $strResult = "
      <table class=\"dataGrid\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
          <th width=30>NO</th>
          <th width=250>" . strtoupper(getWords("salary") . " & " . getWords("allowances")) . "</th>
          <th nowrap>" . strtoupper(getWords("start amount")) . "</th>
          <th nowrap>" . strtoupper(getWords("adjustment amount")) . "</th>
        </tr>
        <tbody>";
    $counter = 0;
    $tblAllowanceType = new cModel("hrd_allowance_type");
    $arrAllowance = $tblAllowanceType->findAll(null, null, "id", null, null, "id");
    $tbl = new cModel;
    $strSQL = "SELECT grade_allowance1 FROM hrd_salary_grade ";
    $strSQL .= "WHERE grade_code = '$gradeCode' ";
    $resDb = $tbl->query($strSQL);
    foreach ($resDb as $loop) {
        $mount = $loop['grade_allowance1'];
    }
    // print_r($resDb);
    $arrAllowance[0]['name'] = "Basic Salary";
    $arrAllowance[0]['amount'] = $mount;
    // print_r($arrAllowance);
    if ($strDataID != "") {
        $arrResult = $tblFKRDetail->findAllByIdFkr($strDataID, null, "id", null, null, "id_allowance_type");
    }
    foreach ($arrAllowance as $idAllowance => $allowance) {
        $counter++;
        if (!isset($arrResult[$idAllowance])) {
            $row = [
                "id"           => "",
                "amount_start" => $allowance['amount'],
                "amount_next"  => $allowance['amount']
            ];
        } else {
            $row = $arrResult[$idAllowance];
        }
        if ($isView) {
            $strResult .= "
        <tr>
          <td align=center>" . $counter . ".</td>
          <td nowrap>" . $allowance['name'] . "</td>
          <td align=right>" . number_format($row['amount_start']) . "</td>
          <td align=right>" . number_format($row['amount_next']) . "</td>
        </tr>";
        } else {
            $strResult .= "
        <tr>
          <td align=center>" . $counter . ".</td>
          <td nowrap>" .
                generateHidden("id" . $counter, $row['id']) .
                generateHidden("deleted" . $counter, 0) .
                generateHidden("id_allowance_type" . $counter, $idAllowance) .
                ucwords(strtolower($allowance['name'])) . "
          </td>
          <td nowrap>" . generateInput(
                    "amount_start" . $counter,
                    $row['amount_start'],
                    "class=\"numberformat numeric\" style='width:100%'"
                ) . "</td>
          <td nowrap>" . generateInput(
                    "amount_next" . $counter,
                    $row['amount_next'],
                    "class=\"numberformat numeric\" style='width:100%'"
                ) . "</td>
        </tr>";
        }
        $jumlahStart += $row['amount_start'];
        $jumlahNext += $row['amount_next'];
    }
    //$jumlah = $jumlahStart + $jumlahNext ;
    // tambahkan total
    $strResult .= "
        <tr >
           <td nowrap colspan=2 bgcolor= \"#c8c5c6\" align=center>Total</td>
          <td nowrap bgcolor=\"#c8c5c6\">" . generateInput(
            "amount_start_total",
            $jumlahStart,
            "class=\"numberformat numeric\" style='width:100%'"
        ) . "</td>
          <td nowrap bgcolor=\"#c8c5c6\">" . generateInput(
            "amount_next_total",
            $jumlahNext,
            "class=\"numberformat numeric\" style='width:100%'"
        ) . "</td>
        </tr>";
    $strResult .= "
        </tbody>
      </table>" .
        generateHidden("hNumShowDetail", $counter);
    return $strResult;
}

// fungsi untuk menyimpan data
function saveData()
{
    global $f;
    // simpan data -----------------------
    $data = $_POST;
    $tblFKR = new cModel("hrd_fkr");
    //$tblFKR->DEBUGMODE=1;
    $tblFKR->begin();
    $isSuccess = false;
    if ($f->getValue('dataID') == "") {
        // data baru
        if ($tblFKR->insert($data)) {
            $f->setValue('dataID', $tblFKR->getLastInsertId('id'));
            $isSuccess = true;
        }
    } else {
        $isSuccess = $tblFKR->update(["id" => $f->getValue('dataID')], $data);
    }
    if ($isSuccess) {
        // cek status recruitment (MRF)
        $strID = "";
        $strOld = $f->getValue("oldRecruitmentID");
        $strNew = $f->getValue("id_recruitment_need");
        if ($strOld != "" || $strNew != "") {
            if ($strOld == "") {
                $strID = " ('$strNew') ";
            } else if ($strNew == "") {
                $strID = " ('$strOld') ";
            } else if ($strNew == $strOld) {
                $strID = " ('$strOld') ";
            } else {
                $strID = " ('$strOld', '$strNew') ";
            }
        }
        if ($strID != "") {
            // update status MRF
            $strSQL = "
          UPDATE hrd_recruitment_need SET number_ok = tf.total
          FROM (
            SELECT COUNT(id_candidate) AS total, id_recruitment_need
            FROM hrd_fkr
            WHERE id_recruitment_need IN $strID
            GROUP BY id_recruitment_need
          ) AS tf
          WHERE tf.id_recruitment_need = hrd_recruitment_need.id
          AND hrd_recruitment_need.id IN $strID ;
          UPDATE hrd_recruitment_need SET number_ok = 0
          WHERE number_ok is null AND id IN $strID;
        ";
            $isSuccess = $tblFKR->execute($strSQL);
        }
    }
    if ($isSuccess) {
        if (!saveDataDetail($f->getValue('dataID'))) {
            $tblFKR->rollback();
            $f->errorMessage = "ERROR: " . getWords("failed to save data ") . " " . $tblFKR->strEntityName . " ";
            echo $f->errorMessage;
            die();
            return false;
        } else if (!updateCandidate($f->getValue('id_candidate'), $f->getValue('employee_id'))) {
            $tblFKR->rollback();
            $f->errorMessage = "ERROR: " . getWords(
                    "failed to save data - update "
                ) . " " . $tblFKR->strEntityName . " ";
            echo $f->errorMessage;
            die();
            return false;
        }
        $f->message = $tblFKR->strMessage;
        $tblFKR->commit();
        echo basename($_SERVER['PHP_SELF']) . "?dataID=" . $f->getValue(
                'dataID'
            ) . "&message=" . $f->message . "&URL_REFERER=" . $f->getValue("URL_REFERER");
        echo $f->message;
        die();
        return true;
    } else {
        $tblFKR->rollback();
        $f->errorMessage = getWords("failed to save data ") . " " . $tblFKR->strEntityName . " ";
        echo $f->errorMessage;
        die();
        return false;
    }
} // saveData
// fungsi untuk mengupdate data NIK di kandidat
function updateCandidate($idCandidate, $idEmployee = "")
{
    // ah, bingung makai cModel, pakai cara manual aja
    $tblCan = new cModel("hrd_candidate");
    $strSQL = "
      UPDATE hrd_candidate SET employee_id = '$idEmployee'
      WHERE id = '$idCandidate'
    ";
    $res = $tblCan->execute($strSQL);
    unset($tblCan);
    return ($res);
}

// fungsi untuk menyimpan data detail
function saveDataDetail($masterID)
{
    $tblFKRDetail = new cModel("hrd_fkr_detail");
    //$tblFKRDetail->DEBUGMODE = 1;
    // die();
    $intNumData = intval(getPostValue("hNumShowDetail"));
    for ($counter = 1; $counter <= $intNumData; $counter++) {
        $data = [
            "id_fkr"            => $masterID,
            "id_allowance_type" => getPostValue("id_allowance_type" . $counter),
            "amount_start"      => str_replace(",", "", getPostValue("amount_start" . $counter)),
            "amount_next"       => str_replace(",", "", getPostValue("amount_next" . $counter)),
        ];
        $isSuccess = true;
        $intDataID = getPostValue("id" . $counter, 0);
        $intDeleted = getPostValue("deleted" . $counter, 0);
        if ($intDataID != 0) {
            //edit mode
            if ($intDeleted == 1) {
                //delete old data
                $isSuccess = $tblFKRDetail->delete(["id" => intval($_POST['id' . $counter])]);
            } else {
                //edit old data
                $isSuccess = $tblFKRDetail->update(["id" => intval($_POST['id' . $counter])], $data);
            }
        } else {
            //insert mode
            if ($intDeleted == 0) {
                //insert new data
                //save only if organization and type_organization entered
                //if ($data['organization'] == "" && $data['type_organization'] == '') continue;
                $isSuccess = $tblFKRDetail->insert($data);
            }
        }
        if (!$isSuccess) {
            return false;
        }
    }
    return true;
} // saveDataSocialActivities
function employeeID()
{
    $tbl = new cModel();
    $strSQL = "select employee_id from hrd_employee where substring(employee_id from 1 for 1)='I' order by employee_id desc limit 1";
    $resDb = $tbl->query($strSQL);
    foreach ($resDb as $loop) {
        $idEmp = $loop['employee_id'];
    }
    $strSQL = "select employee_id from hrd_fkr where substring(employee_id from 1 for 1)='I' order by employee_id desc limit 1";
    $resDb = $tbl->query($strSQL);
    foreach ($resDb as $loop) {
        $idFkr = $loop['employee_id'];
    }
    if ($idFkr >= $idEmp) {
        $id = $idFkr;
    } else {
        $id = $idEmp;
    }
    $newID = substr($id, 1) + 1;
    $length = strlen($newID);
    for ($i = 0; $i < (4 - $length); $i++) {
        $newID = "0" . $newID;
    }
    $newID = "I" . $newID;
    return $newID;
}

?>