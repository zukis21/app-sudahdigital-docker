<?php

namespace App\Imports;

use App\Store_Targets;
use App\ProductTarget;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TargetCustomerImport implements ToModel, WithHeadingRow, WithBatchInserts, WithMultipleSheets
{
    //use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct(int $year, int $month)
    {
        //$this->type = $type;
        $this->year = $year;
        $this->month = $month;
    }

    public function model(array $rows)
    {
        //dd($rows);
        $productCode = $rows['product_code'];
        $customerCode = $rows['customer_code'];

        $cekProduct = \App\product::where('client_id','=',auth()->user()->client_id)
                    ->where('product_code',$productCode)->count();

        $cekCustomer = \App\Customer::where('client_id','=',auth()->user()->client_id)
                     ->where('store_code',$customerCode)->count();

        if($cekProduct > 0 && $cekCustomer > 0){
            $cp = \App\product::where('client_id','=',auth()->user()->client_id)
                    ->where('product_code',$productCode)->first();

            $cc = \App\Customer::where('client_id','=',auth()->user()->client_id)
                     ->where('store_code',$customerCode)->first();
            //$typeTarget = $this->type;
            $period = $this->year.'-'.$this->month.'-01';
            $store_target = Store_Targets::where('client_id','=',auth()->user()->client_id)
                            ->where('customer_id',$cc->id)
                            ->where('period',$period)
                            ->first();
            if($store_target){
                $store_target->target_type = 3;
                $store_target->updated_by= \Auth::user()->id;
                $store_target->version_pareto = $cc->pareto_id;
                $store_target->save();
                $cekTargetProduct = ProductTarget::where('storeTargetId',$store_target->id)
                                    ->where('productId',$cp->id)
                                    ->first();
                if($cekTargetProduct){
                    $cekTargetProduct->nominalValues = $cp->price_promo * $rows['quantity_target'];
                    $cekTargetProduct->quantityValues = $rows['quantity_target'];
                    $cekTargetProduct->save();
                    
                }else{
                    $targetProduct = new ProductTarget();
                    $targetProduct->store_targets()->associate($store_target);
                    $targetProduct->productId = $cp->id;
                    $targetProduct->nominalValues = $cp->price_promo * $rows['quantity_target'];
                    $targetProduct->quantityValues = $rows['quantity_target'];
                    $targetProduct->save();
                }
               
            }else{
                $store_target = new Store_Targets();
                $store_target->client_id = auth()->user()->client_id;
                $store_target->customer_id = $cc->id;
                $store_target->period = $period;
                $store_target->created_by= \Auth::user()->id;
                $store_target->version_pareto = $cc->pareto_id;
                $store_target->target_type = 3;
                $store_target->save();
                    if($store_target->save()){
                        $targetProduct = new ProductTarget();
                        $targetProduct->store_targets()->associate($store_target);
                        $targetProduct->productId = $cp->id;
                        $targetProduct->nominalValues = $cp->price_promo * $rows['quantity_target'];
                        $targetProduct->quantityValues = $rows['quantity_target'];
                        $targetProduct->save();
                    }
                }
            
        }
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function sheets(): array
    {
        return [
            0 => $this
        ];
    }

    /*
    public function chunkSize(): int
    {
        return 100;
    }*/
    
}