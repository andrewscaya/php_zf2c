<?php
include 'init_autoloader.php';

$id = '10';
// initialize Adapter and DB
$adapter = new Zend\Db\Adapter\Adapter(include 'database_params.php');
$sql = new Zend\Db\Sql\Sql($adapter);
// Create Select of Employee Tables
$select = $sql->select('employees');
$where = $select->where;
// Fileter out Terminated Employees, and only employer code 998
$where->NEST->equalTo('termDate', '0')->AND->equalTo('employer', '998')->UNNEST;
$where->equalTo('employees.ID', $id);

// Join in The Employee Status
$personJoinOn =  'employeeStatus.employer = employees.employer';
$personJoinOn .= ' AND ';
$personJoinOn .= 'employeeStatus.status = employees.status';
$select->join('employeeStatus', $personJoinOn, ['status'], $select::JOIN_LEFT);

//Join in the Employees Account Code
$payrollJoinOn = 'employeePayroll.employer = employees.employer';
$payrollJoinOn .= ' AND ';
$payrollJoinOn .= 'employeePayroll.ssn = employees.ssn';
$select->join('employeePayroll', $payrollJoinOn, ['account'], $select::JOIN_LEFT);

// Create Subselect for Only Regular Employees
$subSelect = $sql->select('employeeStatus');
$subSelect->columns(['status'])->where(['statusGroup' => 'REG']);
// Add Subselect to where
$where->in('status', $subSelect);

echo $sql->getSqlStringForSqlObject($select, $adapter->getPlatform());
echo PHP_EOL;