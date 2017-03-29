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
namespace Bridge\Components\Hrd\Employee;

/**
 * TaxableEmployee class will be used for taxation module.
 *
 * @package    Components
 * @subpackage Hrd\Employee
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
class TaxableEmployee extends \Bridge\Components\Hrd\Employee\GeneralEmployee
{

    /**
     * Get all tax calculation data information.
     *
     * @return array
     */
    public function getTaxCalculationData()
    {
    }
}
