<?php

namespace App\DataGrids;

use App\Models\Admin;
use WdevRs\LaravelDatagrid\DataGrid\DataGrid;

class AdminDataGrid extends DataGrid
{

    /**
     * AdminDataGrid constructor.
     */
    public function __construct()
    {
        $this->fromQuery(Admin::query())
            ->column('id', 'ID')
            ->column('name', 'Name');
    }
}
