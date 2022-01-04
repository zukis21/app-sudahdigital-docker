<?php

namespace App\Imports;

use App\VolumeDiscountProduct;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VolumeDiscountProductImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct(int $id)
    {
        //$this->type = $type;
        $this->id = $id;
    }

    public function model(array $rows)
    {
        $productCode = $rows['productcode'];

        $cekProduct = \App\product::where('client_id','=',auth()->user()->client_id)
                    ->where('product_code',$productCode)->count();
        if($cekProduct > 0){
            $cp = \App\product::where('client_id','=',auth()->user()->client_id)
                    ->where('product_code',$productCode)->first();
            $cekDiscountProduct = VolumeDiscountProduct::where('product_id',$cp->id)
                                    ->where('volume_id',$this->id)
                                    ->first();
            if($cekDiscountProduct){
                $cekDiscountProduct->discount_price = $rows['nettoprice'];
                $cekDiscountProduct->save();
            }else{
                $discountProduct = new VolumeDiscountProduct();
                $discountProduct->volume_id = $this->id;
                $discountProduct->product_id = $cp->id;
                $discountProduct->discount_price = $rows['nettoprice'];
                $discountProduct->save();
            }
        }
    }
}
