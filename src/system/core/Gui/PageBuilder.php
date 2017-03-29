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
 * PageBuilder class description.
 *
 * @package    Core
 * @subpackage Gui
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class PageBuilder implements \Bridge\Core\Contracts\BuilderInterface
{

    /**
     * PageBuilder constructor.
     *
     * @param \Bridge\Core\Gui\HtmlPage $htmlObject Html page object parameter.
     *
     * @throws \Bridge\Core\Exceptions\Types\Debug If invalid html object given.
     */
    public function __construct(\Bridge\Core\Gui\HtmlPage $htmlObject)
    {
        try {
            # TODO: Implement page builder construct method.
        } catch (\Exception $e) {
            throw new \Bridge\Core\Exceptions\Types\Debug($e->getMessage());
        }
    }
}
