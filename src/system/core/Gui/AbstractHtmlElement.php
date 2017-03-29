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
 * UiElement class description.
 *
 * @package    Core
 * @subpackage Gui
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractHtmlElement implements \Bridge\Core\Gui\HtmlElementInterface
{

    /**
     * Ui element content property.
     *
     * @var string $Content
     */
    protected $Content;

    /**
     * Tag element property.
     *
     * @var string $Tag
     */
    protected $Tag;

    /**
     * Render the ui element.
     *
     * @param array $options Rendering element option data array parameter.
     *
     * @return string
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid element object that detected want to be rendered.
     */
    public function render(array $options = [])
    {
    }
}
