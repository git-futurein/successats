<?php

namespace App\DataGrids;

use App\Models\Client;
use WdevRs\LaravelDatagrid\DataGrid\DataGrid;

class ClientDataGrid extends DataGrid
{

    /**
     * ClientDataGrid constructor.
     */
    public function __construct()
    {
        $this->fromQuery(Client::query())
            ->column('id', 'ID');
    }
}
