<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomerParetoInfo implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::where('client_id','=',auth()->user()->client_id)
                        ->where('status','ACTIVE')
                        ->whereNotNull('pareto_id')
                        ->get();
    }

    public function map($customer) : array {
        return [
            $customer->store_code,
            $customer->store_name,
            $customer->pareto_id,
        ];
    }

    public function headings() : array {
        return [
                'Customer_Code',
                'Name',
                'ParetoId',
        ] ; 
    }
}
