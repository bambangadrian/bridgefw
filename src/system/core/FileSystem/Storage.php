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
namespace Bridge\Core\FileSystem;

/**
 * Storage class description.
 *
 * @package    Core
 * @subpackage FileSystem
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Storage implements \Bridge\Core\FileSystem\FactoryInterface
{

    /**
     * Application object property.
     *
     * @var \Bridge\Core\Contracts\ApplicationInterface $Application
     */
    protected $Application;

    /**
     * Array of resolved filesystem driver.
     *
     * @var array $Disks
     */
    protected $Disks = [];

    /**
     * Class constructor.
     *
     * @param \Bridge\Core\Contracts\ApplicationInterface $application Application instance parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If any error raised when create filesystem manager instance.
     */
    public function __construct(\Bridge\Core\Contracts\ApplicationInterface $application)
    {
        try {
            $this->Application = $application;
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Debug($e->getMessage());
        }
    }

    /**
     * Attach filesystem instance into disks property.
     *
     * @param string $diskName Disk name parameter.
     *
     * @return void
     */
    public function attachDisk($diskName = null)
    {
        # If disk name parameter empty or null get the default storage/filesystem driver.
        if ($diskName === null or empty(trim($diskName)) === true) {
            $diskName = $this->getDefaultDriverName();
        }
        $this->Disks[$diskName] = $this->getDisk($diskName);
    }

    /**
     * Create instance of ftp driver adapter.
     *
     * @param array $config Configuration data array parameter.
     *
     * @return \Bridge\Core\FileSystem\FileSystemInterface
     */
    public function createFtpDriver(array $config = [])
    {
        # TODO: Implement createFtpDriver() method.
    }

    /**
     * Create an instance of local driver adapter.
     *
     * @param array $config Configuration data array parameter.
     *
     * @return \Bridge\Core\FileSystem\FileSystemInterface
     */
    public function createLocalDriver(array $config = [])
    {
        # TODO: Implement createLocalDriver() method.
    }

    /**
     * Get application storage instance.
     *
     * @return \Bridge\Core\Contracts\ApplicationInterface
     */
    public function getApplication()
    {
        return $this->Application;
    }

    /**
     * Get the default filesystem driver name.
     *
     * @return string
     */
    public function getDefaultDriverName()
    {
        # Get the default filesystem driver from application setting.
        return $this->Application->getSettings()['filesystem']['default'];
    }

    /**
     * Get file system disk instance from cache of attached disk.
     *
     * @param string $diskName Disk name parameter.
     *
     * @return \Bridge\Core\FileSystem\FileSystemInterface
     */
    public function getDisk($diskName)
    {
        if (in_array($diskName, $this->Disks, true) === false) {
            return $this->resolveDisk($diskName);
        }
        return $this->Disks[$diskName];
    }

    /**
     * Create a storage instance with the given adapter.
     *
     * @param \Bridge\Core\FileSystem\Adapter\AdapterInterface $storageAdapter Storage data adapter instance parameter.
     * @param array                                            $config         Configuration data array parameter.
     *
     * @return \Bridge\Core\FileSystem\FileSystemInterface
     */
    protected function createStorage(
        \Bridge\Core\FileSystem\Adapter\AdapterInterface $storageAdapter,
        array $config = []
    ) {
        # TODO: Implement createStorage() method.
    }

    /**
     * Resolve instance of the given disk name.
     *
     * @param string $diskName Disk name parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If the driver not supported by filesystem manager.
     *
     * @return \Bridge\Core\FileSystem\FileSystemInterface
     */
    protected function resolveDisk($diskName)
    {
        # Fetch the application filesystem config data.
        $appFileSystemConfig = $this->Application->getSettings()['filesystem'][$diskName];
        # Check if filesystem manager support the driver by checking the creation method.
        $driverCreationMethod = 'create' . ucfirst($diskName) . 'Driver';
        if (method_exists($this, $driverCreationMethod) === false) {
            throw new \Bridge\Core\Exceptions\Types\Debug('The driver not supported by file system manager');
        }
        # Return the filesystem driver by creating dynamic function that use factory method pattern.
        return $this->{$driverCreationMethod}($appFileSystemConfig);
    }
}
