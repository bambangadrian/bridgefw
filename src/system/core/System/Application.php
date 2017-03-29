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
 * Application class description.
 *
 * @package    Core
 * @subpackage System
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Application implements \Bridge\Core\Contracts\ApplicationInterface
{

    /**
     * Application path property.
     *
     * @var string $ApplicationPath
     */
    protected $ApplicationPath;

    /**
     * Application base path property.
     *
     * @var string $BasePath
     */
    protected $BasePath;

    /**
     * Application environment file extension property.
     *
     * @var string $EnvironmentExtension
     */
    protected $EnvironmentExtension = '.ini';

    /**
     * Application environment path property.
     *
     * @var string $EnvironmentPath
     */
    protected $EnvironmentPath;

    /**
     * All the list of application services instance that has been loaded.
     *
     * @var array $LoadedServices
     */
    protected $LoadedServices = [];

    /**
     * Application name property.
     *
     * @var string $Name
     */
    protected $Name;

    /**
     * Application namespace property.
     *
     * @var string $NameSpace
     */
    protected $NameSpace;

    /**
     * List of services instance that will be required by the application.
     *
     * @var array $Services
     */
    protected $Services = [];

    /**
     * Application settings array data property.
     *
     * @var array $Settings
     */
    protected $Settings;

    /**
     * State property that will store the application state.
     *
     * @var string $State
     */
    protected $State;

    /**
     * Application storage path property.
     *
     * @var string $StoragePath
     */
    protected $StoragePath;

    /**
     * System application property.
     *
     * @var \Bridge\Core\System\System
     */
    protected $System;

    /**
     * Application version property.
     *
     * @var string $Version
     */
    protected $Version;

    /**
     * Valid state array to validate the application state set.
     *
     * @var array
     */
    private static $ValidState = [0 => 'started', 1 => 'booted', 2 => 'failed'];

    /**
     * Class constructor.
     *
     * @param string $appName Application name parameter.
     * @param string $version Application version parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If system failed to initialize.
     */
    public function __construct($appName = null, $version = null)
    {
        try {
            # Load the application settings.
            $this->loadSettings();
            # Initialize the system instance.
            $this->System = \Bridge\Core\System\System::init();
            if ($appName !== null and trim($appName) !== '') {
                $this->setName($appName);
            }
            if ($version !== null and trim($version) !== '') {
                $this->setVersion($version);
            }
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Debug($e->getMessage());
        }
    }

    /**
     * Redirecting to specific url.
     *
     * @param string  $path         Path parameter.
     * @param array   $queryParam   Additional url query parameter.
     * @param boolean $savePrevious Save previous url option.
     *
     * @return void
     */
    public function doRedirect($path, array $queryParam = [], $savePrevious = false)
    {
        # TODO: Implement doRedirect() method.
    }

    /**
     * Put down the application for maintenance mode.
     *
     * @return void
     */
    public function down()
    {
        # TODO: Implement down() method.
    }

    /**
     * Get application path property.
     *
     * @return string
     */
    public function getApplicationPath()
    {
        return $this->ApplicationPath;
    }

    /**
     * Get application base path property.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->BasePath;
    }

    /**
     * Get application environment path property.
     *
     * @return string
     */
    public function getEnvironmentPath()
    {
        return $this->EnvironmentPath;
    }

    /**
     * Get application name property.
     *
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Get application namespace property.
     *
     * @return string
     */
    public function getNameSpace()
    {
        return $this->NameSpace;
    }

    /**
     * Get application settings array data property.
     *
     * @return array
     */
    public function getSettings()
    {
        return $this->Settings;
    }

    /**
     * Get application state property.
     *
     * @return string
     */
    public function getState()
    {
        return $this->State;
    }

    /**
     * Get application storage path property.
     *
     * @return string
     */
    public function getStoragePath()
    {
        return $this->StoragePath;
    }

    /**
     * Get application version property.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->Version;
    }

    /**
     * Run the application.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If application failed to launch.
     * @return void
     */
    public function run()
    {
        # TODO: Implement run() method.
    }

    /**
     * Set the application path property.
     *
     * @param string $applicationPath Application path parameter.
     *
     * @return void
     */
    public function setApplicationPath($applicationPath)
    {
        $this->ApplicationPath = $applicationPath;
    }

    /**
     * Set application base path property.
     *
     * @param string $basePath Application base path parameter.
     *
     * @return void
     */
    public function setBasePath($basePath)
    {
        $this->BasePath = $basePath;
    }

    /**
     * Set application environment path property.
     *
     * @param string $environmentPath Application environment path parameter.
     *
     * @return void
     */
    public function setEnvironmentPath($environmentPath)
    {
        $this->EnvironmentPath = $environmentPath;
    }

    /**
     * Set the application name property.
     *
     * @param string $name Application name parameter.
     *
     * @return void
     */
    public function setName($name)
    {
        $this->Name = $name;
    }

    /**
     * Set application namespace property.
     *
     * @param string $nameSpace Application namespace parameter.
     *
     * @return void
     */
    public function setNameSpace($nameSpace)
    {
        $this->NameSpace = $nameSpace;
    }

    /**
     * Set application state property.
     *
     * @param string $state Application state parameter.
     *
     * @return void
     */
    public function setState($state)
    {
        $this->State = $state;
    }

    /**
     * Set application storage path property.
     *
     * @param string $storagePath Application storage path parameter.
     *
     * @return void
     */
    public function setStoragePath($storagePath)
    {
        $this->StoragePath = $storagePath;
    }

    /**
     * Set the application version property.
     *
     * @param string $applicationVersion Application version parameter.
     *
     * @return void
     */
    public function setVersion($applicationVersion)
    {
        $this->Version = $applicationVersion;
    }

    /**
     * Load the application settings.
     *
     * @return void
     */
    protected function loadSettings()
    {
        # TODO: Implement loadSettings() method.
        # Define the configuration data files.
        # Create config instance for each files.
        # Load and the configuration data files.
        # Set the configuration data requirements for each segments.
        # Validate the configuration data.
        # Save the configuration data into application settings property.
    }

    /**
     * Validate application state.
     *
     * @param string $state Application state parameter.
     *
     * @return boolean
     */
    protected function validateApplicationState($state)
    {
        return in_array(strtolower($state), static::$ValidState, true);
    }
}
