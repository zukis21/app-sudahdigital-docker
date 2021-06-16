<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class SalesExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return User::all();
        $client=\App\B2b_client::findOrfail(auth()->user()->client_id);
        return User::where('roles','=','SALES')
        ->where('client_id',auth()->user()->client_id)
        ->get();
    }

    public function map($user) : array {
        return[
                $user->id,
                $user->name,
                $user->email,
                $user->phone,
                $user->sales_area,
            ];
    }

    public function headings() : array {
        return [
           'Id',
           'Name',
           'Email',
           'Phone',
           'Sales Area',
        ] ;
    }

    public function columnFormats(): array
    {
        return [
            'D' =>'0',
       ];
        
    }
}
