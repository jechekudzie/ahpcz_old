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
            'idd' => $row['idd'],
            'case_number'  =>  $row['case_number'],
            'date' => date("Y-m-d h:i:s", strtotime($row['date'])),
            'block' => $row['block'],
            'iucr' => $row['iucr'],
            'primary_type' => $row['primary_type'],
            'description' => $row['description'],
            'location_description' => $row['location_description'],
            'arrest' => $row['arrest'],
            'domestic' => $row['domestic'],
            'beat' => $row['beat'],
            'district' => $row['district'],
            'ward' => $row['ward'],
            'community_area' => $row['community_area'],
            'fbi_code' => $row['fbi_code'],
            'x_coordinate' => $row['x_coordinate'],
            'y_coordinate' => $row['y_coordinate'],
            'year' => $row['year'],
            'updated_on' => date("Y-m-d h:i:s", strtotime($row['updated_on'])),
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'location' => $row['location'],
        ]);
    }
}
