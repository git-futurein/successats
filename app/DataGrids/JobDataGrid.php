<?php

namespace App\DataGrids;

use App\Models\job;
use WdevRs\LaravelDatagrid\DataGrid\DataGrid;

class JobDataGrid extends DataGrid
{

    /**
     * JobDataGrid constructor.
     */
    public function __construct()
    {
        $this->fromQuery(job::query())
            ->column('id', 'ID');
    }
}
