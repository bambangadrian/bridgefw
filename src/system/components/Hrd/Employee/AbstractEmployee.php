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
 * AbstractEmployee class description.
 *
 * @package    Components
 * @subpackage Hrd\Employee
 * @author     Bambang Adrian Sitompul <bambang.adrian@gmail.com>
 * @copyright  2016 -
 * @release    $Revision$
 */
abstract class AbstractEmployee implements \Bridge\Components\Hrd\Contracts\EmployeeInterface
{

    /**
     * Birth date property.
     *
     * @var \Bridge\Core\Supports\DataTypes\DateType
     */
    protected $BirthDate;

    /**
     * Company branch object property.
     *
     * @var \Bridge\Components\Hrd\Contracts\CompanyBranchInterface
     */
    protected $CompanyBranchObj;

    /**
     * Company object property.
     *
     * @var \Bridge\Components\Hrd\Contracts\CompanyInterface
     */
    protected $CompanyObj;

    /**
     * Employee dependents property.
     *
     * @var array $Dependents
     */
    protected $Dependents = [];

    /**
     * Employee name property.
     *
     * @var string $Name
     */
    protected $Name;

    /**
     * Get company object where the employee working at.
     *
     * @return \Bridge\Components\Hrd\Contracts\CompanyInterface
     */
    public function getCompanyObj()
    {
        # TODO: Implement getCompanyObj() method.
    }

    /**
     * Get company name where the employee working at.
     *
     * @return string
     */
    public function getCompanyName()
    {
        # TODO: Implement getCompanyName() method.
    }

    /**
     * Get company branch object where the employee working at.
     *
     * @return \Bridge\Components\Hrd\Contracts\CompanyBranchInterface
     */
    public function getCompanyBranchObj()
    {
        # TODO: Implement getCompanyBranchObj() method.
    }

    /**
     * Get company branch name where the employee working at.
     *
     * @return string
     */
    public function getCompanyBranchName()
    {
        # TODO: Implement getCompanyBranchName() method.
    }

    /**
     * Get employee age in year.
     *
     * @return integer
     */
    public function getAge()
    {
        # TODO: Implement getAge() method.
    }

    /**
     * Get employee birth date attribute.
     *
     * @return string
     */
    public function getBirthDate()
    {
        # TODO: Implement getBirthDate() method.
    }

    /**
     * Get employee marital status attribute.
     *
     * @return integer
     */
    public function getMaritalStatus()
    {
        # TODO: Implement getMaritalStatus() method.
    }

    /**
     * Get employee name attribute.
     *
     * @return string
     */
    public function getName()
    {
        # TODO: Implement getName() method.
    }

    /**
     * Get employment contract object property.
     *
     * @return \Bridge\Components\Hrd\Contracts\EmploymentContractInterface
     */
    public function getEmploymentContractObj()
    {
        # TODO: Implement getEmploymentContractObj() method.
    }

    /**
     * Get employment contract status.
     *
     * @return string
     */
    public function getContractStatus()
    {
        # TODO: Implement getContractStatus() method.
    }

    /**
     * Get employment contract length.
     *
     * @return integer
     */
    public function getContractLength()
    {
        # TODO: Implement getContractLength() method.
    }

    /**
     * Get employment contract period.
     *
     * @return string
     */
    public function getContractPeriod()
    {
        # TODO: Implement getContractPeriod() method.
    }

    /**
     * Get contract information data array property.
     *
     * @return array
     */
    public function getContractInformation()
    {
        # TODO: Implement getContractInformation() method.
    }

    /**
     * Get status if employee has npwp or not.
     *
     * @return boolean
     */
    public function hasNpwp()
    {
        # TODO: Implement hasNpwp() method.
    }

    /**
     * Get npwp number property.
     *
     * @return string
     */
    public function getNpwp()
    {
        # TODO: Implement getNpwp() method.
    }

    /**
     * Get started work month property.
     *
     * @return integer
     */
    public function getStartedWorkMonth()
    {
        # TODO: Implement getStartedWorkMonth() method.
    }

    /**
     * Get ended work month property.
     *
     * @return integer
     */
    public function getEndedWorkMonth()
    {
        # TODO: Implement getEndedWorkMonth() method.
    }

    /**
     * Get employment active working period.
     *
     * @return string
     */
    public function getActiveWorkingPeriod()
    {
        # TODO: Implement getActiveWorkingPeriod() method.
    }

    /**
     * Get number of dependents property.
     *
     * @return integer
     */
    public function getNumberOfDependents()
    {
        # TODO: Implement getNumberOfDependents() method.
    }
}
