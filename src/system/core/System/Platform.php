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
namespace Bridge\Core\System;

/**
 * Platform class description.
 *
 * @package    Core
 * @subpackage System
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Platform implements \Bridge\Core\System\Contracts\PlatformInterface
{

    /**
     * Platform name property.
     *
     * @var string $PlatformName
     */
    protected $PlatformName;

    /**
     * Platform type property.
     *
     * @var $PlatformType
     */
    protected $PlatformType;

    /**
     * Static valid platform type property.
     *
     * @var array $ValidPlatformType
     */
    private static $ValidPlatformType = [
        'web-app',
        'service-app',
        'command-app'
    ];

    /**
     * Class constructor.
     *
     * @param string $platformName Platform name parameter.
     * @param string $platformType Platform type parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If any error comes out convert to runtime error.
     */
    public function __construct($platformName = 'Web Platform', $platformType = 'web-app')
    {
        try {
            $this->setPlatformName($platformName);
            $this->setPlatformType($platformType);
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Debug($e->getMessage());
        }
    }

    /**
     * Get the platform name property.
     *
     * @return string
     */
    public function getPlatformName()
    {
        return $this->PlatformName;
    }

    /**
     * Get platform type property.
     *
     * @return string
     */
    public function getPlatformType()
    {
        return $this->PlatformType;
    }

    /**
     * Set platform name property.
     *
     * @param string $platformName Platform name parameter.
     *
     * @return void
     */
    public function setPlatformName($platformName)
    {
        $this->PlatformName = $platformName;
    }

    /**
     * Set platform type property.
     *
     * @param string $platformType Platform type parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid platform type given.
     * @return void
     */
    public function setPlatformType($platformType)
    {
        if ($this->validatePlatformType($platformType) === false) {
            throw new \Bridge\Core\Exceptions\Types\Debug('Invalid platform type given');
        }
        $this->PlatformType = $platformType;
    }

    /**
     * Validate platform type.
     *
     * @param string $type Platform type that want to be validated.
     *
     * @return boolean
     */
    private function validatePlatformType($type)
    {
        return in_array(trim(strtolower($type)), static::$ValidPlatformType, true) === true;
    }
}
