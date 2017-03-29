<?php
/**
 * Code written is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   Core
 * @author    Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright 2016 Developer
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License 3.0
 * @version   GIT: $Id$
 * @link      -
 */
namespace Bridge\Core\System\Routing;

/**
 * Route class description.
 *
 * @package    Core
 * @subpackage System\Routing
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Route
{

    /**
     * Application directory property.
     *
     * @var string $ApplicationDir
     */
    private $ApplicationDir = 'application';

    /**
     * Route class instance property.
     *
     * @var \Bridge\Core\Routing\Route $Instance
     */
    private $Instance;

    /**
     * Application module directory property.
     *
     * @var string $ModuleDir
     */
    private $ModuleDir;

    /**
     * Url instance property.
     *
     * @var \Bridge\Core\Routing\Url $UrlObject
     */
    private $UrlObject;

    /**
     * Protected class constructor.
     */
    protected function __construct()
    {
        $this->UrlObject = new \Bridge\Core\Routing\Url();
    }

    /**
     * Get route object instance.
     *
     * @return \Bridge\Core\Routing\Route
     */
    public static function getInstance()
    {
    }
}
