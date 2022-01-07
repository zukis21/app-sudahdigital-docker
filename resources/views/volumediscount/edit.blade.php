@extends('layouts.master')
@section('title') Detail Volume Discount @endsection
   
@section('content')
<style>
    input[type="checkbox"][readonly] {
        pointer-events: none;
    }
</style>    
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{session('error')}}
        </div>
    @endif
    <!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('vDiscount.update',[$vendor,$vDiscounts->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" id="code" name="name" 
                autocomplete="off" value="{{$vDiscounts->name}}" required>
                <label class="form-label">Name</label>
            </div>
        </div>

        <h2 class="card-inside-title">Type</h2>
            <div class="form-group">
                <input class="form-control" type="radio" 
                    {{$vDiscounts->type ==1 ? 'checked' : ''}} 
                    name="type" id="1" value="1" required
                    {{$vDiscounts->type == 1 && $countInverse > 0 ? '' : 'disabled'}}
                > 
                <label for="1">Combine</label>
                <input class="form-control" type="radio" 
                    {{$vDiscounts->type ==2 ? 'checked' : ''}}
                    name="type" id="2" value="2"
                    {{$vDiscounts->type == 2 && $countInverse > 0 ? '' : 'disabled'}}    
                 > 
                <label for="2">Item</label>
                <div class="invalid-feedback">
                    {{$errors->first('type')}}
                </div>
            </div>
        
        <div class="form-group form-float">
            <div class="form-line">
                <input type="number" onKeyUp="test_fn(this.value)" 
                    onchange="document.getElementById('maxOrder').min = Number(1) + Number(this.value)"
                    value="{{$vDiscounts->min_order}}"
                    class="form-control" id="min_order" name="min_order" 
                    min="{{$vDiscMax ? $vDiscMax->max_order + 1 : 1}}" autocomplete="off" 
                    maxlength="9"  required>
                <label class="form-label">Min. Order</label>
            </div>
        </div>

        <div class="form-group">
            <div class="form-line">
                <input type="checkbox" name="usemaxcheck" id="useMaxOrder"  
                {{$vDiscounts->max_order > 0 ? 'checked' : ''}}
                @if($vDiscMin) 
                    onClick="return readOnlyCheckBox()" 
                @endif>
                <label for="useMaxOrder">Use Max. Order</label>
            
                <input type="number" onKeyUp="test_fn_1(this.value)" 
                    class="form-control" id="maxOrder" name="max_order"
                    value="{{$vDiscounts->max_order > 0 ? $vDiscounts->max_order : ''}}"
                    autocomplete="off" maxlength="9" 
                    {{$vDiscMin ? 'max='.($vDiscMin->min_order-1).'' : ''}} 
                    required {{$vDiscounts->max_order > 0 ? '' : 'disabled'}}>
                  
            </div>
            <input type="hidden" name="hideMaxOrder" id="hideMaxOrder" value="{{$vDiscounts->max_order > 0 ? $vDiscounts->max_order : ''}}">
            <input type="hidden" value="{{$vDiscMin ? '1' : '0'}}" id="hidevdismin">
        </div>
        
            
        <button type="button" class="btn bg-green waves-effect m-b-20" data-toggle="modal" 
            data-target="#importModal" id="popoverData" data-trigger="hover" data-container="body" data-placement="bottom" 
            data-content="Import for add or change item discount">
            <i class="fas fa-file-excel"></i> Import
        </button>
        
        @if($vDiscounts->TotalItem > 1)
            <!--<button type="button" class="btn bg-red waves-effect m-b-20" data-toggle="modal" 
                data-target="#allDeleteModal" id="popoverData" data-trigger="hover" data-container="body" data-placement="right" 
                data-content="Delete for all item">
                <i class="fas fa-trash"></i> Delete All Item
            </button>-->
            <a href="{{route('vDiscItemExport',[$vendor,$vDiscounts->id]) }}" 
                class="btn bg-green waves-effect m-b-20" id="popoverData" 
                data-trigger="hover" data-container="body" data-placement="right" 
                data-content="Export Item">
                <i class="fas fa-file-excel fa-0x "></i> Export
            </a>
        @endif

        <div class="pull-right">
            <div class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" 
                    aria-haspopup="true" aria-expanded="true" id="popoverDataTemplate" data-trigger="hover" data-container="body" data-placement="left" 
                    data-content="Download Template">
                        <i class="material-icons">archive</i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                       <a href="{{route('productsInfo.export',[$vendor])}}" class=" waves-effect waves-block">
                            <i class="fas fa-file-excel fa-0x" style="color: #4CAF50"></i> Products
                        </a>
                    
                        <a href="{{asset('assets/template/VolumeDiscountImport.xlsx')}}" class=" waves-effect waves-block" download>
                            <i class="fas fa-file-excel fa-0x" style="color: #4CAF50"></i> Import Template
                        </a>
                    </li>
                </ul>
            </div>
            
        </div>
        
        
        <table class="table table-responsive table-striped table-list-item">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Discount Price (IDR)</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody id="TextBoxContainer" >
                @foreach($vDiscounts->item as $item)
                    <tr>
                        <td style="width: 50%">
                            {{$item->products->product_code ? $item->products->product_code.' -' : ''}}
                            {{$item->products->Product_name}}
                        </td>
                        <td >
                            {{number_format($item->discount_price)}}
                        </td> 
                        
                        <td>
                            <a 
                                data-toggle="modal" data-target="#deleteModal{{$item->id}}"
                                class="btn btn-xs btn-danger waves-effect">
                                <i class="material-icons">delete</i>
                            </a>
                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{$item->id}}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content modal-col-red">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="deleteModalLabel">Delete Product</h4>
                                        </div>
                                        <div class="modal-body">
                                        Delete this product ..? 
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{route('vDiscount.itemDelete',
                                                [$vendor,$item->id,$item->volume_id])}}" class="btn btn-link waves-effect">Delete</a>
                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                    </tr>
                @endforeach  
            </tbody>
            
        </table>

        <button class="btn btn-primary" name="save_action" id="save" value="UPDATE" type="submit" style="margin-top:20px;" >UPDATE</button>
        <a href="{{route('volume_discount.index',[$vendor])}}" class="btn bg-grey" style="margin-top:20px;margin-left:10px;">BACK</a>
        
    </form>

    <!-- Modal import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Item</h5>
                </div>
                <div class="modal-body">
                    <form id="form_validation" class="form_spv" method="POST" 
                        enctype="multipart/form-data" action="{{route('vDiscount.itemImport',[$vendor])}}">
                        @csrf
                        <input type="hidden" name="volume_id" value="{{$vDiscounts->id}}">
                        <h2 class="card-inside-title">File(.xls, .xlsx)</h2>
                        <div class="form-group">
                            <div class="form-line">
                            <input type="file" name="file" accept=".xls, .xlsx" 
                            class="form-control" id="file" autocomplete="off" required>
                            </div>
                            <label id="name-error" class="error" for="file">{{ $errors->first('file') }}</label>
                        </div>
            
                        <button  class="btn btn-primary waves-effect" value="ADD" type="submit">UPLOAD</button>
                        <button type="button" class="btn waves-effect bg-red m-l-5" data-dismiss="modal">Close</button>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>

    <!-- Modal Delete All-->
    <div class="modal fade" id="allDeleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content modal-col-red">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel">Delete All Item</h4>
                </div>
                <div class="modal-body">
                Delete all item ..? 
                </div>
                <div class="modal-footer">
                    <a href="{{route('vDiscount.allItemDelete',[$vendor,$vDiscounts->id])}}" 
                        class="btn btn-link waves-effect">Delete</a>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $('#popoverData,#popoverDataTemplate').popover();
        $(document).ready(function() {
            $('.table-list-item').DataTable( {
                
                
                "ordering": false,
                "info":     false
            } );
        } );
        function test_fn(test_value){
            var test_value = test_value.replace(/[^0-9]+/g, "");
            var checker = document.getElementById('useMaxOrder');
            var inputnum = document.getElementById('maxOrder');
            var hidevdiscmin = $('#hidevdismin').val();
            if((test_value != '' && test_value > 0) || (hidevdiscmin > 0) ){
                checker.disabled = false;
            }else{
                checker.disabled = true;
                checker.checked = false;
                inputnum.disabled = true;
                $('#maxOrder').val('');
                $('#hideMaxOrder').val('');
            }
        }

        function test_fn_1(test_value){
            var test_value = test_value.replace(/[^0-9]+/g, "");
            var inputnum = $('#min_order').val();
            
            if (inputnum > test_value) {
                document.getElementById('save').disabled = true;
            }else{
                document.getElementById('save').disabled = false;
            }
        }

        var checker = document.getElementById('useMaxOrder');
        var inputnum = document.getElementById('maxOrder');
        // when unchecked or checked, run the function
        checker.onchange = function(){
            if(this.checked){
                inputnum.disabled = false;
            } else {
                inputnum.disabled = true;
                $('#maxOrder').val('');
                $('#hideMaxOrder').val('');
            }

        }

        $('#maxOrder').on('keyup change', function() {
            $('#hideMaxOrder').val(this.value);
        });

        function readOnlyCheckBox() {
            return false;
        }

    </script>

@endsection