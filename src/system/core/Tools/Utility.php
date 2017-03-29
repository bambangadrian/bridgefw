<?php
/**
 * Code written is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   Core
 * @author    Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright 2016 Developer
 * @license   - No License
 * @version   GIT: $Id$
 * @link      -
 */
namespace Bridge\Core\Tools;

/**
 * Utility class description.
 *
 * @package    Core
 * @subpackage Tools
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Utility
{

    /**
     * Map object array.
     *
     * @param array $object Array object parameter.
     * @param array $map    Map array parameter.
     *
     * @return array
     */
    public static function doArrayMap(array $object, array $map)
    {
        $result = [];
        foreach ($map as $from => $to) {
            if (array_key_exists($from, $object) === false) {
                continue;
            }
            $result[$to] = $object[$from];
        }
        return $result;
    }

    /**
     * Get content size based encoding.
     *
     * @param string $contents Contents parameter.
     * @param string $encoding Character encoding parameter.
     *
     * @return integer
     */
    public static function getContentSize($contents, $encoding = '8bit')
    {
        if (defined('MB_OVERLOAD_STRING') === true) {
            return mb_strlen($contents, $encoding);
        }
        return strlen($contents);
    }

    /**
     * Get normalize directory name from a path.
     *
     * @param string $path Path parameter.
     *
     * @return string
     */
    public static function getDirName($path)
    {
        return static::getNormalizeDirName(dirname($path));
    }

    /**
     * Normalize a directory name return value.
     *
     * @param string $dirName Directory name parameter.
     *
     * @return string
     */
    public static function getNormalizeDirName($dirName)
    {
        if ($dirName === '.') {
            return '';
        }
        return $dirName;
    }

    /**
     * Get normalize path path.
     *
     * @param string $path Path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Groups\LogicalException If invalid path given.
     *
     * @return string
     */
    public static function getNormalizePath($path)
    {
        # Remove any kind of funky unicode whitespace
        $normalized = preg_replace('#\p{C}+|^\./#u', '', $path);
        $normalized = static::getNormalizeRelativePath($normalized);
        if (preg_match('#/\.{2}|^\.{2}/|^\.{2}$#', $normalized)) {
            throw new \Bridge\Core\Exceptions\Groups\LogicalException(
                'Path is outside of the defined root, path: [' . $path . '], resolved: [' . $normalized . ']'
            );
        }
        $normalized = preg_replace('#\\\{2,}#', '\\', trim($normalized, '\\'));
        $normalized = preg_replace('#/{2,}#', '/', trim($normalized, '/'));
        return $normalized;
    }

    /**
     * Get normalize relative path.
     *
     * @param string $path Path parameter.
     *
     * @return string
     */
    public static function getNormalizeRelativePath($path)
    {
        # Path remove self referring paths ("/./").
        $path = preg_replace('#/\.(?=/)|^\./|/\./?$#', '', $path);
        # Regex for resolving relative paths
        $regex = '#/*[^/\.]+/\.\.#Uu';
        while (preg_match($regex, $path)) {
            $path = preg_replace($regex, '', $path);
        }
        return $path;
    }

    /**
     * Get normalize path information.
     *
     * @param string $path Path parameter.
     *
     * @return array
     */
    public static function getPathInfo($path)
    {
        $pathInfo = pathinfo($path) + compact('path');
        $pathInfo['dirname'] = static::getNormalizeDirName($pathInfo['dirname']);
        return $pathInfo;
    }
}
