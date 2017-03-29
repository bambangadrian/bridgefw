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
namespace Bridge\Core\Gui;

/**
 * Html class description.
 *
 * @package    Core
 * @subpackage Gui
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class HtmlPage
{

    /**
     * Html page body content array property.
     *
     * @var array $Contents
     */
    private $Contents = [];

    /**
     * Html page footer content array property.
     *
     * @var array $Footers
     */
    private $Footers = [];

    /**
     * Html page header content array property.
     *
     * @var array $Headers
     */
    private $Headers = [];

    /**
     * Html version property that will be used.
     *
     * @var string $HtmlVersion
     */
    private $HtmlVersion = '5.0';

    /**
     * Html page title property.
     *
     * @var string $Title
     */
    private $Title;

    /**
     * HtmlPage constructor.
     */
    public function __construct()
    {
        # TODO: Implement html page construct method.
    }
}
