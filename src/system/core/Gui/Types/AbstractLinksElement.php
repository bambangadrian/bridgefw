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
 * AbstractLinksElement class description.
 *
 * @package    Core
 * @subpackage Gui\Types
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractLinksElement extends \Bridge\Core\Gui\AbstractHtmlElement
{

    /**
     * Link path property.
     *
     * @var string $Path
     */
    protected $Path;

    /**
     * Set path for link element.
     *
     * @param string $path Link path parameter.
     *
     * @return void
     */
    public function setPath($path = '#')
    {
        # TODO: Implement abstract link element setPath() method.
    }
}
