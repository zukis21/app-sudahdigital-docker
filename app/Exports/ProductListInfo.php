<?php

namespace App\Exports;

use App\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductListInfo implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return product::where('client_id','=',auth()->user()->client_id)
                        ->where('status','PUBLISH')
                        ->get();
    }

    public function map($product) : array {
        return [
            $product->product_code,
            $product->Product_name,
            $product->description,
            $product->price_promo,
        ];
    }

    public function headings() : array {
        return [
                'Product_Code',
                'Product_Name',
                'Description',
                'Price',
        ] ; 
    }
}
