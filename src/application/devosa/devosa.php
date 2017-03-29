<?php
/**
 * Code written is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   Public
 * @author    Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright 2016 Developer
 * @license   - No License
 * @version   GIT: $Id$
 * @link      -
 */
namespace Devosa\Package;

/**
 * App class description.
 *
 * @package    Public
 * @subpackage -
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class DevosaApp extends \Devosa\Core\System\Application
{

    public function __construct()
    {
        $this->setName('devosaHR');
        $this->setVersion('1.0.0');
    }

    /**
     * Shutdown the application for maintenance mode.
     *
     * @return void
     */
    public function down()
    {
        # TODO: Mail the systems watcher that system application was down.
        # TODO: Record the log for system application maintenance mode.
        # TODO: Do backup, clear cache, clean the unused files/data on maintenance mode.
        echo 'SYSTEM APPLICATION ON MAINTENANCE MODE';
    }

    /**
     * Run the application.
     *
     * @throws \Devosa\Core\Exceptions\Types\Error If any step on the
     * @return void
     */
    public function run()
    {
        try {
            \Devosa\Core\System\System::init();
            $appRoute = new \Devosa\Core\System\Router();
            $appRoute->doRoute();
        } catch (\Exception $e) {
            throw new \Devosa\Core\Exceptions\Types\Error(
                'System application failed to run, error: ' . $e->getMessage()
            );
        }
    }
}
