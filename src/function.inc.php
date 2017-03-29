<?php
/**
 * Contains code written by the Invosa Systems Company and is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   -
 * @author    Bambang Adrian Sitompul <bambang@invosa.com>
 * @copyright 2016 Invosa Systems Indonesia
 * @license   http://www.invosa.com/license No License
 * @version   GIT: $Id$
 * @link      http://www.invosa.com
 */
if (!function_exists('doInclude')) {
    /**
     * Bridge function - to include once the needed other php file.
     *
     * @param string  $path        File path parameter.
     * @param boolean $includeOnce Include once option, enable if you want to check if already included before.
     *
     * @throws \Exception If included file is not exists.
     * @return void
     */
    function doInclude($path, $includeOnce = true)
    {
        $currentFilePath = __DIR__;
        $ds = DIRECTORY_SEPARATOR;
        $includedPath = $currentFilePath . $ds . $path;
        if (!file_exists($includedPath) === true) {
            throw new \Bridge\Core\Exceptions\Types\Debug('Cannot include file: ' . $path);
        } else {
            # TODO: All the included files must be on auto-loader system.
            if ($includeOnce === true) {
                include_once $includedPath;
            } else {
                include $includedPath;
            }
        }
    }
}
if (!function_exists('debug')) {
    /**
     * Debugging variable that important for developer.
     *
     * @param mixed   $var  Variable that want to dump.
     * @param boolean $exit Exit the control program option.
     *
     * @return void
     */
    function debug($var, $exit = false)
    {
        echo '<pre>';
        /** @noinspection ForgottenDebugOutputInspection */
        var_dump($var);
        echo '</pre>';
        if ($exit === true) {
            exit();
        }
    }
}
