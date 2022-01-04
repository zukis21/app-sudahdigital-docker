<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    
    public function products(){
        return $this->belongsToMany('App\product')->withPivot('id','quantity','price_item',
                'price_item_promo','vol_disc_price','discount_item','group_id','paket_id','bonus_cat',
                'available','preorder','deliveryQty');
    }

    public function products_nonpaket(){
        return $this->belongsToMany('App\product')
        ->withPivot('id','quantity','price_item','price_item_promo','vol_disc_price',
                    'discount_item','group_id','paket_id','bonus_cat','available','preorder','deliveryQty')
        ->wherePivot('paket_id',null)
        ->wherePivot('group_id',null);
    }

    public function products_pkt(){
        return $this->belongsToMany('App\product')
        ->withPivot('id','quantity','price_item','price_item_promo','vol_disc_price',
        'discount_item','group_id','paket_id','bonus_cat','available','preorder','deliveryQty')
        ->wherePivot('paket_id','!=',null)
        ->wherePivot('group_id','!=',null)
        ->wherePivot('bonus_cat','=',null);
    }

    public function products_bns(){
        return $this->belongsToMany('App\product')
        ->withPivot('id','quantity','price_item','price_item_promo','vol_disc_price',
        'discount_item','group_id','paket_id','bonus_cat','available','preorder','deliveryQty')
        ->wherePivot('group_id','!=',null)
        ->wherePivot('bonus_cat','!=',null);
    }

    public function products_pktbns(){
        return $this->belongsToMany('App\product')
        ->withPivot('id','quantity','price_item','price_item_promo','vol_disc_price',
        'discount_item','group_id','paket_id','bonus_cat','available','preorder','deliveryQty')
        ->wherePivot('paket_id','!=',null)
        ->wherePivot('group_id','!=',null);
    }

    public function pakets(){
        return $this->belongsToMany('App\Paket','order_product','order_id','paket_id');
    }

    public function groups(){
        return $this->belongsToMany('App\Group','order_product','order_id','group_id');
    }

    public function vouchers(){
        return $this->belongsTo('App\Voucher','id_voucher');
    }

    public function customers(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function users(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function canceledBy(){
        return $this->belongsTo('App\User','canceled_by','id');
    }

    public function reasons(){
        return $this->belongsTo('App\ReasonsCheckout','reasons_id');
    }

    public function store_target(){
        return $this->hasMany('App\Store_Targets','customer_id','customer_id');
    }

    public function spv_sales(){
        return $this->belongsTo('App\Spv_sales','user_id','sls_id');
    }

    public function sales_targets(){
        return $this->belongsTo('App\Sales_Targets','user_id','user_id');
    }

    public function getTotalQuantityAttribute(){
        $total_quantity = 0;
        foreach($this->products as $p){
        $total_quantity += $p->pivot->quantity;
        }
        return $total_quantity;
    }

    public function getTotalDeliveryAttribute(){
        $total_delivery = 0;
        foreach($this->products as $p){
            $total_delivery += $p->pivot->deliveryQty;
        }
        return $total_delivery;
    }

    public function getTotalPreorderAttribute(){
        $total_preorder = 0;
        foreach($this->products as $p){
            $total_preorder += $p->pivot->preorder;
        }
        return $total_preorder;
    }

    public function getTotalNominalAttribute(){
        $total_nominal = 0;
        foreach($this->products as $p){
        $total_nominal += $p->pivot->price_item_promo;
        }
        return $total_nominal;
    }

    public function getTotalQtyDiscVolumeAttribute(){
        $total = 0;
        foreach($this->products_nonpaket as $p){
        $total += $p->pivot->quantity;
        }
        return $total;
    }

    public function getTotalQtyPaketAttribute(){
        $total = 0;
        foreach($this->products_pktbns as $p){
        $total += $p->pivot->quantity;
        }
        return $total;
    }
}
