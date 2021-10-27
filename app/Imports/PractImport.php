<?php

namespace App\Imports;

use App\Pract;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PractImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pract([
            'first_name' => $row['first_name'],
            'last_name'  =>  $row['last_name'],
            'reg_number' => $row['reg_number'],
            'profession' => $row['profession'],
            'register' => $row['register'],
            'prefix' => $row['prefix'],
            'number' => $row['number'],
        ]);
    }
}
