<ul class="dropdown-menu" style="">
    @foreach($subcategories as $subcategory)
        <li><a class="dropdown-item" href="{{route('home_customer', [$vendor,'cat'=>$subcategory->slug])}}">{{$subcategory->name}}</a></li>
    @endforeach
</ul>