<?php
date_default_timezone_set('Asia/Jakarta');
//the host server address of database
define("DB_TYPE", "postgres");
define("DB_PORT", "5432");
//the host server address of database
define("DB_SERVER", "");
//define("DB_SERVER","192.168.1.3");
//the name of database
define("DB_NAME", "lega3w_devosa_03");
//define("DB_NAME","nss_new");
//the database's user name
define("DB_PWD", "test01");
//the database's user password
define("DB_USER", "lega3w_user");
//the absolute directory path in local drive
//define("ABSOLUTE_PATH", $_SERVER['DOCUMENT_ROOT']);
// Company Name
define("COMPANY", "INVOSA");
//the URL
define("LIVE_SITE", "http://");
//copyright string/HTML
define("COPYRIGHT", "Copyright &copy; 2012 by PT. Invosa Systems.<br>All rights reserved.");
//default ENGLISH
define("DEFAULT_LANGUAGE", "en");
//default error reporting
error_reporting(E_ALL);
//error_reporting(E_ALL & E_NOTICE);
//write user login/logout activity to database
define("WRITE_USER_LOG", 1);
define("CONFIGURATION_LOADED", 1);
?>
