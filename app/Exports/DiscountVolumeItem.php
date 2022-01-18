<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DiscountVolumeItem implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        $vItem = \App\VolumeDiscountProduct::where('volume_id', $this->id)
                ->get();
        return collect($vItem);
       
    }

    public function map($vItem) : array {
       
        $item = \App\product::findOrfail($vItem->product_id);
        
        return[
            $item->product_code,
            $vItem->discount_price,
        ];
    }

    public function headings() : array {
        return [
           'ProductCode',
           'NettoPrice',
        ] ;
    }
}
