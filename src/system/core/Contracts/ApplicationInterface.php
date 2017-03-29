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
 * ApplicationInterface class description.
 *
 * @package    Core
 * @subpackage Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface ApplicationInterface
{

    /**
     * Put down the application for maintenance mode.
     *
     * @return void
     */
    public function down();

    /**
     * Get application path property.
     *
     * @return string
     */
    public function getApplicationPath();

    /**
     * Get application base path property.
     *
     * @return string
     */
    public function getBasePath();

    /**
     * Get application environment path property.
     *
     * @return string
     */
    public function getEnvironmentPath();

    /**
     * Get application name property.
     *
     * @return string
     */
    public function getName();

    /**
     * Get application namespace property.
     *
     * @return string
     */
    public function getNameSpace();

    /**
     * Get application settings array data property.
     *
     * @return array
     */
    public function getSettings();

    /**
     * Get application state property.
     *
     * @return string
     */
    public function getState();

    /**
     * Get application storage path property.
     *
     * @return string
     */
    public function getStoragePath();

    /**
     * Get application version property.
     *
     * @return string
     */
    public function getVersion();

    /**
     * Run the application.
     *
     * @throws \Bridge\Core\Exceptions\Types\Error If application failed to launch.
     * @return void
     */
    public function run();
}
