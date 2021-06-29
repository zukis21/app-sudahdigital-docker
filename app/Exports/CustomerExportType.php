<?php

namespace App\Exports;

use App\TypeCustomer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CustomerExportType implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return TypeCustomer::all();
        return TypeCustomer::where('status','=','ACTIVE')
        ->where('client_id','=',auth()->user()->client_id)
        ->orderBy('created_at','DESC')
        ->get();
    }

    public function map($typecustomer) : array {
        return[
                $typecustomer->id,
                $typecustomer->name,
            ];
    }

    public function headings() : array {
        return [
           'Id',
           'Name',
        ] ;
    }
}
