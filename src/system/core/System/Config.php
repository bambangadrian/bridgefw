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
 * Config class description.
 *
 * @package    Core
 * @subpackage System
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class Config implements \Bridge\Core\Contracts\ConfigInterface
{

    /**
     * Constraint type for config item data property.
     *
     * @var array $Constraints
     */
    protected $Constraints = [];

    /**
     * Configuration data array property.
     *
     * @var array $Data
     */
    protected $Data = [];

    /**
     * Default value data array for config item property.
     *
     * @var array $Defaults
     */
    protected $Defaults = [];

    /**
     * Configuration item data array.
     *
     * @var array $Items
     */
    protected $Items = [];

    /**
     * Required config data collection property.
     *
     * @var array $RequiredItems
     */
    protected $RequiredItems = [];

    /**
     * Configuration data resource from property.
     *
     * @var string $Resource
     */
    protected $Resource;

    /**
     * Config resource handler full name property.
     *
     * @var string $ResourceHandlerName
     */
    protected $ResourceHandlerName;

    /**
     * Configuration type property.
     *
     * @var string $Type
     */
    protected $Type;

    /**
     * Valid configuration resource type data collection.
     *
     * @var array $ValidResource
     */
    private static $ValidResource = ['db', 'file', 'session', 'array'];

    /**
     * Valid configuration type constraint data collection.
     *
     * @var array $ValidType
     */
    private static $ValidType = ['system', 'kernel', 'application', 'library', 'module'];

    /**
     * Class constructor.
     *
     * @param string $resource   Configuration resource parameter.
     * @param string $type       Configuration type parameter.
     * @param array  $configData Configuration data array parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid config file given.
     */
    public function __construct($resource = 'file', $type = 'application', array $configData = [])
    {
        try {
            # Set the configuration resource type and handler.
            $this->setResource($resource);
            # Set the configuration type.
            $this->setType($type);
            # Set the configuration data content.
            $this->setData($configData);
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Debug($e->getMessage());
        }
    }

    public function getConstraints()
    {
    }

    public function getDefaults()
    {
    }

    /**
     * Get config item of specific section
     *
     * @param string $key     Configuration item name parameter.
     * @param string $segment Configuration segment name parameter.
     *
     * @return string
     */
    public function getItem($key, $segment = null)
    {
    }

    /**
     * Get all configuration data.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->Data;
    }

    public function getRequiredItems()
    {
    }

    public function hasItem($key, $segment = null)
    {
    }

    public function setConstraints(array $constraints = [])
    {
    }

    /**
     * Set configuration data property.
     *
     * @param array $configData Configuration data parameter.
     *
     * @return void
     */
    public function setData(array $configData = [])
    {
        $this->Data = $configData;
    }

    public function setDefaults(array $defaults = [])
    {
    }

    public function setItem($key, $value, $segment = null)
    {
    }

    public function setRequiredItems(array $requiredItems = [])
    {
    }

    /**
     * Set configuration resource type property.
     *
     * @param string $resource $resource
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid configuration resource given.
     *
     * @return void
     */
    public function setResource($resource)
    {
        if ($this->isValidResource($resource) === false) {
            throw new \Bridge\Core\Exceptions\Types\Debug('Invalid configuration resource given');
        }
        $this->Resource = strtolower($resource);
        $this->resolveResourceHandler();
    }

    /**
     * Set configuration type property.
     *
     * @param string $type Configuration type parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid configuration type given.
     * @return void
     */
    public function setType($type)
    {
        if ($this->isValidType($type) === false) {
            throw new \Bridge\Core\Exceptions\Types\Debug('Invalid configuration type given');
        }
        $this->Type = $type;
    }

    /**
     * Validate configuration resource.
     *
     * @param string $resource Configuration resource parameter.
     *
     * @return boolean
     */
    protected function isValidResource($resource)
    {
        return in_array(strtolower($resource), static::$ValidResource, true);
    }

    /**
     * Validate the configuration type property.
     *
     * @param string $type Configuration type parameter.
     *
     * @return boolean
     */
    protected function isValidType($type)
    {
        return in_array(strtolower($type), static::$ValidType, true);
    }

    /**
     * Load configuration data process.
     *
     * @return void
     */
    protected function  loadData()
    {
    }

    /**
     * Resolve resource handler instance from given configuration resource type.
     *
     * @return void
     */
    protected function resolveResourceHandler()
    {
        # TODO: Resolve the configuration resource handler instance.
    }

    /**
     * Validate configuration data array based the required, and constraint data property.
     *
     * @param array $data Configuration data array parameter.
     *
     * @return boolean
     */
    protected function validateData(array $data)
    {
    }
}
