<?php

namespace App\DataGrids;

use App\Models\Employee;
use WdevRs\LaravelDatagrid\DataGrid\DataGrid;

class EmployeeDataGrid extends DataGrid
{
 
    /**
     * EmployeeDataGrid constructor.
     */
    public function __construct()
    {
        $this->fromQuery(Employee::query())
            ->column('id', 'ID')
            ->column('employee_name', 'employee_name');
        
    }
}
