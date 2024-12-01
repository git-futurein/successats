<?php

namespace App\DataGrids;

use App\Models\jobcategory;
use WdevRs\LaravelDatagrid\DataGrid\DataGrid;

class JobCategoriesDataGrid extends DataGrid
{

    /**
     * JobCategoriesDataGrid constructor.
     */
    public function __construct()
    {
        $this->fromQuery(jobcategory::query())
            ->column('id', 'ID');
    }
}
