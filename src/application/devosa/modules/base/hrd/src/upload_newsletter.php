<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('../global/common_data.php');
doInclude('libraries/helper/employee_function.php');
doInclude('plugins/datagrid2/datagrid.php');
doInclude('plugins/form2/form2.php');
doInclude('libraries/classes/hrd/hrd_eotm.php');
$dataPrivilege = getDataPrivileges(
    basename($_SERVER['PHP_SELF']),
    $bolCanView,
    $bolCanEdit,
    $bolCanDelete,
    $bolCanApprove,
    $bolCanCheck,
    $bolCanAcknowledge
);
// if (!$bolCanView) die(accessDenied($_SERVER['HTTP_REFERER']));
// ------------------------------------------------------------------------------------------------------------------------------
$strInputDoc = "<input name=\"file\" type=\"file\" id=\"file\" value=\"file\"></td></tr>";
$tbsPage = new clsTinyButStrong;
//write this variable in every page
//$strPageTitle = $dataPrivilege['menu_name'];nanti dipake
$strPageTitle = "Upload Newsletter";
$pageIcon = "../images/icons/" . $dataPrivilege['icon_file'];
$strTemplateFile = getTemplate(str_replace(".php", ".html", basename($_SERVER['PHP_SELF'])));
//------------------------------------------------
//Load Master Template
$tbsPage->LoadTemplate($strMainTemplate);
$tbsPage->Show();
//--------------------------------------------------------------------------------
function getDataByID($strDataID)
{
    global $db;
    $tblEOTM = new cHrdEotm();
    $dataOETM = $global->find("id = $strDataID", "id", "id", null, 1, "id");
    $arrTemp = getEmployeeCode($db, $dataDonation['id_employee']);
    $arrResult['dataEmployee'] = $arrTemp['employee_id'];
    $arrResult['dataCreated'] = $dataOETM['created'];
    $arrResult['dataMonth'] = $dataOETM['form_code'];
    $arrResult['dataYear'] = $dataOETM['form_code'];
    $arrResult['dataCompany'] = $dataOETM['id_company'];
    $arrResult['dataNote'] = $dataOETM['note'];
    return $arrResult;
}

// fungsi untuk menyimpan data
?>