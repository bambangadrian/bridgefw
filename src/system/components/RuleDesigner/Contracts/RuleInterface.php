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
 * RuleInterface class description.
 *
 * @package    Components
 * @subpackage RuleDesigner\Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface RuleInterface
{

    /**
     * Add rule item into rules collection attribute.
     *
     * @param \Bridge\Components\RuleDesigner\Contracts\RuleItemInterface $ruleItemObj Rule item instance parameter
     *                                                                                 that will be added into rules
     *                                                                                 table.
     *
     * @return void
     */
    public function addRuleItem(\Bridge\Components\RuleDesigner\Contracts\RuleItemInterface $ruleItemObj);

    /**
     * Get tax component rule name property.
     *
     * @return string
     */
    public function getRuleName();

    /**
     * Get rules data information.
     *
     * @return \Bridge\Components\RuleDesigner\Contracts\RuleItemInterface[]
     */
    public function getRules();

    /**
     * Return the match rule value based on the given parameter.
     *
     * @param mixed $valueParam Value that will checked by the rule.
     *
     * @return mixed
     */
    public function getValueOf($valueParam);

    /**
     * Get the state if rule object is a multiple rule model.
     *
     * @return boolean
     */
    public function isMultipleRule();

    /**
     * Get the state if rule object is a single rule model.
     *
     * @return boolean
     */
    public function isSingleRule();

    /**
     * Get the state if rule object use levelling calculation model or not.
     *
     * @return boolean
     */
    public function isUseLevelling();

    /**
     * Get the state if the rules is valid or not.
     *
     * @return boolean
     */
    public function isValidRule();

    /**
     * Set rules data collection attributes.
     *
     * @param array $arrRules Array of rule item collection parameter.
     *
     * @return void
     */
    public function setRules(array $arrRules);

    /**
     * Set the calculation
     *
     * @param boolean $useLevelling Use levelling state parameter.
     *
     * @return void
     */
    public function setUseLevelling($useLevelling = false);

    /**
     * Do validate the rules items that already assigned.
     *
     * @return void
     */
    public function validateRule();
}
