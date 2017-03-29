<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('form_object.php');
doInclude('activity.php');
$dataPrivilege = getDataPrivileges("warning_edit.php", $bolCanView, $bolCanEdit, $bolCanDelete, $bolCanApprove);
if (!$bolCanView) {
    die(accessDenied($_SERVER['HTTP_REFERER']));
}
//---- INISIALISASI ----------------------------------------------------
$strDataDetail = "";
$strHidden = "";
$intTotalData = 0;
//----------------------------------------------------------------------
//--- DAFTAR FUNSI------------------------------------------------------
// fungsi untuk menampilkan data
// $db = kelas database, $intRows = jumlah baris (return)
// $strKriteria = query kriteria, $strOrder = query ORder by
function getData($db, $strDataDateFrom, $strDataDateThru, &$intRows, $strKriteria = "", $strOrder = "")
{
    global $words;
    global $ARRAY_EMPLOYEE_STATUS;
    $dtToday = getdate();
    $intRows = 0;
    $strResult = "";
    // ambil dulu data employee, kumpulkan dalam array
    $arrEmployee = [];
    $i = 0;
    $strSQL = "SELECT t1.*, t2.employee_id, t2.position_code, t2.employee_name, t2.active, ";
    $strSQL .= "t2.section_code, t2.sub_section_code FROM hrd_employee_warning AS t1 ";
    $strSQL .= "LEFT JOIN hrd_employee AS t2 ON t1.id_employee = t2.id ";
    $strSQL .= "WHERE ((warning_date, t1.due_date) OVERLAPS ";
    $strSQL .= "(date '$strDataDateFrom', date '$strDataDateThru') OR t1.due_date = '$strDataDateThru') ";
    $strSQL .= $strKriteria;
    $strSQL .= "ORDER BY $strOrder t2.employee_name, t1.warning_date, t1.duration ";
    $resDb = $db->execute($strSQL);
    $strDateOld = "";
    while ($rowDb = $db->fetchrow($resDb)) {
        $intRows++;
        $strResult .= "<tr valign=top>\n";
        $strResult .= "  <td><input type=checkbox name='chkID$intRows' value=\"" . $rowDb['id'] . "\"></td>\n";
        $strResult .= "  <td>" . $rowDb['employee_id'] . "&nbsp;</td>";
        $strResult .= "  <td>" . $rowDb['employee_name'] . "&nbsp;</td>";
        $strResult .= "  <td>" . $rowDb['position_code'] . "&nbsp;</td>";
        $strResult .= "  <td>" . $rowDb['section_code'] . "&nbsp;</td>";
        $strResult .= "  <td>" . $rowDb['sub_section_code'] . "&nbsp;</td>";
        $strResult .= "  <td align=center>" . printAct($rowDb['active']) . "&nbsp;</td>";
        $strResult .= "  <td align=center>" . pgDateFormat($rowDb['warning_date'], "d-M-y") . "&nbsp;</td>";
        $strResult .= "  <td>" . $rowDb['warning_code'] . "&nbsp;</td>";
        $strResult .= "  <td align=right>" . $rowDb['duration'] . "&nbsp;</td>";
        $strResult .= "  <td align=center>" . pgDateFormat($rowDb['due_date'], "d-M-y") . "&nbsp;</td>";
        $strResult .= "  <td>" . $rowDb['note'] . "&nbsp;</td>";
        $strResult .= "  <td align=center><a href=\"warning_edit.php?dataID=" . $rowDb['id'] . "\">" . $words['edit'] . "</a>&nbsp;</td>";
        $strResult .= "</tr>\n";
    }
    if ($intRows > 0) {
        writeLog(ACTIVITY_VIEW, MODULE_PAYROLL, "$intRows data", 0);
    }
    return $strResult;
} // showData
function printAct($a)
{
    if ($a == 1) {
        return "&radic;";
    } else {
        return "";
    }
}

// fungsi untuk menghapus data
function deleteData($db)
{
    global $_REQUEST;
    $i = 0;
    foreach ($_REQUEST as $strIndex => $strValue) {
        if (substr($strIndex, 0, 5) == 'chkID') {
            $strSQL = "DELETE FROM hrd_employee_warning WHERE id = '$strValue' ";
            $resExec = $db->execute($strSQL);
            $i++;
        }
    }
    if ($i > 0) {
        writeLog(ACTIVITY_DELETE, MODULE_PAYROLL, "$i data", 0);
    }
} //deleteData
//----------------------------------------------------------------------
//----MAIN PROGRAM -----------------------------------------------------
$strInfo = "";
$db = new CdbClass;
if ($db->connect()) {
    // hapus data jika ada perintah
    if (isset($_REQUEST['btnDelete']) && !isset($_REQUEST['btnShow'])) {
        if ($bolCanDelete) {
            deleteData($db);
        }
    }
    // ------ AMBIL DATA KRITERIA -------------------------
    (isset($_REQUEST['dataDateFrom'])) ? $strDataDateFrom = $_REQUEST['dataDateFrom'] : $strDataDateFrom = date(
        "Y-m-d"
    );
    (isset($_REQUEST['dataDateThru'])) ? $strDataDateThru = $_REQUEST['dataDateThru'] : $strDataDateThru = date(
        "Y-m-d"
    );
    (isset($_REQUEST['dataDivision'])) ? $strDataDivision = $_REQUEST['dataDivision'] : $strDataDivision = "";
    (isset($_REQUEST['dataDepartment'])) ? $strDataDepartment = $_REQUEST['dataDepartment'] : $strDataDepartment = "";
    (isset($_REQUEST['dataSection'])) ? $strDataSection = $_REQUEST['dataSection'] : $strDataSection = "";
    (isset($_REQUEST['dataSubsection'])) ? $strDataSubsection = $_REQUEST['dataSubsection'] : $strDataSubsection = "";
    (isset($_REQUEST['dataEmployee'])) ? $strDataEmployee = $_REQUEST['dataEmployee'] : $strDataEmployee = "";
    (isset($_REQUEST['dataActive'])) ? $strDataActive = $_REQUEST['dataActive'] : $strDataActive = 1;
    (isset($_REQUEST['dataEmployeeStatus'])) ? $strDataEmployeeStatus = $_REQUEST['dataEmployeeStatus'] : $strDataEmployeeStatus = "";
    // ------------ GENERATE KRITERIA QUERY,JIKA ADA -------------
    $strKriteria = "";
    if ($strDataDivision != "") {
        $strKriteria .= "AND t2.division_code = '$strDataDivision' ";
    }
    if ($strDataDepartment != "") {
        $strKriteria .= "AND t2.department_code = '$strDataDepartment' ";
    }
    if ($strDataSection != "") {
        $strKriteria .= "AND t2.section_code = '$strDataSection' ";
    }
    if ($strDataSubsection != "") {
        $strKriteria .= "AND t2.sub_section_code = '$strDataSubsection' ";
    }
    if ($strDataEmployee != "") {
        $strKriteria .= "AND t2.employee_id = '$strDataEmployee' ";
    }
    if ($strDataActive != "") {
        $strKriteria .= "AND t2.Active = '$strDataActive' ";
    }
    if ($strDataEmployeeStatus != "") {
        $strKriteria .= "AND employee_status = '$strDataEmployeeStatus' ";
    }
    $strKriteria .= $strKriteriaCompany;
    if ($bolCanView) {
        if (validStandardDate($strDataDateFrom) && validStandardDate($strDataDateThru)) {
            // tampilkan hanya jika ada permintaan dan data tanggalnya tepat
            $strDataDetail = getData($db, $strDataDateFrom, $strDataDateThru, $intTotalData, $strKriteria);
        } else {
            $strDataDetail = "";
        }
    } else {
        showError("view_denied");
        $strDataDetail = "";
    }
    // generate data hidden input dan element form input
    $intDefaultWidthPx = 200;
    $strInputDateFrom = "<input type=text name=dataDateFrom id=dataDateFrom size=15 maxlength=10 value=\"$strDataDateFrom\">";
    $strInputDateThru = "<input type=text name=dataDateThru id=dataDateThru size=15 maxlength=10 value=\"$strDataDateThru\">";
    $strInputEmployee = "<input type=text name=dataEmployee id=dataEmployee size=15 maxlength=30 value=\"$strDataEmployee\">";
    $strInputDivision = getDivisionList(
        $db,
        "dataDivision",
        $strDataDivision,
        $strEmptyOption,
        "",
        "style=\"width:$intDefaultWidthPx\""
    );
    $strInputDepartment = getDepartmentList(
        $db,
        "dataDepartment",
        $strDataDepartment,
        $strEmptyOption,
        "",
        "style=\"width:$intDefaultWidthPx\""
    );
    $strInputSection = getSectionList(
        $db,
        "dataSection",
        $strDataSection,
        $strEmptyOption,
        "",
        "style=\"width:$intDefaultWidthPx\""
    );
    $strInputSubsection = getSubSectionList(
        $db,
        "dataSubsection",
        $strDataSubsection,
        $strEmptyOption,
        "",
        "style=\"width:$intDefaultWidthPx\""
    );
    $strInputActive = getEmployeeActiveList(
        "dataActive",
        $strDataActive,
        $strEmptyOption2,
        "style=\"width:$intDefaultWidthPx\""
    );
    $strInputEmployeeStatus = getEmployeeStatusList(
        "dataEmployeeStatus",
        $strDataEmployeeStatus,
        $strEmptyOption2,
        "style=\"width:$intDefaultWidthPx\""
    );
    //handle user company-access-right
    $strInputCompany = getCompanyList(
        $db,
        "dataCompany",
        $strDataCompany,
        $strEmptyOption2,
        $strKriteria2,
        "style=\"width:$intDefaultWidthPx\" "
    );
    // informasi tanggal kehadiran
    if ($strDataDateFrom == $strDataDateThru) {
        $strInfo .= "<br>" . strtoupper(pgDateFormat($strDataDateFrom, "d-M-Y"));
    } else {
        $strInfo .= "<br>" . strtoupper(pgDateFormat($strDataDateFrom, "d-M-Y"));
        $strInfo .= " >> " . strtoupper(pgDateFormat($strDataDateThru, "d-M-Y"));
    }
    $strHidden .= "<input type=hidden name=dataDateFrom value=\"$strDataDateFrom\">";
    $strHidden .= "<input type=hidden name=dataDateThru value=\"$strDataDateThru\">";
    $strHidden .= "<input type=hidden name=dataDivision value=\"$strDataDivision\">";
    $strHidden .= "<input type=hidden name=dataDepartment value=\"$strDataDepartment\">";
    $strHidden .= "<input type=hidden name=dataSection value=\"$strDataSection\">";
    $strHidden .= "<input type=hidden name=dataSubsection value=\"$strDataSubsection\">";
    $strHidden .= "<input type=hidden name=dataEmployee value=\"$strDataEmployee\">";
    $strHidden .= "<input type=hidden name=dataActive value=\"$strDataActive\">";
    $strHidden .= "<input type=hidden name=dataEmployeeStatus value=\"$strDataEmployeeStatus\">";
}
$tbsPage = new clsTinyButStrong;
//write this variable in every page
$strPageTitle = $dataPrivilege['menu_name'];
$strPageDesc = getWords("Warning List");;
if (trim($dataPrivilege['icon_file']) == "") {
    $pageIcon = "../images/icons/blank.gif";
} else {
    $pageIcon = "../images/icons/" . $dataPrivilege['icon_file'];
}
$pageHeader = pageHeader($pageIcon, $strPageTitle, $strPageDesc);
$strTemplateFile = getTemplate(str_replace(".php", ".html", basename($_SERVER['PHP_SELF'])));
//------------------------------------------------
//Load Master Template
$tbsPage->LoadTemplate($strMainTemplate);
$tbsPage->Show();
?>