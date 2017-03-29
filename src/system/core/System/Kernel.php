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
 * Kernel class description.
 *
 * @package    Core
 * @subpackage System
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Kernel
{

    /**
     * Kernel activity state property.
     *
     * @var string $State
     */
    private $State;

    /**
     * Kernel status property.
     *
     * @var array $Status
     */
    private $Status = [];

    /**
     * Accepted kernel state property.
     *
     * @var array $AcceptedState
     */
    private static $AcceptedState = ['init', 'boot', 'run', 'fail'];

    /**
     * Kernel instance static property.
     *
     * @var \Bridge\Core\System\System $Instance
     */
    private static $Instance;

    /**
     * Protected class constructor.
     */
    protected function __construct()
    {
        $this->setStatus('Kernel instance was created');
    }

    /**
     * Initialize the application kernel.
     *
     * @param array $systemRequirements System requirements data array parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If kernel boot failed.
     *
     * @return \Bridge\Core\System\Kernel
     */
    public static function boot(array $systemRequirements = [])
    {
        try {
            static::getInstance()->setStatus('Kernel is booting ...');
            $validateCode = false;
            # TODO: Checking all system requirements and compatibility when kernel instance created.
            # Checking PHP Version.
            # Checking Loaded Module Extension on PHP.
            # Checking Loaded Module on Web Server.
            # Checking Directory Structure.
            # Checking Directory Permissions.
            # TODO: Setting up directory when booting the kernel.
            # TODO: Run the proxy builder if defined when booting the kernel.
            if ($validateCode === true) {
                # TODO: Run the codesniffer, phpmd, code testing and report to each log record as the latest step on kernel boot.
            }
            static::getInstance()->setStatus('Kernel was booted successfully');
            return static::getInstance();
        } catch (\Exception $e) {
            static::getInstance()->setStatus('Kernel boot failed');
            throw new \Bridge\Core\Exceptions\Types\Error($e->getMessage());
        }
    }

    /**
     * Get system instance.
     *
     * @return \Bridge\Core\System\Kernel
     */
    public static function getInstance()
    {
        if (static::$Instance === null) {
            static::$Instance = new static();
        }
        return static::$Instance;
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
