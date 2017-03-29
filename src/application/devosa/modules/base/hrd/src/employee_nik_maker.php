<?php
doInclude('../global/session.php');
doInclude('modules/base/root/global.php');
doInclude('form_object.php');
//--------------MAIN-----------------------------
$db = new CdbClass;
$db->connect();
if ($_POST['dataID'] == "") {
    $strJoinDate = $_POST['join'];
    $arrDate = explode("/", $strJoinDate);
    $strJoinYear = $arrDate[2];
    echo getNextId($db, $strJoinYear);
    die();
}
//------------FUNCTIONS----------------------------
// uddin 20151124
// get last ID & make new ID
function getNextId($db, $year)
{
    $newid = "";
    $strYearNow = $year;
    $strSQL = "SELECT * FROM (
    select id,employee_id,
    substr(employee_id, 0, 5) ||substr(employee_id, length (employee_id)-2, 3) as A,join_date,
    substr(employee_id, 0, 5) as year,
    substr(employee_id, length (employee_id)-2, 3)  as seq,
    EXTRACT(YEAR FROM join_date) as yjoin
    from hrd_employee
    where length (employee_id)<8
    ) AS tbl1
    where yjoin<=" . $strYearNow . "
    order by A desc limit 1";
    $resDb = $db->execute($strSQL);
    while ($rowDb = $db->fetchrow($resDb)) {
        if ($strYearNow == $rowDb['year']) {
            $curid = (int)$rowDb["seq"];
            $curid = $curid + 1;
            $newid = $rowDb["year"] . str_pad($curid, 3, "0", STR_PAD_LEFT);
        } else {
            $newid = $strYearNow . "001";
        }
    }
    return $newid;
}

?>
