@extends('layouts.master')
@section('title') Details Order #{{$order->invoice_number}}@endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" action="{{route('orders.update', [$vendor,$order->id])}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" id="paramOrderId" value="{{$order->id}}">
        <div class="form-group form-float">
            <label class="form-label">Customer</label>
                <ul>
                    <small><b>Name :</b> {{$order->customers->store_name}}</small>
					@if($order->customers->status == 'NEW')<span class="badge bg-pink">New</span>@endif
					<br>
                    <small><b>Contact Person :</b> {{$order->customers->name}}</small><br>
					<small><b>Email :</b> {{$order->customers->email}}</small><br>
					<small><b>Addr :</b> {{$order->customers->address}}</small><br>
					<small><b>Phone :</b> {{$order->customers->phone}}</small><br>
                    <small><b>Office Phone :</b> {{$order->customers->phone_store}}</small><br>
                    <small><b>Owner Phone :</b> {{$order->customers->phone_owner}}</small><br>
					<small><b>Sales Rep :</b> {{$order->users->name}} <span class="badge {{$order->user_loc == 'On Location' ? 'bg-green' : 'bg-black'}}">{{$order->user_loc}}</span></small><br>
                    <small><b>Payment Term :</b> 
						{{$order->payment_method}}
					</small><br>
                    <small><b>Notes :</b> {{$order->notes}}</small><br>
                </ul>
                    <!--<input type="text" class="form-control" autocomplete="off" value="" disabled>-->
        </div>

        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control"  autocomplete="off"  value="{{$order->created_at}}" disabled>
                <label class="form-label">Order date</label>
            </div>
        </div>
        
        <label class="form-label">Product Orders</label>
        @if($order->status == 'NO-ORDER')
        <br>
          --No Product--
        @endif
        @if((count($order->products_nonpaket) > 0) && $order->status !== 'NO-ORDER' )
            <div class="form-group">
                <table width="100%" class="table">
                    <thead>
                        <th width="50%" style="padding-left:10px;"><small>* Regular Product</small></th>
                        <th width="" style="padding-left:10px;"><small>Quantity </small> </th>
                        <th width="" style="padding-left:10px;"><small>Price</small> </th>
                        <!--<th width="" style="padding-left:10px;"><small>Discount(%)</small> </th>
                        <th width="" style="padding-left:10px;"><small>Price After Discount</small></th>-->
                        <th width="" class="text-right"><small>Sub Total</small></th>
                    </thead>
                    <tbody>
                        @foreach($order->products_nonpaket as $p)
                            <tr>
                                <td style="padding-top:10px;">
                                    {{$p->Product_name}}
                                    
                                    @if( $p->pivot->deliveryQty !== null)
                                        <br>
                                        <span class="badge bg-orange">Outstanding : {{$p->pivot->quantity - $p->pivot->deliveryQty}}</span>
                                        <span class="badge bg-green">Delivered : {{$p->pivot->deliveryQty}}</span>
                                    @else
                                        @if($p->pivot->preorder > 0)
                                        <br>
                                            <!--<span class="badge bg-cyan">Available : {{$p->pivot->available}}</span>-->
                                            <span class="badge bg-orange">Pre Order : {{$p->pivot->preorder}}</span>
                                        @endif
                                    @endif
                                </td>
                                <td style="padding-top:5px;">{{$p->pivot->quantity}}</td>
                                <td style="padding-top:5px;">Rp. {{number_format($p->pivot->price_item, 0, ',', '.')}}</td>
                                <!--<td style="padding-top:5px;">{{$p->pivot->discount_item}}</td>
                                <td style="padding-top:5px;">
                                    @if(($p->pivot->price_item_promo != NULL) && ($p->pivot->price_item_promo > 0))
                                    {{number_format($p->pivot->price_item_promo, 0, ',', '.')}}
                                    @else
                                    ---
                                    @endif
                                </td>-->
                                <td align="right">
                                    @if(($p->pivot->discount_item != NULL) && ($p->pivot->discount_item > 0))
                                    Rp. {{number_format($p->pivot->price_item_promo * $p->pivot->quantity, 0, ',', '.')}}
                                    @else
                                    Rp. {{number_format($p->pivot->price_item * $p->pivot->quantity, 0, ',', '.')}}
                                    @endif
                                </td>
                            </tr>
                            <tr class="dlv_qty"  style="{{$order->status == 'PARTIAL-SHIPMENT' ? 'display: table-row' : 'display:none'}}">
                                
                                <td colspan="4">
                                    <input type="hidden" name="order_productId[]" value="{{$p->pivot->id}}">
                                    <input type="hidden" name="productId[]" value="{{$p->pivot->product_id}}" id="PrId{{$p->pivot->id}}">
                                    <input type="hidden" class="valEmpty" id="valEmpty{{$p->pivot->id}}">
                                    <div class="form-group form-float">
                                        <div class="form-line" id="div{{$p->pivot->id}}">
                                            <input type="number" min="0" name="deliveryQty[{{$p->pivot->id}}]" 
                                            value="" class="form-control deliveryQty" onkeyup="input_qty('{{$p->pivot->id}}')"
                                            autocomplete="off" id="dlv{{$p->pivot->id}}" required/>
                                            <label for="dlv{{$p->pivot->id}}" class="form-label">Delivery Quantity</label>
                                        </div>
                                        <label id="dlv{{$p->pivot->id}}-error" class="error" for="dlv{{$p->pivot->id}}"></label>
                                        <small class="err_exist{{$p->pivot->id}}"></small>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <!--
                        <tr>
                            <//!--<td colspan="5" align="right"><b>Voucher Discount</b> <small>
                                @if($order->id_voucher !=NULL)
                                {{($order->vouchers['description'])}}
                                @endif
                            </small> <b>:</b></td>
                            <td align="right">
                                @if(($order->id_voucher !=NULL)&&($order->vouchers['type'] == 1))
                                <b>{{$order->vouchers->discount_amount}}%</b>
                                @elseif(($order->id_voucher !=NULL)&&($order->vouchers['type'] == 2))
                                <b>{{number_format($order->vouchers->discount_amount, 0, ',', '.')}}</b>
                                @else
                                <b>0</b>
                                @endif
                            </td>
                        </tr>
                        -->
                        <tr>
                            @php
                                $pirce_r = \App\order_product::where('order_id',$order->id)
                                ->whereNull('group_id')
                                ->whereNull('paket_id')
                                ->whereNull('bonus_cat')
                                ->sum(\DB::raw('price_item * quantity'));
                            @endphp
                            <td colspan="3" align="right" width="85%"><b>Total Price :</b></td>
                            <td align="right"><b>Rp. {{number_format($pirce_r, 0, ',', '.')}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
        
        @if(count( $paket_list) > 0)
            @foreach($paket_list as $paket)
                <div class="form-group">
                    
                    @php
                        $paket_name =\App\Paket::where('id',$paket->paket_id)
                                    ->first();
                        $group_name =\App\Group::where('id',$paket->group_id)
                                    ->first();           
                    @endphp
                    <table width="100%" class="table">
                        <thead>
                            <th width="50%" style="padding-left:10px;"><small>* Product {{$paket_name->display_name}} - {{$group_name->display_name}}</small></th>
                            <th width="" style="padding-left:10px;"><small>Quantity </small> </th>
                            <th width="" style="padding-left:10px;"><small>Price</small> </th>
                            <th width="" class="text-right"><small>Sub Total</small></th>
                        </thead>
                        <tbody>
                            @php
                                $cek_paket=\DB::table('order_product AS op')
                                            ->select('op.*','pr.Product_name')
                                            ->join('products AS pr','pr.id','=','op.product_id')
                                            ->where('op.order_id',$order->id)
                                            ->where('op.paket_id',$paket->paket_id)
                                            ->where('op.group_id',$paket->group_id)
                                            ->orderBy('op.bonus_cat','ASC')
                                            ->get();
                                //dd($cek_paket);
                            @endphp
                            @foreach($cek_paket as $p)
                            <tr>
                                <td style="padding-top:10px;">
                                    @if($p->bonus_cat == NULL)
                                        {{$p->Product_name}}
                                    @else
                                        {{$p->Product_name}} (<small><b>PRODUCT BONUS</b></small>)
                                    @endif
                                    @if( $p->deliveryQty !== null)
                                        <br>
                                        <span class="badge bg-orange">Outstanding : {{$p->quantity - $p->deliveryQty}}</span>
                                        <span class="badge bg-green">Delivered : {{$p->deliveryQty}}</span>
                                    @else
                                        @if($p->preorder > 0)
                                        <br>
                                            <!--<span class="badge bg-cyan">Available : {{$p->available}}</span>-->
                                            <span class="badge bg-orange">Pre Order : {{$p->preorder}}</span>
                                        @endif
                                    @endif
                                    
                                </td>
                                <td style="padding-top:5px;">{{$p->quantity}}</td>
                                <td style="padding-top:5px;">
                                    @if($p->bonus_cat == NULL)
                                    Rp. {{number_format($p->price_item, 0, ',', '.')}}
                                    @endif
                                </td>
                                <td align="right">
                                    @if($p->bonus_cat == NULL)
                                        @if(($p->discount_item != NULL) && ($p->discount_item > 0))
                                            Rp. {{number_format($p->price_item_promo * $p->quantity, 0, ',', '.')}}
                                        @else
                                            Rp. {{number_format($p->price_item * $p->quantity, 0, ',', '.')}}
                                        @endif
                                    @endif
                                </td>
                            </tr>
                            <tr class="dlv_qty"  style="{{$order->status == 'PARTIAL-SHIPMENT' ? 'display: table-row' : 'display:none'}}">
                                
                                <td colspan="4">
                                    <input type="hidden" name="order_productId[]" value="{{$p->id}}">
                                    <input type="hidden" name="productId[]" value="{{$p->product_id}}">
                                    <input type="hidden" class="valEmpty" id="valEmpty{{$p->id}}">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="number" min="0" name="deliveryQty[{{$p->id}}]" 
                                            class="form-control deliveryQty" 
                                            autocomplete="off" id="dlv{{$p->id}}" required/>
                                            <label for="dlv{{$p->id}}" class="form-label">Delivery Quantity</label>
                                        </div>
                                        <label id="dlv{{$p->id}}-error" class="error" for="dlv{{$p->id}}"></label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            <tr>
                                <td colspan="3" align="right" width="85%"><b>Total Price :</b></td>
                                @php
                                    $pkt_pirce = \App\order_product::where('order_id',$order->id)
                                    ->where('group_id',$paket->group_id)
                                    ->where('paket_id',$paket->paket_id)
                                    ->whereNull('bonus_cat')
                                    ->sum(\DB::raw('price_item * quantity'));
                                @endphp
                                <td align="right"><b>Rp. {{number_format($pkt_pirce, 0, ',', '.')}}</b></td>
                            </tr>
                            
                        .</tbody>
                    </table>

                </div>
            @endforeach
        @endif
        <div style="margin-top:-20px;">
            <table width="100%" class="table">
                <thead>
                    <th width="85%" class="text-right">Grand Total :</th>
                    <th width="" class="text-right">Rp. {{number_format($order->total_price, 0, ',', '.')}}</th>
                </thead>
            </table>
        </div>
       
        <label class="form-label">Status</label>
        <input type="hidden" id="prevStatus" name="prevStatus" value="{{$order->status}}">
        <div class="form-group">
            <input type="radio" value="SUBMIT" name="status" id="SUBMIT" {{$order->status == 'SUBMIT' ? 'checked' : ''}} 
            {{$order->status == 'CANCEL' || 
              $order->status == 'NO-ORDER' ||
              $order->status == 'PROCESS' ||
              $order->status == 'FINISH' ||
              $order->status == 'PARTIAL-SHIPMENT' ? 'disabled' : ''}}>
            <label for="SUBMIT">SUBMIT</label>
            &nbsp;
            <input type="radio" value="PROCESS" name="status" id="PROCESS" {{$order->status == 'PROCESS' ? 'checked' : ''}}
            {{$order->status == 'CANCEL' || 
              $order->status == 'NO-ORDER' ||
              $order->status == 'FINISH' || 
              $order->status == 'PARTIAL-SHIPMENT' ? 'disabled' : ''}}>
            <label for="PROCESS">PROCESS</label>
            &nbsp;
            <input type="radio" value="PARTIAL-SHIPMENT" name="status" id="PARTIAL-SHIPMENT" {{$order->status == 'PARTIAL-SHIPMENT' ? 'checked' : ''}}
            {{$order->status == 'CANCEL' || 
              $order->status == 'NO-ORDER' ||
              $order->status == 'FINISH' ? 'disabled' : ''}}>
            <label for="PARTIAL-SHIPMENT">PARTIAL-SHIPMENT</label>
            &nbsp;
            <input type="radio" value="FINISH" name="status" id="FINISH" {{$order->status == 'FINISH' ? 'checked' : ''}}
            {{$order->status == 'CANCEL' || 
              $order->status == 'NO-ORDER' ? 'disabled' : ''}}>
            <label for="FINISH">FINISH</label>
            &nbsp;
            <input type="radio" value="CANCEL" name="status" id="CANCEL" {{$order->status == 'CANCEL' ? 'checked' : ''}}
            {{$order->status == 'NO-ORDER' || $order->status == 'FINISH' ? 'disabled' : ''}}>
            <label for="CANCEL">CANCEL</label>
            &nbsp;
            <input type="radio" value="NO-ORDER" name="status" id="NO-ORDER" {{$order->status == 'NO-ORDER' ? 'checked' : ''}}
            {{$order->status == 'CANCEL' || 
              $order->status == 'FINISH' ||
              $order->status == 'PROCESS' ||
              $order->status == 'SUBMIT' ||
              $order->status == 'PARTIAL-SHIPMENT' ? 'disabled' : ''}}>
            <label for="NO-ORDER">NO-ORDER</label>

        </div>

        <div class="form-group" id="partialDeliveryNotes" style="{{$order->status == 'PARTIAL-SHIPMENT' ? 'display: block' : 'display:none'}}">
            <div class="form-line">
                <textarea name="partialDeliveryNotes" rows="4" class="form-control no-resize"  
                placeholder="Notes for partial shipment" id="partialDeliveryNotes"
                autocomplete="off" required>{{$order->NotesPartialShip ? $order->NotesPartialShip : ''}}</textarea>
            </div>
            <label id="partialDeliveryNotes-error" class="error" for="partialDeliveryNotes"></label>
        </div>

        <div class="form-group"  style="{{$order->status == 'CANCEL' ? 'display: block' : 'display:none'}}" id="notes_cancel">
            <div class="form-line">
                @if($order->canceled_by != null)
                <textarea name="notes_cancel" rows="4" class="form-control no-resize"  
                    placeholder="Give a reason to cancel the order"  {{(Auth::user()->id == $order->canceled_by) ? '' : 'readonly'}}
                    autocomplete="off" required>{{$order->notes_cancel ? $order->notes_cancel : ''}}</textarea>
                @else
                    <textarea name="notes_cancel" rows="4" class="form-control no-resize"  
                        placeholder="Give a reason to cancel the order" id="notes_cancel"
                        autocomplete="off" required>{{$order->notes_cancel ? $order->notes_cancel : ''}}</textarea>
                @endif
            </div>
            <label id="notes_cancel-error" class="error" for="notes_cancel"></label>
        </div>

        <div class="form-group"  style="{{$order->status == 'NO-ORDER' ? 'display: block' : 'display:none'}}">
            <div class="form-line">
                <input type="text" class="form-control"  autocomplete="off"  value="{{$order->reasons_id ? $order->reasons->reasons_name : ''}}" disabled>
                <label class="form-label">Reasons</label>
            </div>
        </div>

        <div class="form-group"  style="{{$order->status == 'NO-ORDER' ? 'display: block' : 'display:none'}}">
            <div class="form-line">
                <input type="text" class="form-control"  autocomplete="off"  value="{{$order->notes_no_order ? $order->notes_no_order : ''}}" disabled>
                <label class="form-label">Notes</label>
            </div>
        </div>
        <br>
        @if($order->status == 'CANCEL')
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control"  autocomplete="off"  value="{{$order_cancel ? $order_cancel->name : ''}}" disabled>
                <label class="form-label">Canceled By</label>
            </div>
        </div>
        @endif
        @if($order->status == 'NO-ORDER')
            <input type="submit" id="update_status" class="btn btn-primary waves-effect" value="UPDATE" disabled>
        @else
            <input type="submit" id="update_status" class="btn btn-primary waves-effect" value="UPDATE" {{\Auth::user()->roles == 'SUPERVISOR' ? 'disabled' : ''}}>
        @endif
    </form>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('input[type=number]').on('mousewheel', function(e) {
            $(e.target).blur();
        });

        $("#form_validation").validate({
            messages: {
                "deliveryQty": "",
            }
        });

        $(function () {
            $("input[name='status']").click(function () {
                if ($("#CANCEL").is(":checked")) {
                    $("#notes_cancel").show();
                    $(".dlv_qty").hide();
                    $("#partialDeliveryNotes").hide();
                }
                else if ($("#PARTIAL-SHIPMENT").is(":checked")) {
                    $("#notes_cancel").hide();
                    $(".dlv_qty").show();
                    $("#partialDeliveryNotes").show();
                } 
                else {
                    $("#notes_cancel").hide();
                    $(".dlv_qty").hide();
                    $("#partialDeliveryNotes").hide();
                }
            });
        });

        function input_qty(id){
            var jumlah = $('#dlv'+id).val();
            var product_id = $('#PrId'+id).val();

            $.ajax({
                url: '{{URL::to('/ajax/cekQty/order')}}',
                type: 'get',
                data: {
                    'product_id' : product_id,
                    'jumlah': jumlah,
                },
                success: function(response){
                    if (response == 'taken' && jumlah !="" ) {
                    $('.err_exist'+id).addClass("small").addClass('merah').text('Not enough stock..');
                    $('#valEmpty'+id).val(1);
                    //$('#update_status').prop('disabled', true);
                    }else if (response == 'not_taken') {
                    $('.err_exist'+id).addClass("text-primary").removeClass('merah').text('');
                    $('#valEmpty'+id).val('');
                    //$('#update_status').prop('disabled', false);
                    }

                    var vEmptyTextBox = $(".valEmpty").filter(function(){
                    return $.trim($(this).val()) !== '';
                    }).length;
                    if(vEmptyTextBox > 0){
                        $('#update_status').prop('disabled', true);
                    }else{
                        $('#update_status').prop('disabled', false);
                    }
                }
                
            });

            
        }

        $(document).ready(function(){
            var prevStatus = $('#prevStatus').val();
            var orderId = $('#paramOrderId').val();
            $('input[type=radio][name=status]').change(function() {
                if ((this.value == 'FINISH') && (prevStatus == 'PARTIAL-SHIPMENT')) {
                    $.ajax({
                        url: '{{URL::to('/ajax/cekForFinish/order')}}',
                        type: 'get',
                        data: {
                            'order_id' : orderId,
                        },
                        success: function(response){
                            console.log(response);
                            if (response == 'taken') {
                                $('#update_status').prop('disabled', true);
                            }else if (response == 'not_taken') {
                                $('#update_status').prop('disabled', false);
                            }

                        }
                        
                    });
                }
            });

        });

    </script>
@endsection

