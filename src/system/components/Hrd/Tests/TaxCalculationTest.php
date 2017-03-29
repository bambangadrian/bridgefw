<?php
/**
 * Contains code written by the Invosa Systems Company and is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   -
 * @author    Bambang Adrian Sitompul <bambang@invosa.com>
 * @copyright 2016 Invosa Systems Indonesia
 * @license   http://www.invosa.com/license No License
 * @link      http://www.invosa.com
 */


# -------------------- EMPLOYEE INSTANCE CREATION --------------------

# Start to create new company.
$companyObj = new \Bridge\Components\Hrd\Company\GeneralCompany('PT. XXX');

# Create new taxable employee.
$taxableEmployee = new \Bridge\Components\Hrd\Employee\TaxableEmployee('bambang');

$taxableEmployee->setCompany($companyObj);

# Set employee status: [permanent, contract, freelance]
$taxableEmployee->setContractStatus($contractStatus);

# Set basic salary components.
$taxableEmployee->setBasicSalary($salary);

# Set if employee has npwp or not.
$taxableEmployee->setNpwp($npwpNumber);
$taxableEmployee->hasNpwp();
$taxableEmployee->getNpwp();

# Set the started work month.
$taxableEmployee->setStartedWorkMonth($startedWorkMonth);
$taxableEmployee->getStartedWorkMonth();

# Set the ended work month.
$taxableEmployee->setEndedWorkMonth($endedWorkMonth);
$taxableEmployee->getEndedWorkMonth();

# Set marital status [Married, Single].
$taxableEmployee->setMaritalStatus($maritalStatus);
$taxableEmployee->getMaritalStatus();

# Set number of dependents that handled by employee.
$taxableEmployee->setNumberOfDependents();
$taxableEmployee->getNumberOfDependents();

# Get employee tax calculation detail data information.
$taxableEmployee->getTaxCalculationData();


# --------------------- TAX CALCULATION -------------------------------


# Setting-up un-taxable income rules
$ptkpRuleObj = new \Bridge\Components\Hrd\Tax\Rules\UnTaxableIncomeRule();
$ptkpRuleObj->setRules($arrRules);
# Un-taxable income type: TK0-4, K0-4, etc.
$ptkpRuleObj->getUnTaxableIncomeAmountOf($unTaxableIncomeType);


# Create pph21 object.
$pph21Obj = new \Bridge\Components\Hrd\Tax\Types\Pph21($taxableEmployee);
# Load one time configuration for pph21.
$pph21Obj->loadConfig($taxConfig);
# Set the pph21 calculation mode.
$pph21Obj->setCalculationMode(); # Avalaible mode: general.
# Set the tax allowance calculation mode.
$pph21Obj->setTaxAllowanceCalculationMode(); # Nett, Gross, Gross-Up.
# Setting of percentage amount of pph21; eg: 5% will be default.

$pph21Obj->setPph21Percentage($pph21Percentage);
$pph21Obj->getPph21Percentage();
# Set the un-taxable income rules for pph21.
$pph21Obj->setUnTaxableIncomeRule($ptkpRuleObj);
# Set the pph21 calculation formula.
$pph21Obj->setFormula(); # This will be a complete string formula.


# Setting-up all the tax components.
# ----------------------------------

# (1) Create basic salary as tax basic component.
$basicSalaryObj = $pph21Obj->getEmployee()->getBasicSalary();
# OR
$basicSalaryObj = new \Bridge\Components\Hrd\Tax\Sections\TaxBasicComponent($basicSalaryAmount);
$basicSalaryObj->getAmount();
# Then adding the basic salary into pph21 object.
$pph21Obj->addBasicCompnent($basicSalaryObj);


# Tax enhancer components.
# (2) Create accident insurance as tax enhancer component.
$accidentInsuranceObj = new \Bridge\Components\Hrd\Tax\Sections\TaxEnhancerComponent('jkk');
$accidentInsuranceObj->setRules($arrAccidentInsuranceRules);
$accidentInsuranceObj->isOnPercentage();
$accidentInsuranceObj->getRules();
$accidentInsuranceObj->getAmount();
$accidentInsuranceObj->setFormula($strFormula);
$accidentInsuranceObj->setDependentVariables($arrVariable);
$accidentInsuranceObj->doCalculate();

# Setting up instance of life insurance, health insurance, transport allowance, etc => as tax enhancer component.
# These below objects will be had same class-form with other tax enhancer components.
$lifeInsuranceObj = new \Bridge\Components\Hrd\Tax\Sections\TaxEnhancerComponent('jkm');
$lifeInsuranceObj->setRules($arrLifeInsuranceRules);
$healthInsuranceObj = new \Bridge\Components\Hrd\Tax\Sections\TaxEnhancerComponent('bpjs');
$transportAllowanceObj = new \Bridge\Components\Hrd\Tax\Sections\TaxEnhancerComponent('transport');
$housingAllowanceObj = new \Bridge\Components\Hrd\Tax\Sections\TaxEnhancerComponent('housing');
$jamsostekAllowanceObj = new \Bridge\Components\Hrd\Tax\Sections\TaxEnhancerComponent('jamsostek');
$positionalAllowanceObj = new \Bridge\Components\Hrd\Tax\Sections\TaxEnhancerComponent('positional-allowance');

# Add one by one all each of tax enhancer components.
$pph21Obj->addEnhancerComponent($lifeInsuranceObj);
# You can add all the tax enhancer components at one time set.
$pph21Obj->addEnhancerComponents(
    [
        $lifeInsuranceObj,
        $healthInsuranceObj,
        $transportAllowanceObj,
        $housingAllowanceObj,
        $jamsostekAllowanceObj,
        $positionalAllowanceObj
    ]
);

# Tax deduction components.
# (3) Setting-up instance of position cost, pension contribution, pension allowance => as tax deduction component.
# These below tax components act like as the tax enhancer component.
$positionCostObj = new \Bridge\Components\Hrd\Tax\Sections\TaxDeductionComponent('position-cost');
$pensionContribution = new \Bridge\Components\Hrd\Tax\Sections\TaxDeductionComponent('pension-contribution');

# Add one by one all each of tax deduction components.
$pph21Obj->addDeductionComponent($pensionContribution);
# You can add all the tax enhancer components at one time set.
$pph21Obj->addDeductionComponents([$positionCostObj, $pensionContribution]);

# Get gross income monthly.
$pph21Obj->getGrossIncomeAmount();
$pph21Obj->setGrossIncomeAmount($grossIncomeAmount); # Private method.
# Get nett income monthly.
$pph21Obj->getNettIncomeAmount();
$pph21Obj->setNettIncomeAmount($nettIncomeAmount); # Private method.


# Set tax allowance rules.
$pph21Obj->setTaxAllowanceRules($taxAllowanceRules);
$pph21Obj->setTaxAllowanceRule();

$taxCalculationComponent = new \Bridge\Components\Hrd\Tax\TaxComponent();

# Get amount of un-taxable and taxable income.
$pph21Obj->getUnTaxableIncome();
# Notes: all taxable income must be rounded down.
$pph21Obj->getTaxableIncome();
# Run the tax calculation.
$pph21Obj->doCalculate();
# Get total of pph21 amount yearly.
$pph21Obj->getPph21Yearly();
# Get pph21 amount monthly with number of month as parameter.
$pph21Obj->getPph21Monthly($month);
# Get pph21 amount on current month.
$pph21Obj->getPph21OnCurrentMonth();

