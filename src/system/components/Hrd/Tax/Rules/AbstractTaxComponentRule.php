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
namespace Bridge\Components\Hrd\Tax\Rules;

/**
 * AbstractTaxComponentRule class description.
 *
 * @package    Components
 * @subpackage Hrd\Tax\Rules
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractTaxComponentRule extends \Bridge\Components\RuleDesigner\Types\FloatRuleType
{

    /**
     * Maximum rule value property.
     *
     * @var float $MaximumValue
     */
    protected $MaximumValue;

    /**
     * Minimum rule value property.
     *
     * @var float $MinimumValue
     */
    protected $MinimumValue;

    /**
     * Rule levelling modeul that will be used to determine the value of matched condidtion.
     *
     * @var \Bridge\Components\Hrd\Tax\Contracts\TaxComponentRuleModelInterface
     */
    protected $RuleLevellingModel;

    /**
     * Rule name property.
     *
     * @var string $RuleName
     */
    protected $RuleName;

    /**
     * Rule items data collection.
     *
     * @var \Bridge\Components\Hrd\Tax\Contracts\TaxComponentRuleItemInterface[] $Rules
     */
    protected $Rules;

    /**
     * State of rule was using a levelling model or not.
     *
     * @var boolean $UseLevelling
     */
    protected $UseLevelling;

    /**
     * Add rule item into rules collection attribute.
     *
     * @param \Bridge\Components\Hrd\Tax\Rules\TaxComponentRuleItem $ruleItemObj Rule item instance parameter that will
     *                                                                           be added into rules table.
     *
     * @return void
     */
    public function addRuleItem($ruleItemObj)
    {
        # TODO: Implement addRuleItem() method.
    }

    /**
     * Get default maximum value of rule object.
     *
     * @return float
     */
    public function getMaximumValue()
    {
        # TODO: Implement getMaximumValue() method.
    }

    /**
     * Get default minimum value of rule object.
     *
     * @return float
     */
    public function getMinimumValue()
    {
        # TODO: Implement getMinimumValue() method.
    }

    /**
     * Get tax component rule name property.
     *
     * @return string
     */
    public function getRuleName()
    {
        # TODO: Implement getRuleName() method.
    }

    /**
     * Get rules data information.
     *
     * @return array
     */
    public function getRules()
    {
        # TODO: Implement getRules() method.
    }

    /**
     * Return the match rule value based on the given parameter.
     *
     * @param float $valueParam Value that will checked by the rule.
     *
     * @return float
     */
    public function getValueOf($valueParam)
    {
        # TODO: Implement getValueOf() method.
    }

    /**
     * Get the state if rule object is a multiple rule model.
     *
     * @return boolean
     */
    public function isMultipleRule()
    {
        # TODO: Implement isMultipleRule() method.
    }

    /**
     * Get the state if rule object is a single rule model.
     *
     * @return boolean
     */
    public function isSingleRule()
    {
        # TODO: Implement isSingleRule() method.
    }

    /**
     * Get the state if rule object use levelling calculation model or not.
     *
     * @return boolean
     */
    public function isUseLevelling()
    {
        # TODO: Implement isUseLevelling() method.
    }

    /**
     * Get the state if the rules is valid or not.
     *
     * @return boolean
     */
    public function isValidRule()
    {
        # TODO: Implement isValidRule() method.
    }

    /**
     * Set rules data collection attributes.
     *
     * @param \Bridge\Components\Hrd\Tax\Rules\TaxComponentRuleItem[] $arrRules Array of rule item collection parameter.
     *
     * @return void
     */
    public function setRules(array $arrRules)
    {
        # TODO: Implement setRules() method.
    }

    /**
     * Set the calculation
     *
     * @param boolean $useLevelling Use levelling state parameter.
     *
     * @return void
     */
    public function setUseLevelling($useLevelling = false)
    {
        # TODO: Implement setUseLevelling() method.
    }

    /**
     * Do validate the rules items that already assigned.
     *
     * @return void
     */
    public function validateRule()
    {
        # TODO: Implement validateRule() method.
    }
}
