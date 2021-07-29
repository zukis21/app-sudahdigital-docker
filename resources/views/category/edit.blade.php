@extends('layouts.master')
@section('title') Edit Category @endsection
@section('content')

	@if(session('status'))
		<div class="alert alert-success">
			{{session('status')}}
		</div>
	@endif
	<!-- Form Create -->
    <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('categories.update',[$vendor,$cat_edit->id])}}">
    	@csrf
        <input type="hidden" name="_method" value="get">
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$cat_edit->name}}" name="name" autocomplete="off" required>
                <label class="form-label">Category Name</label>
            </div>
        </div>

        <div class="form-group">
            <h2 class="card-inside-title">Select a parent category</h2>
            <select name="parent_id"  id="parent_id" 
                class="form-control" style="width:100%;">
                <option></option>
                @if($categories)
                    @foreach($categories as $item)
                        <?php $dash=''; ?>
                        <option value="{{$item->id}}" @if($cat_edit->parent_id == $item->id ) selected @endif>{{$item->name}}</option>
                        @if(count($item->subcategory))
                            @include('category.sub-category-list-option-for-update',['subcategories' => $item->subcategory])
                        @endif
                    @endforeach
                @endif
            </select>
            <div class="form-group form-float">
                <small class="err_exist"></small>
            </div>
        </div>
        <br>

        <!--
        <div class="form-group form-float">
            <div class="form-line">
                <input type="text" class="form-control" value="{{$cat_edit->slug}}" name="slug" autocomplete="off" required>
                <label class="form-label">Slug</label>
            </div>
        </div>
        -->
        <h2 class="card-inside-title">Category Image</h2>
        <div class="form-group">
         <div class="form-line">
            @if($cat_edit->image_category)
            <img src="{{asset('storage/'.$cat_edit->image_category)}}" width="120px"/>
            @else
            No Image
            @endif
            <input type="file" name="image" class="form-control" id="avatar" autocomplete="off">
            <small
                class="text-muted">Leave it blank if you don't want to change your avatar
            </small>
            </div>
            <label id="name-error" class="error" for="image">{{ $errors->first('image') }}</label>
        </div>

        <button class="btn btn-primary waves-effect" type="submit">EDIT</button>&nbsp;
        <a href="{{route('categories.index',[$vendor])}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
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