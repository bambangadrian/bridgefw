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
namespace Bridge\Core\FileSystem\Adapter;

/**
 * AbstractAdapter class description.
 *
 * @package    Core
 * @subpackage FileSystem\Adapter
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractAdapter implements \Bridge\Core\FileSystem\Adapter\AdapterInterface
{

    /**
     * Path prefix property.
     *
     * @var string $PathPrefix
     */
    protected $PathPrefix;

    /**
     * Path separator property.
     *
     * @var string $PathSeparator
     */
    protected $PathSeparator;

    /**
     * Class constructor.
     *
     * @param string $pathPrefix    Path prefix parameter.
     * @param string $pathSeparator Path separator parameter.
     */
    public function __construct($pathPrefix = '', $pathSeparator = '/')
    {
        $this->setPathPrefix($pathPrefix);
        $this->setPathSeparator($pathSeparator);
    }

    /**
     * Apply the prefix into path.
     *
     * @param string $path Path parameter.
     *
     * @return string
     */
    public function applyPathPrefix($path)
    {
        # Remove or trim character \ and / on the beginning path.
        $path = trim(ltrim($path, '\\/'));
        # Check the path string length.
        if ($path === '') {
            return $this->getPathPrefix();
        }
        return $this->getPathPrefix() . $path;
    }

    /**
     * Get path prefix property.
     *
     * @return string
     */
    public function getPathPrefix()
    {
        return $this->PathPrefix;
    }

    /**
     * Get path separator property.
     *
     * @return string
     */
    public function getPathSeparator()
    {
        return $this->PathSeparator;
    }

    /**
     * Remove path prefix from path string.
     *
     * @param string $path Path parameter.
     *
     * @return string
     */
    public function removePathPrefix($path)
    {
        # Path prefix always on the left position so use substring to cut the path string following the prefix length.
        $prefix = $this->getPathPrefix();
        if ($prefix !== '' or $prefixnull !== null) {
            $path = substr($path, strlen($prefix));
        }
        return $path;
    }

    /**
     * Set path prefix property.
     *
     * @param string $pathPrefix Path prefix parameter.
     *
     * @return void
     */
    public function setPathPrefix($pathPrefix)
    {
        $prefix = trim($pathPrefix);
        if (trim($prefix) !== '' and $prefixnull !== null) {
            $this->PathPrefix = $prefix;
        } else {
            $this->PathPrefix = rtrim($prefix, $this->getPathSeparator()) . $this->getPathSeparator();
        }
    }

    /**
     * Set path separator property.
     *
     * @param string $pathSeparator Path separator parameter.
     *
     * @return void
     */
    public function setPathSeparator($pathSeparator)
    {
        $this->PathSeparator = $pathSeparator;
    }
}
