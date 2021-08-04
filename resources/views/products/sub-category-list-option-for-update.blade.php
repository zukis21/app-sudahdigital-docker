<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    @if(!count($subcategory->subcategory))
        <option alt="{{$category->name}}" value="{{$subcategory->id}}" @if(($cat_edit != '') && ($cat_edit->id == $subcategory->id)) selected @endif>
            {{$dash}}{{$subcategory->name}}
        </option>
    @elseif(count($subcategory->subcategory))
        <optgroup label="{{$dash}}{{$subcategory->name}}">
            @include('products.sub-category-list-option-for-update',['subcategories' => $subcategory->subcategory])
        </optgroup>
    @endif
@endforeach