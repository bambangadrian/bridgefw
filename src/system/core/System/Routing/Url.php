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
namespace Bridge\Core\Routing;

/**
 * Url class description.
 *
 * @package    Core
 * @subpackage Routing
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Url
{

    /**
     * Application instance property.
     *
     * @var \Bridge\Core\Contracts\ApplicationInterface $Application
     */
    private $Application;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $sessionObject = new \Bridge\Core\System\Session();
        $this->Application = $sessionObject->getItem('application');
        $this->doParseUrl();
    }

    /**
     * Get static contents and other asset url.
     *
     * @param string $filePath File path parameter.
     *
     * @return string
     */
    public static function getAssetsUrl($filePath)
    {
        # TODO: Implement getAssetsUrl() method.
    }

    /**
     * Build url from given query parameter.
     *
     * @param string $path       Path prefix parameter.
     * @param array  $queryParam Url query data parameter.
     *
     * @return string
     */
    public static function getBuildUrl($path = '', array $queryParam)
    {
        # TODO: Implement getBuildUrl() method.
    }

    /**
     * Get full current url path.
     *
     * @return string
     */
    public static function getCurrentUrl()
    {
        # TODO: Implement getCurrentUrl() method.
    }

    /**
     * Get url instance.
     *
     * @return \Bridge\Core\Routing\Url
     */
    public static function getInstance()
    {
    }

    /**
     * Get spesific url segement data.
     *
     * @param string $segment Segment name or number parameter.
     *
     * @return string
     */
    public static function getSegment($segment)
    {
        # TODO: Implement getSegment() method.
    }

    /**
     * Get all url segment data.
     *
     * @return array
     */
    public static function getSegments()
    {
        # TODO: Implement getSegments() method.
    }

    /**
     * Parsing the current url.
     *
     * @return void
     */
    protected function doParseUrl()
    {
        # TODO: Implement doParseUrl() method.
    }

    /**
     * Validate the url.
     *
     * @return boolean
     */
    protected function validateUrl()
    {
        # TODO: Implement validateUrl() method.
    }
}
