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
namespace Bridge\Core\System\PlatformType;

/**
 * AbstractPlatformType class description.
 *
 * @package    Core
 * @subpackage System\PlatformType
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractPlatformType
{

    /**
     * Platform type name property.
     *
     * @var string $PlatformTypeName
     */
    private $PlatformTypeName;

    /**
     * AbstractPlatformType constructor.
     */
    public function __construct()
    {
        $this->doLoadConfiguration();
    }

    /**
     * Load platform standard configuration.
     *
     * @return void
     */
    abstract protected function doLoadConfiguration();

    /**
     * @return string
     */
    public function getPlatformTypeName()
    {
        return $this->PlatformTypeName;
    }

    /**
     * @param string $PlatformTypeName
     *
     * @return AbstractPlatformType
     */
    public function setPlatformTypeName($PlatformTypeName)
    {
        $this->PlatformTypeName = $PlatformTypeName;
        return $this;
    }


}
