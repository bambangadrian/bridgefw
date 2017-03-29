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
 * FactoryInterface class description.
 *
 * @package    Core
 * @subpackage FileSystem
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface FactoryInterface
{

    /**
     * Attach filesystem instance into disks property.
     *
     * @param string $diskName Disk name parameter.
     *
     * @return void
     */
    public function attachDisk($diskName = null);

    /**
     * Get file system disk instance from cache of attached disk.
     *
     * @param string $diskName Disk name parameter.
     *
     * @return \Bridge\Core\FileSystem\FileSystemInterface
     */
    public function getDisk($diskName);
}
