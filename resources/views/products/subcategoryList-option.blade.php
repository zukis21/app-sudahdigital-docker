<?php $dash= "-- "; ?>
@foreach($subcategories as $subcategory)
    @if(!count($subcategory->subcategory))
        <option alt="{{$category->name}}" value="{{$subcategory->id}}">
            {{$dash}}{{$subcategory->name}}
        </option>
    @elseif(count($subcategory->subcategory))
        <optgroup label="{{$dash}}{{$subcategory->name}}">
            @include('products.subcategoryList-option',['subcategories' => $subcategory->subcategory])
        </optgroup>
    @endif
@endforeach