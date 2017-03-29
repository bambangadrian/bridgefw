<?php
date_default_timezone_set('Asia/Jakarta');
//the host server address of database
define("DB_TYPE", "postgres");
define("DB_SERVER", "localhost");
define("DB_PORT", "5432");
//the name of database
define("DB_NAME", "wal-dev");
//the database's user password
define("DB_USER", "postgres");
//the database's user name
define("DB_PWD", "root");
define("INVERSE_PRORATE", false);
define("DEBUG_MODE", true);
//the tax method 0=gross 1=gross up
define("TAX_METHOD", 1);
//the absolute directory path in local drive
//define("ABSOLUTE_PATH", $_SERVER['DOCUMENT_ROOT']);
//the URL
define("LIVE_SITE", "http://182.253.220.52/");
define("BASE_URL", "/devosa");
//application name
define("APPLICATION_NAME", "deVosa - Human Resource Information System");
//copyright string/HTML
define("COPYRIGHT", "Copyright &copy; 2008 by PT Invosa Systems.<br>All rights reserved.");
//default ENGLISH
define("DEFAULT_LANGUAGE", "en");
//default error reporting
//error_reporting(all);
ini_set("memory_limit", "256M");
//write user login/logout activity to databaser
ini_set("display_errors", "on");
define("WRITE_USER_LOG", 0);
define("CONFIGURATION_LOADED", 1);
define("PG_DUMP_PATH", 'C:\Program Files\PostgreSQL\9.3\bin\pg_dump.exe');
?>
