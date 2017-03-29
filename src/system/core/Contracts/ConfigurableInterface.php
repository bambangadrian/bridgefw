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
namespace Bridge\Core\Contracts;

/**
 * ConfigurableInterface class description.
 *
 * @package    Core
 * @subpackage Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface ConfigurableInterface
{

    /**
     * Get the configuration data item.
     *
     * @param string $key Config key item parameter.
     *
     * @return string
     */
    public function getConfig($key);

    /**
     * Load configuration data process.
     *
     * @return void
     */
    public function loadConfig();

    /**
     * Main method to set the config data.
     *
     * @param array $config Configuration data array parameter.
     *
     * @return void
     */
    public function setConfig(array $config);
}
