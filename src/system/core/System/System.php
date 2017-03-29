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
 * System class description.
 *
 * @package    Core
 * @subpackage System
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class System
{

    /**
     * System requirement property.
     *
     * @var array
     */
    protected $Requirements = [];

    /**
     * System kernel property.
     *
     * @var \Bridge\Core\System\Kernel $Kernel
     */
    private $Kernel;

    /**
     * Application platform that will be used.
     *
     * @var \Bridge\Core\Contracts\PlatformInterface $Platform
     */
    private $Platform;

    /**
     * System status property.
     *
     * @var array $Status
     */
    private $Status = [];

    /**
     * System instance static property.
     *
     * @var \Bridge\Core\System\System $Instance
     */
    private static $Instance;

    /**
     * Protected class constructor.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If any errors comes out convert to error exceptions.
     */
    protected function __construct()
    {
        try {
            $this->Platform = new \Bridge\Core\System\Platform();
            $this->setStatus('System instance was created');
            $this->loadRequirements();
            $this->Kernel = \Bridge\Core\System\Kernel::boot($this->getRequirements());
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Error($e->getMessage());
        }
    }

    /**
     * Get system instance.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If any errors comes out convert to error exceptions.
     * @return \Bridge\Core\System\System
     */
    public static function getInstance()
    {
        if (static::$Instance === null) {
            static::$Instance = new static();
        }
        return static::$Instance;
    }

    /**
     * Get system requirements property.
     *
     * @return array
     */
    public function getRequirements()
    {
        return $this->Requirements;
    }

    /**
     * Get status property.
     *
     * @return array
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * Initialize the system platform.
     *
     * @throws \Bridge\Core\Exceptions\Types\Critical
     * @return \Bridge\Core\System\System
     */
    public static function init()
    {
        try {
            static::getInstance()->setStatus('System is starting ...');
            static::getInstance()->loadConfiguration();
            static::getInstance()->loadService();
            static::getInstance()->loadStartUp();
            static::getInstance()->loadPrivileges();
            static::getInstance()->loadTaskSchedule();
            static::getInstance()->setStatus('System was started successfully');
            return static::getInstance();
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Critical('System cannot be loaded, error: ' . $e->getMessage());
        }
    }

    /**
     * Reload system configuration, and privileges.
     *
     * @return void
     */
    public function reload()
    {
        # TODO: System reload process.
        $this->loadConfiguration();
        $this->loadPrivileges();
        $this->setStatus('System has been reloaded');
    }

    /**
     * Restarting the systems platform.
     *
     * @return void
     */
    public function restart()
    {
        # TODO: System restart process.
        $this->setStatus('System is restarting now');
        static::init();
        $this->setStatus('System has been restarted');
    }

    /**
     * Load system configuration.
     *
     * @return void
     */
    protected function loadConfiguration()
    {
        # TODO: Load system configuration process.
        $this->setStatus('System configuration has been loaded');
        # Set default timezone.
    }

    /**
     * Load system privileges includes; page, security, authentication.
     *
     * @return void
     */
    protected function loadPrivileges()
    {
        # TODO: Load system privileges, page security, authentication module process.
        $this->setStatus('System privileges, page security, and authentication process has been loaded');
    }

    /**
     * Load system requirements.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If requirements file data not found.
     * @return void
     */
    protected function loadRequirements()
    {
        # TODO: Load system requirements process.
        $this->setStatus('System requirements loaded');
    }

    /**
     * Load system service.
     *
     * @return void
     */
    protected function loadService()
    {
        # TODO: Load system service process.
        $this->setStatus('System service has been loaded');
    }

    /**
     * Load system driver.
     *
     * @return void
     */
    protected function loadDriver(){
        # TODO: Load system driver process.
        $this->setStatus('System driver has been loaded');
    }

    /**
     * Load system start-up modules.
     *
     * @return void
     */
    protected function loadStartUp()
    {
        # TODO: Load system start-up process.
        $this->setStatus('System start-up modules has been loaded');
    }

    /**
     * Load task scheduler.
     *
     * @return void
     */
    protected function loadTaskSchedule()
    {
        # TODO: Load system task schedule process.
        $this->setStatus('System task scheduler has been loaded');
    }

    /**
     * Set the system status property.
     *
     * @param string  $message Log message system status parameter.
     * @param integer $code    Log code result parameter.
     *
     * @return void
     */
    protected function setStatus($message, $code = 0)
    {
        $this->Status[] = [
            'time'    => time(),
            'message' => $message,
            'code'    => $code
        ];
    }
}
