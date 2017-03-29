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
 * AbstractHtmlContainer class description.
 * This class using composite pattern.
 *
 * @package    Core
 * @subpackage Gui\Types
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractHtmlContainer extends \Bridge\Core\Gui\AbstractHtmlElement
{

    /**
     * Children element collection property that added into container.
     *
     * @var array $ChildCollection
     */
    protected $ChildCollection = [];

    /**
     * Add content to html container element.
     *
     * @param \Bridge\Core\Gui\HtmlElementInterface $contentObject Html element object parameter.
     *
     * @return void
     */
    public function addElement(\Bridge\Core\Gui\HtmlElementInterface $contentObject)
    {
        $this->ChildCollection[] = $contentObject;
    }
}
