<?
session_start();
include("modules/base/root/global.php");
$strTemplateFile = getTemplate("blank.html");
$strPageTitle = 'SMART-U';
$tbsPage = new clsTinyButStrong;
$tbsPage->LoadTemplate($strTemplateFile);
$tbsPage->Show();
?>