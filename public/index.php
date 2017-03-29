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
require_once '../vendor/autoload.php';
require_once '../application/function.inc.php';
$devosaApp = new \Devosa\Package\DevosaApp();
$devosaApp->setApplicationName('old-devosa');
$devosaApp->setVersion('1.0.0');
$devosaApp->down();