<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PaymentItem;
use App\Practitioner;
use App\Rate;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function search()
    {
        $profession_id = request('profession_id');
        $register_category_id = request('register_category_id');
        $name = request('name');

        //$results = new Practitioner;
        $results = new Practitioner;


        if ($name != null) {
            $results = $results->orWhere('first_name', 'like', '%' . $name . '%')
                ->orWhere('last_name', 'like', '%' . $name . '%')
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", "%{$name}%")
                ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", "%{$name}%");
        }
        if ($profession_id != null) {
            $results = $results->where('profession_id', $profession_id);
        }
        if($register_category_id !=null){
            $results = $results->whereHas('practitioner_payment_information',function ($results) use ($register_category_id) {
                    $results->where('register_category_id',  $register_category_id );
                });
        }

        $results = $results->get();

        foreach ($results as $result){
            if($result->title){
                $result->title;
            }
            if($result->gender){
                $result->gender;
            }
            if($result->currentRenewal){
                $result->currentRenewal;
            }
            $result->profession;

            if($result->practitioner_payment_information){
                if($result->practitioner_payment_information->register_category){
                    $result->practitioner_payment_information->register_category;
                }
            }

            if($result->currentRenewal){
                $result->currentRenewal;
            }
        }

        return response()->json([
            'data' => $results
        ]);

    }
}
