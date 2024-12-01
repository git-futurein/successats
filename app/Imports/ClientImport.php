<?php

namespace App\Imports;

use App\Models\client;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClientImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
    public function model(array $row)
    {
        return new client([
            'client_code' => $row[0],
            'client_name' => $row[1],
        ]);
    }

}
