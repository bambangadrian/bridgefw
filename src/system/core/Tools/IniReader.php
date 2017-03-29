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
namespace Bridge\Core\Tools;

/**
 * IniFileReader class description.
 *
 * @package    Core
 * @subpackage Utils
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class IniReader
{

    /**
     * Option property to use segment to parse the ini data.
     *
     * @var boolean $UseSection
     */
    protected $UseSection = false;

    /**
     * Ini file data property.
     *
     * @var array $Data
     */
    private $IniData = [];

    /**
     * Ini file path property.
     *
     * @var string $IniFile
     */
    private $IniFile;

    /**
     * Sections data array property on file.
     *
     * @var array $Sections
     */
    private $Sections = [];

    /**
     * Class constructor.
     *
     * @param string $iniFile Ini file path parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If any error raised when construct the ini reader object.
     */
    public function __construct($iniFile)
    {
        try {
            # Load the storage core library components.
            # Set the filename.
            $this->setIniFile($iniFile);
            # Load the file.
            $this->loadFile();
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Debug($e->getMessage());
        }
    }

    /**
     * Get ini data property.
     *
     * @return array
     */
    public function getIniData()
    {
    }

    /**
     * Get ini file path property.
     *
     * @return string
     */
    public function getIniFile()
    {
        return $this->IniFile;
    }

    /**
     * Get key value.
     *
     * @param string $keyName     Key name parameter.
     * @param string $sectionName Section name parameter.
     *
     * @return string
     */
    public function getKeyValue($keyName, $sectionName = '')
    {
    }

    /**
     * Get keys data array under a section.
     *
     * @param string $sectionName Section name parameter.
     *
     * @return array
     */
    public function getKeys($sectionName)
    {
    }

    /**
     * Get section data.
     *
     * @return array
     */
    public function getSectionData()
    {
    }

    /**
     * Retrieve all the sections property.
     *
     * @return array
     */
    public function getSections()
    {
        return $this->Sections;
    }

    /**
     * Check if key exists in a section or in the loaded file.
     *
     * @param string $sectionName Section name parameter (Optional).
     *
     * @return boolean
     */
    public function isKeyExists($sectionName = '')
    {
    }

    /**
     * Check if section exists.
     *
     * @param string $sectionName Section name parameter.
     *
     * @return boolean
     */
    public function isSectionExists($sectionName)
    {
    }

    /**
     * Set ini file path property.
     *
     * @param string $filePath File name path parameter.
     *
     * @return void
     */
    public function setIniFile($filePath)
    {
        $this->IniFile = $filePath;
    }

    /**
     * Set new or rewrite key and value under a section.
     *
     * @param string $keyName     Key name parameter.
     * @param string $keyValue    Key value parameter.
     * @param string $sectionName Section name parameter
     *
     * @return void
     */
    public function setKey($keyName, $keyValue, $sectionName)
    {
    }

    /**
     * Load ini file and set the ini data property.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid ini file configuration data was found.
     *
     * @return void
     */
    protected function loadFile()
    {
        # Parse the ini file.
        $this->IniData = parse_ini_file($this->getIniFile(), true);
        # Validate the information data.
        if ($this->validateIniData() === true) {
        } else {
            throw new \Bridge\Core\Exceptions\Types\Debug('Invalid ini file configuration data was found');
        }
    }

    /**
     * Validate the ini data information.
     *
     * @return boolean
     */
    protected function validateIniData()
    {
        # Validate content data on ini file.
    }
}
