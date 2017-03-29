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
namespace Bridge\Core\FileSystem\Adapter;

/**
 * AdapterInterface class description.
 *
 * @package    Core
 * @subpackage FileSystem\Adapter
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface AdapterInterface extends \Bridge\Core\FileSystem\FileSystemInterface
{

    /**
     * Update file using stream.
     *
     * @return boolean
     */
    public function updateStream();

    /**
     * Write file using stream.
     *
     * @return boolean
     */
    public function writeStream();
}
