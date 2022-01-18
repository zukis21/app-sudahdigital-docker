<ul class="dropdown-menu" style="">
@foreach($subcategories as $subcategory)
    @if(!count($subcategory->subcategory))
    <li><a class="dropdown-item" href="{{route('home_customer', [$vendor,'cat'=>$subcategory->slug])}}">{{$subcategory->name}}</a></li>
    @elseif(count($subcategory->subcategory))
        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">{{$subcategory->name}}</a>
            
                @include('customer.subcategoryList-option',['subcategories' => $subcategory->subcategory])
            
        </li>
    @endif
@endforeach
</ul>