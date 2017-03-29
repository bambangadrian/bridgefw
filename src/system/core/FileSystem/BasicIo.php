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
 * BasicIo class description.
 *
 * @package    Core
 * @subpackage FileSystem
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class BasicIo
{

    /**
     * Appends contents into file.
     *
     * @param string $filePath      File path parameter.
     * @param string $appendContent Content string that will be appended into file.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If given path does not exists.
     * @throws \Bridge\Core\Exceptions\Types\Error If any error raised when trying to access the file.
     *
     * @return boolean
     */
    public function appendIntoFile($filePath, $appendContent)
    {
        try {
            if ($this->isExists($filePath) === true) {
                return $this->putIntoFile($filePath, $appendContent, FILE_APPEND);
            } else {
                throw new \Bridge\Core\Exceptions\Types\Warning('Given path does not exists');
            }
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Error(
                'Failed to append the content into ' . $filePath . ' (' . $e->getMessage() . ')'
            );
        }
    }

    /**
     * Delete directory or file.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid path given.
     *
     * @return boolean
     */
    public function doDelete($path)
    {
        # TODO: Implement doDelete() method.
    }

    /**
     * Get file contents.
     *
     * @param string $filePath File path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid file path given.
     *
     * @return string
     */
    public function getFileContents($filePath)
    {
        try {
            if ($this->isFile($filePath) === true) {
                return file_get_contents($filePath);
            } else {
                throw new \Bridge\Core\Exceptions\Types\Warning('Given path is not a file');
            }
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Warning(
                'File does not exists on path: ' . $filePath . '(' . $e->getMessage() . ')'
            );
        }
    }

    /**
     * Check if the path given is a directory.
     *
     * @param string $dirPath Directory path parameter.
     *
     * @return boolean
     */
    public function isDirectory($dirPath)
    {
        return is_dir($dirPath);
    }

    /**
     * Check if directory or file is exists.
     *
     * @param string $path Directory or file path parameter.
     *
     * @return boolean
     */
    public function isExists($path)
    {
        return file_exists($path);
    }

    /**
     * Check if the path given is a file.
     *
     * @param string $filePath File path parameter.
     *
     * @return boolean
     */
    public function isFile($filePath)
    {
        return is_file($filePath);
    }

    /**
     * Check if the path given is writable.
     *
     * @param string $path Directory or file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If invalid path given.
     *
     * @return boolean
     */
    public function isWritable($path)
    {
        return is_writable($path);
    }

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
    public function listContents($dirPath = null, $recursive = false)
    {
        # TODO: Implement listContents() method.
    }

    /**
     * Make a directory under a directory path.
     *
     * @param string  $dirPath        Directory path name parameter.
     * @param integer $permissionMode Permission mode parameter.
     * @param boolean $recursive      Allows the creation of nested directories specified in the path option parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If directory path has already created.
     * @throws \Bridge\Core\Exceptions\Types\Error If invalid directory path given.
     *
     * @return boolean
     */
    public function makeDirectory($dirPath, $permissionMode = 0755, $recursive = false)
    {
        try {
            $result = false;
            # Check if the directory is not yet created.
            if ($this->isDirectory($dirPath) === false) {
                if (mkdir($dirPath, $permissionMode, $recursive) === true) {
                    $result = true;
                }
            } else {
                throw new \Bridge\Core\Exceptions\Types\Warning('Given directory path already exists');
            }
            return $result;
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Error($e->getMessage());
        }
    }

    /**
     * Make new file.
     *
     * @param string  $filePath       File path parameter.
     * @param string  $contents       Data contents parameter.
     * @param boolean $overwrite      Overwrite option flag parameter.
     * @param integer $permissionMode Permission mode flag that will be applied to the created file.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid overwrite option flag given.
     * @throws \Bridge\Core\Exceptions\Types\Warning If any mis-concept or logical error raised when make the file.
     *
     * @return boolean
     */
    public function makeFile($filePath, $contents = null, $overwrite = false, $permissionMode = 0755)
    {
        try {
            # Check the overwrite flag parameter must be on boolean type.
            if (is_bool($overwrite) === false) {
                throw new \Bridge\Core\Exceptions\Types\Debug('Invalid overwrite option flag given');
            }
            # Check if the directory path already exists or not.
            $dirName = dirname($filePath);
            if ($this->isDirectory($dirName) === false and $this->makeDirectory($dirName) === false) {
                throw new \Bridge\Core\Exceptions\Types\Warning(
                    'Cannot make required directory structure, to create the new file: ' . $filePath
                );
            }
            # Check if file already exists or not.
            # Throw warning exception if file already exists but the overwrite mode set to false.
            if ($this->isExists($filePath) and $overwrite === false) {
                throw new \Bridge\Core\Exceptions\Types\Warning(
                    'Cannot create file: file already exists and overwrite method has been protected'
                );
            }
            # If overwrite option set to true, overwrite the existing file.
            if (($fileHandler = fopen($filePath, 'w+')) === false) {
                throw new \Bridge\Core\Exceptions\Types\Warning('Could not open file!');
            }
            # Start to write the file.
            if (fwrite($fileHandler, $contents) === false) {
                throw new \Bridge\Core\Exceptions\Types\Warning('Could not write content to file');
            }
            fclose($fileHandler);
            # Set the permission mode to the file that has been created.
            return chmod($filePath, $permissionMode);
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Warning($e->getMessage());
        }
    }

    /**
     * Prepends contents into file.
     *
     * @param string $filePath       File path parameter.
     * @param string $prependContent Content that will be prepend to the file.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning If given path does not exists.
     * @throws \Bridge\Core\Exceptions\Types\Error If any error raised when trying to access the file.
     *
     * @return boolean
     */
    public function prependIntoFile($filePath, $prependContent)
    {
        try {
            if ($this->isExists($filePath) === true) {
                return $this->putIntoFile($filePath, $prependContent . $this->getFileContents($filePath));
            } else {
                throw new \Bridge\Core\Exceptions\Types\Warning('Given path does not exists');
            }
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Error(
                'Failed to prepend the content into ' . $filePath . ' (' . $e->getMessage() . ')'
            );
        }
    }

    /**
     * Put contents into file.
     *
     * @param string  $filePath File path parameter.
     * @param string  $contents Content string parameter.
     * @param integer $flags    Flags option parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Warning Cannot access the file path.
     *
     * @return integer
     */
    public function putIntoFile($filePath, $contents, $flags = 0)
    {
        # The value of flags can be any combination of the following flags, joined with the binary OR (|) operator.
        # Flag can be on below values:
        # FILE_USE_INCLUDE_PATH: Search for filename in the include directory
        # FILE_APPEND: If file filename already exists, append the data to the file instead of overwriting it.
        # LOCK_EX: Acquire an exclusive lock on the file while proceeding to the writing.
        # This function documentation reference to: http://php.net/manual/en/function.file-put-contents.php
        return file_put_contents($filePath, $contents, $flags);
    }

    /**
     * Bridge function - to include once the needed other file.
     *
     * @param string  $filePath    File path parameter.
     * @param boolean $includeOnce Include once option, enable if you want to check if already included before.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If included file is not exists.
     *
     * @return mixed
     */
    protected function getInclude($filePath, $includeOnce = true)
    {
        # TODO: Please separate between the require_once, include_once, include, and require control structure model.
        if ($this->isFile($filePath) === true) {
            if ($includeOnce === true) {
                return include_once $filePath;
            } else {
                return include $filePath;
            }
        }
        throw new \Bridge\Core\Exceptions\Types\Debug('Cannot include file: ' . $filePath);
    }
}
