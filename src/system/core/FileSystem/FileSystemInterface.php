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
 * FileSystemInterface class description.
 *
 * @package    Core
 * @subpackage FileSystem
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface FileSystemInterface
{

    # Create some constant to constraint the file permissions.
    /**
     * Appends contents into file.
     *
     * @param string $filePath      File path parameter.
     * @param string $appendContent Content string that will be appended into file.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If any error raised when trying to access the file.
     *
     * @return boolean
     */
    public function appendIntoFile($filePath, $appendContent);

    /**
     * Copy the directory or file.
     *
     * @param string $sourcePath Directory or file source path parameter.
     * @param string $targetPath Directory or file target source path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid target target path given.
     *
     * @return boolean
     */
    public function doCopy($sourcePath, $targetPath);

    /**
     * Delete directory or file.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid path given.
     *
     * @return boolean
     */
    public function doDelete($path);

    /**
     * Move directory or file.
     *
     * @param string $sourcePath Directory or file source path parameter.
     * @param string $targetPath Directory or file target source path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid source path given.
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid target path given.
     *
     * @return boolean
     */
    public function doMove($sourcePath, $targetPath);

    /**
     * Rename directory or file.
     *
     * @param string $sourcePath Directory or file source path parameter.
     * @param string $targetPath Directory or file target source path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid source path given.
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid target path given.
     *
     * @return boolean
     */
    public function doRename($sourcePath, $targetPath);

    /**
     * Get file contents.
     *
     * @param string $filePath File path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid file path given.
     *
     * @return string
     */
    public function getFileContents($filePath);

    /**
     * Get directory or file information.
     *
     * @param string $path Directory or file source path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return array
     */
    public function getInfo($path);

    /**
     * Get metadata information.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return array
     */
    public function getMetadata($path);

    /**
     * Get size of directory or file path.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return float
     */
    public function getSize($path);

    /**
     * Get timestamps array information data of directory or file.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return array
     */
    public function getTimeStamps($path);

    /**
     * Get the visibility/access information of directory or file.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return array
     */
    public function getVisibility($path);

    /**
     * Check if the path given is a directory.
     *
     * @param string $dirPath Directory path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return mixed
     */
    public function isDirectory($dirPath);

    /**
     * Check if directory or file is exists.
     *
     * @param string $path Directory or file path parameter.
     *
     * @return boolean
     */
    public function isExists($path);

    /**
     * Check if the path given is a file.
     *
     * @param string $filePath File path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return boolean
     */
    public function isFile($filePath);

    /**
     * Check if the path given is writable.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return boolean
     */
    public function isWritable($path);

    /**
     * List all contents under directory.
     *
     * @param string  $dirPath   Directory path parameter.
     * @param boolean $recursive List content recursively option.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid directory path given.
     *
     * @return array
     */
    public function listContents($dirPath = null, $recursive = false);

    /**
     * Make a directory under a directory path.
     *
     * @param string $dirPath Directory path name parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If invalid directory path given.
     *
     * @return boolean
     */
    public function makeDirectory($dirPath);

    /**
     * Make new file.
     *
     * @param string $filePath File path parameter.
     * @param string $contents File contents parameter.
     * @param array  $config   Configuration data option parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid file path given.
     *
     * @return boolean
     */
    public function makeFile($filePath, $contents = null, array $config = []);

    /**
     * Prepends contents into file.
     *
     * @param string $filePath       File path parameter.
     * @param string $prependContent Content string that will be prepended into file.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If any error raised when trying to access the file.
     *
     * @return boolean
     */
    public function prependIntoFile($filePath, $prependContent);

    /**
     * Put contents into file.
     *
     * @param string $filePath File path parameter.
     * @param string $contents Content string parameter.
     * @param array  $config   Configuration data array parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error Cannot access the file path.
     *
     * @return integer
     */
    public function putIntoFile($filePath, $contents, array $config = []);

    /**
     * Set the visibility/access information of directory or file.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return boolean
     */
    public function setVisibility($path);
}
