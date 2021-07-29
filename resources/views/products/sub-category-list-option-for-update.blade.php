<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    <option value="{{$subcategory->id}}" @if(($cat_edit != '') && ($cat_edit->id == $subcategory->id)) selected @endif>
        {{$dash}}{{$subcategory->name}}
    </option>
    @if(count($subcategory->subcategory))
        @include('products.sub-category-list-option-for-update',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach