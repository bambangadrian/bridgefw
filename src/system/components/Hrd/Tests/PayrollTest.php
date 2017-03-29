<?php
/**
 * Contains code written by the Invosa Systems Company and is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   -
 * @author    Bambang Adrian Sitompul <bambang@invosa.com>
 * @copyright 2016 Invosa Systems Indonesia
 * @license   http://www.invosa.com/license No License
 * @version   GIT: $Id$
 * @link      http://www.invosa.com
 */

# Glossary:

# Enhancement/extra salary components:
#-------------------------------------
# JKK = Premi Jaminan Kecelakaan Kerja
# JKM = Premi Jaminan Kematian
# BPJS (Badan Penyelenggara Jaminan Sosial Ketenagakerjaan) Kesehatan By Company
# Overtime = Biaya kerja di luar waktu (lembur)
# Basic/base Salary = Gaji pokok bulanan
# Tunjangan Jabatan
# Tunjangan Transport (Akomodasi)
# Tunjangan Jamsostek
# Tunjangan Tax (Tax Allowance)
# Tunjangan Lain-lain

# Reduction salary components:
#-------------------------------------
# Potongan Unpaid Leave
# Potongan Telat
# Potongan Pinjaman (Loan) : Biasanya dalam bentuk cicilan bulanan


# ============ TAX CALCULATION MOCK-UP DATA =============

# Create new salary component.
$salaryComponent = new Bridge\Components\Hrd\Payroll\SalaryComponent('BasicSalary');
$salaryComponent->setType();

$allowanceObj = new \Bridge\Components\Hrd\Payroll\Allowance();
$deductionObj = new \Bridge\Components\Hrd\Payroll\Deduction();


$allowanceCollection = new \Bridge\Components\Hrd\Payroll\Allowances();
$deductionCollection = new \Bridge\Components\Hrd\Payroll\Deductions();

# Create salary object.
$salary = new \Bridge\Components\Hrd\Payroll\Salary();
# Adding salary components.
$salary->addComponent($salaryComponent);
# Show all salary components.
$salary->getComponents();
# Get one of salary components and all the information.
$salary->getComponent($salaryComponent);
$salary->setBasicSalary(2500000);
