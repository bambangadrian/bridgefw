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
namespace Bridge\Core\Gui\Types;

/**
 * AbstractInputElement class description.
 *
 * @package    Core
 * @subpackage Gui\Types
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractInputElement extends \Bridge\Core\Gui\AbstractHtmlElement
{

    /**
     * Form object property that will binding the input field object.
     *
     * @var \Bridge\Core\Gui\Elements\AbstractForm $Form
     */
    protected $Form;

    /**
     * Binding the input element into form object.
     *
     * @param \Bridge\Core\Gui\Elements\AbstractForm $formObject Form object parameter.
     *
     * @return void
     */
    public function setForm(\Bridge\Core\Gui\Elements\AbstractForm $formObject)
    {
    }
}
