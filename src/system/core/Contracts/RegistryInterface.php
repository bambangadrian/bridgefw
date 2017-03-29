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
 * RegistryInterface class description.
 *
 * @package    Core
 * @subpackage Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface RegistryInterface
{

    /**
     * Register object to registry.
     *
     * @param \Bridge\Core\Contracts\RegistrableInterface $object    Object parameter that want to registered.
     * @param string                                      $indexName The index name for registered object.
     *
     * @return void
     */
    public function doRegister(\Bridge\Core\Contracts\RegistrableInterface $object, $indexName);

    /**
     * Remove the specific object from registry.
     *
     * @param string $name The index name of registered object that want to be removed.
     *
     * @return void
     */
    public function doRemove($name);

    /**
     * Check if the object name was registered on registry.
     *
     * @param string $name The index name of registered object parameter.
     *
     * @return boolean
     */
    public function isRegistered($name);
}
