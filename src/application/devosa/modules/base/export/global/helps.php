<?php
if (!DEFINED("CONFIGURATION_LOADED")) {
    doInclude('configuration.php');
}
(isset($_SESSION['sessionLanguage'])) ? $dataLanguage = $_SESSION['sessionLanguage'] : $dataLanguage = DEFAULT_LANGUAGE;
switch ($dataLanguage) {
    case "id" :
        doInclude('lang/id.helps.inc');
        break;
    default:
        doInclude('lang/en.helps.inc');
}
function getHelps($help)
{
    if (isset($GLOBALS['helpDictionary'][$help])) {
        return $GLOBALS['helpDictionary'][$help];
    } else {
        return $GLOBALS['helpDictionary']["no help"];
    }
}

?>