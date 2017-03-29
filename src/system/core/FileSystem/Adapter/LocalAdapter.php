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
namespace Bridge\Core\Filesystem\Adapter;

/**
 * LocalDriver class description.
 *
 * @package    Core
 * @subpackage Filesystem\Adapter
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class LocalAdapter extends \Bridge\Core\FileSystem\Adapter\AbstractAdapter
{

    /**
     * Root directory path.
     *
     * @var string $RootDir
     */
    protected $RootDir;

    /**
     * Write lock method permission property.
     *
     * @var integer $WriteLock
     */
    protected $WriteLock;

    /**
     * File and directory permission data array setting list.
     *
     * @var array $Permissions
     */
    protected static $Permissions = [
        'file'      => ['public' => 0744, 'private' => 0700],
        'directory' => ['public' => 0755, 'private' => 0700]
    ];

    public function __construct($rootDir, $writeLock)
    {
        parent::__construct();
    }
}
