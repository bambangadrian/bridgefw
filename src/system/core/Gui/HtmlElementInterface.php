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
 * HtmlElementInterface class description.
 *
 * @package    Core
 * @subpackage Gui
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface HtmlElementInterface
{

    /**
     * Render the ui element.
     *
     * @return string
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid element object that detected want to be rendered.
     */
    public function render();
}
