<?php
/**
 * Code written is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   Components
 * @author    Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright 2016 Developer
 * @license   - No License
 * @version   GIT: $Id$
 * @link      -
 */
namespace Bridge\Components\RuleDesigner\Contracts;

/**
 * RuleSpecificationInterface class description.
 *
 * @package    Components
 * @subpackage RuleDesigner\Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface RuleSpecificationInterface
{

    public function isSatisfiedBy();

    public function plus();

    public function either();

    public function isNot();

}
