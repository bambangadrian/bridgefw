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
namespace Bridge\Core\Contracts;

/**
 * ResponseInterface class description.
 *
 * @package    Core
 * @subpackage Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface ResponseInterface
{

    /**
     * Do parse the response to array.
     *
     * @return array
     */
    public function doParseToArray();

    /**
     * Do parse the response to json string.
     *
     * @return string
     */
    public function doParseToJson();

    /**
     * Get raw response.
     *
     * @return string
     */
    public function getRaw();
}
