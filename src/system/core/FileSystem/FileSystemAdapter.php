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
 * FileSystem class description.
 *
 * @package    Core
 * @subpackage FileSystem
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class FileSystemAdapter implements \Bridge\Core\FileSystem\FileSystemInterface
{

    /**
     * Adapter instance property.
     *
     * @var \Bridge\Core\FileSystem\Adapter\AdapterInterface $Adapter
     */
    protected $Adapter;

    /**
     * FileSystem constructor.
     *
     * @param \Bridge\Core\FileSystem\Adapter\AdapterInterface $adapter Adapter instance parameter.
     */
    public function __construct(\Bridge\Core\FileSystem\Adapter\AdapterInterface $adapter)
    {
        # Set the file system adapter instance to storage adapter property.
        $this->Adapter = $adapter;
    }
}
