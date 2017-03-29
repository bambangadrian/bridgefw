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
namespace Bridge\Core\System\Contracts;

/**
 * PlatformInterface class description.
 *
 * @package    Core
 * @subpackage System\Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface PlatformInterface
{

    /**
     * Get the platform name property.
     *
     * @return string
     */
    public function getPlatformName();

    /**
     * Get platform type property.
     *
     * @return string
     */
    public function getPlatformType();

    /**
     * Set platform name property.
     *
     * @param string $platformName Platform name parameter.
     *
     * @return void
     */
    public function setPlatformName($platformName);

    /**
     * Set platform type property.
     *
     * @param string $platformType Platform type parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid platform type given.
     * @return void
     */
    public function setPlatformType($platformType);
}
