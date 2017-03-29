<?php
/*****************************************
 * CdbClass : kelas untuk mengakses basis data
 * Copyright (c) Invosa Systems, PT
 * dbClass.php
 * Author:  Dedy Sukandar
 * Ver   :  - 1.00, 2006-11-22
 ******************************************/
require_once("dbclass.config.php");
if (!DEFINED("LIKE")) {
    DEFINE("LIKE", "ILIKE");
}
if (DEFINED('DB_TYPE')) {
    $dbtype = DB_TYPE;
} else {
    $dbtype = "postgres";
}
switch ($dbtype) {
    case "MYSQL" :
        doInclude('mysql.php');
        break;
    case "MSSQL" :
        doInclude('mssql.php');
        break;
    default : //POSTGRES
        doInclude('postgres.php');
}
?>
