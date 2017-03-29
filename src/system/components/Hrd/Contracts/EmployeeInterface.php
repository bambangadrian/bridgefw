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
namespace Bridge\Components\Hrd\Contracts;

/**
 * EmployeeInterface class description.
 *
 * @package    Components
 * @subpackage Hrd\Contracts
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
interface EmployeeInterface
{

    /**
     * Get company object where the employee working at.
     *
     * @return \Bridge\Components\Hrd\Contracts\CompanyInterface
     */
    public function getCompanyObj();

    /**
     * Get company name where the employee working at.
     *
     * @return string
     */
    public function getCompanyName();

    /**
     * Get company branch object where the employee working at.
     *
     * @return \Bridge\Components\Hrd\Contracts\CompanyBranchInterface
     */
    public function getCompanyBranchObj();

    /**
     * Get company branch name where the employee working at.
     *
     * @return string
     */
    public function getCompanyBranchName();

    /**
     * Get employee age in year.
     *
     * @return integer
     */
    public function getAge();

    /**
     * Get employee birth date attribute.
     *
     * @return string
     */
    public function getBirthDate();

    /**
     * Get employee marital status attribute.
     *
     * @return integer
     */
    public function getMaritalStatus();

    /**
     * Get employee name attribute.
     *
     * @return string
     */
    public function getName();

    /**
     * Get employment contract object property.
     *
     * @return \Bridge\Components\Hrd\Contracts\EmploymentContractInterface
     */
    public function getEmploymentContractObj();

    /**
     * Get employment contract status.
     *
     * @return string
     */
    public function getContractStatus();

    /**
     * Get employment contract length.
     *
     * @return integer
     */
    public function getContractLength();

    /**
     * Get employment contract period.
     *
     * @return string
     */
    public function getContractPeriod();

    /**
     * Get contract information data array property.
     *
     * @return array
     */
    public function getContractInformation();

    /**
     * Get status if employee has npwp or not.
     *
     * @return boolean
     */
    public function hasNpwp();

    /**
     * Get npwp number property.
     *
     * @return string
     */
    public function getNpwp();

    /**
     * Get started work month property.
     *
     * @return integer
     */
    public function getStartedWorkMonth();

    /**
     * Get ended work month property.
     *
     * @return integer
     */
    public function getEndedWorkMonth();

    /**
     * Get employment active working period.
     *
     * @return string
     */
    public function getActiveWorkingPeriod();

    /**
     * Get number of dependents property.
     *
     * @return integer
     */
    public function getNumberOfDependents();
}
