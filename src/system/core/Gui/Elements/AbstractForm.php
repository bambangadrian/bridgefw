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
namespace Bridge\Core\Gui\Elements;

/**
 * AbstractForm class description.
 *
 * @package    Core
 * @subpackage Gui\Elements\Container
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractForm extends \Bridge\Core\Gui\Types\AbstractHtmlContainer
{

    /**
     * Submit the form.
     *
     * @return void
     */
    public function doSubmit()
    {
    }

    /**
     * Get all binding post or get data.
     *
     * @return array
     */
    public function getDataBinding()
    {
        return [];
    }
}
