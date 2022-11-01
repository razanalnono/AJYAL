<?php

namespace App\Imports;

use App\Models\Trainee;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TraineesImport implements ToModel , WithHeadingRow
{
    protected  $data;

   

    public function __construct($data){
        $this->data = $data;
    }

    public function model(array $row)
    {
        // $trinee = new Trainee([
        //     'firstName' => $row['firstname'],
        //     'lastName' => $row['lastname'],
        //     'nationalID' => $row['nationalid'],
        //     'gender' => $row['gender'],
        //     'mobile' => $row['mobile'],
        //     'email' => $row['email'],
        //     'carriagePrice' => $row['carriageprice'],
        //     'address' => $row['address'],
        // ]); 
        $trinee = new Trainee();
        $trinee->firstName = $row['firstname'];
        $trinee->lastName = $row['lastname'];
        $trinee->nationalID = $row['nationalid'];
        $trinee->gender = $row['gender'];
        $trinee->mobile = $row['mobile'];
        $trinee->email = $row['email'];
        $trinee->carriagePrice = $row['carriageprice'];
        $trinee->address = $row['address'];
        $trinee->save();
        DB::table('group_trainee')->insert([
            'trainee_id' => $trinee->id,
            'group_id' => $this->data->group_id,
        ]);
    }
}
