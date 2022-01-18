<?php

namespace App\Exports;

use App\Order;
//use App\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class OrdersThisPeriod implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(int $year, int $month)
    {
        //$this->type = $type;
        $this->year = $year;
        $this->month = $month;
    }

    public function collection()
    {
        $day = date('d');
        if($day <= 5){
            if($this->month == 1){
                $prevYear = $this->year-1;
                $prevMonth = 12;
                $dateS = $prevYear.'-'.$prevMonth.'-01';
                $dateE = $this->year.'-'.$this->month.'-'.$day;
                return Order::where('client_id','=',auth()->user()->client_id)
                    ->whereNotNull('customer_id')
                    ->whereBetween('created_at',[$dateS,$dateE])
                    ->orderBy('created_at', 'DESC')->get();
            }else{
                $prevMonth = $this->month-1;
                $dateS = $this->year.'-'.$prevMonth.'-01';
                $dateE = $this->year.'-'.$this->month.'-'.$day;
                return Order::where('client_id','=',auth()->user()->client_id)
                    ->whereNotNull('customer_id')
                    ->whereBetween('created_at',[$dateS,$dateE])
                    ->orderBy('created_at', 'DESC')->get();
            }
        }else{
            return Order::where('client_id','=',auth()->user()->client_id)
                    ->whereNotNull('customer_id')
                    ->whereMonth('created_at',$this->month)
                    ->whereYear('created_at',$this->year)
                    ->orderBy('created_at', 'DESC')->get();
        }
    }

    public function map($order) : array {
        $rows = [];
        foreach ($order->products as $p) {
            /*if(($p->pivot->discount_item != NULL)&&($p->pivot->discount_item > 0)){
                $diskon =$p->pivot->discount_item;
                $total= $p->pivot->price_item_promo * $p->pivot->quantity;
            }else{
                $diskon = 0;
                $total= $p->pivot->price_item * $p->pivot->quantity;
            }*/

            if($p->pivot->vol_disc_price > 0){
                $price = $p->pivot->vol_disc_price;
            }else{
                $price = $p->pivot->price_item;
            }
            
            if($order->status == 'NO-ORDER'){
                $product_name = null;
            }else{
                $product_name = $p->Product_name;
            }
        
            if($order->canceled_by != null){
                $canceled_by = $order->canceledBy['name'];
            }else{
                $canceled_by = null;
            }

            if($order->reasons_id != null){
                $reasons = $order->reasons['reasons_name'];
            }else{
                $reasons = null;
            }
            
            array_push($rows,[
                //$order->id,
                $order->invoice_number,
                $order->status,
                $order->customers->store_code,
                $order->customers->store_name,
                $order->customers->name,
                $order->users()->first()['name'],
                $order->user_loc,
                $product_name,
                $p->pivot->quantity,
                $price,
                $order->payment_method,
                $p->pivot->paket_id,
                $p->pivot->group_id,
                $p->pivot->bonus_cat,
                $order->notes,
                $order->created_at,
                $order->process_time,
                $order->finish_time,
                $order->cancel_time,
                $reasons,
                $canceled_by,
                $order->notes_cancel,
                $order->notes_no_order,
                $order->notesPartialShip,
                //Carbon::parse($order->created_at)->toFormattedDateString()
            ]);
        }
        return $rows;
    }

    public function headings() : array {
        return [
           '#Order',
           'Status',
           'Cust. Code',
           'Name',
           'Contact Person',
           'Sales Rep',
           'On/Off Loc.',
           'Product',
           'Quantity',
           'Price',
           'Payment',
           'Paket Id',
           'Group Id',
           'Bonus Product',
           'Note',
           'Order Date',
           'Process Date',
           'Finish Date',
           'Cancel Date',
           'Reasons Check Out',
           'Canceled By',
           'Note Cancel Order',
           'Note No Order',
           'Note Partial Shipment',
        ] ;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '0',
            'F' =>'0',
        ];
        
    }
}
