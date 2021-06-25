<?php

namespace App\Exports;

use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CustomerExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Customer::where('status','=','ACTIVE')
        ->where('client_id','=',auth()->user()->client_id)
        ->orderBy('created_at','DESC')
        ->get();
    }

    public function map($customer) : array {
        return[
                $customer->store_code,
                $customer->store_name,
                $customer->email,
                $customer->city_id,
                $customer->address,
                $customer->cust_type,
                $customer->phone,
                $customer->phone_owner,
                $customer->phone_store,
                $customer->name,
                $customer->payment_term,
                $customer->user_id,
            ];
    }

    public function headings() : array {
        return [
           'Cust_Code',
           'Name',
           'Email',
           'City_ID',
           'Address',
           'Customer_Type',
           'Whatsapp',
           'Owner_Phone',
           'Office_Phone',
           'Contact',
           'Term_Of_Payment',
           'Sales_Rep'
        ] ;
    }

    public function columnFormats(): array
    {
        return [
            'F' =>'0',
            'G' =>'0',
            'H' =>'0',
        ];
        
    }
}
