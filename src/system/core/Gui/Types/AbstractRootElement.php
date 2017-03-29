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
 * AbstractRootElement class description.
 *
 * @package    Core
 * @subpackage Gui\Types
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractRootElement extends \Bridge\Core\Gui\AbstractHtmlElement
{

    /**
     * Allowed elements tag data array property.
     *
     * @var array $AllowedElementTags
     */
    protected static $AllowedElementTags = [];
}
