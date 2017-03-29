<?php
/**
 * Contains code written by the Invosa Systems Company and is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   -
 * @author    Bambang Adrian Sitompul <bambang@invosa.com>
 * @copyright 2016 Invosa Systems Indonesia
 * @license   http://www.invosa.com/license No License
 * @version   GIT: $Id$
 * @link      http://www.invosa.com
 */
include_once 'TestBootstrap.php';
# Create new application.
$application = new \Bridge\Core\System\Application('devosa', '1.0.0');
# Start the application.
# On the application run there will steps to complete phase:
# - Get the system configuration.
# - Run the kernel.
# --- Checking all the loaded driver for the first time.
# --- Put the kernel system status into session that has been loaded so, it will be more faster
#     cause all the kernel check and validation only run every time the system config has been changed.
# -
$application->run();
# Mock-up to shutdown the system.

# Mock-up to put the
