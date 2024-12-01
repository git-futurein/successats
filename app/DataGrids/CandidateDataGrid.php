<?php

namespace App\DataGrids;

use App\Models\Candidate;
use WdevRs\LaravelDatagrid\DataGrid\DataGrid;

class CandidateDataGrid extends DataGrid
{

    /**
     * CandidateDataGrid constructor.
     */
    public function __construct()
    {
        $this->fromQuery(Candidate::query())
            ->column('id', 'ID');
    }
}
