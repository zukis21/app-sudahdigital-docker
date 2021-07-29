@extends('layouts.master')
@section('title') Create Category @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('categories.store',[$vendor])}}">
    	@csrf
        <input type="hidden" value="{{Auth::user()->client_id}}" name="client_id">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" name="name" autocomplete="off" required>
                <label class="form-label">Category Name</label>
            </div>
        </div>

        <div class="form-group">
            <h2 class="card-inside-title">Select a parent category</h2>
            <select name="parent_id"  id="parent_id" 
                class="form-control" style="width:100%;">
                <option></option>
                @if($categories)
                    @foreach($categories as $category)
                        <?php $dash=''; ?>
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @if(count($category->subcategory))
                            @include('category.subCategoryList-option',['subcategories' => $category->subcategory])
                        @endif
                    @endforeach
                @endif
            </select>
            <div class="form-group form-float">
                <small class="err_exist"></small>
            </div>
        </div>
        <br>
        
        <h2 class="card-inside-title">Category Image</h2>
        <div class="form-group">
         <div class="form-line">
             <input type="file" name="image" class="form-control" id="image" autocomplete="off">
            </div>
        </div>
                        
        <button class="btn btn-primary waves-effect" type="submit">SAVE</button>
    </form>
    <!-- #END#  -->		

@endsection
@section('footer-scripts')
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script type="text/javascript">

        $('#parent_id').select2({
            placeholder: 'None',
        });

        
    </script> 
@endsection