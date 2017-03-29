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
# Create the storage instance for the application
#   This will be read the storage setting itself that assigned/stored by the application
$storage = new \Bridge\Core\FileSystem\Storage($application);
