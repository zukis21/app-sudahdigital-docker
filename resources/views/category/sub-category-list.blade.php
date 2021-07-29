<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
<?php $_SESSION['i']=$_SESSION['i']+1; ?>
    <tr>
        <td>{{$_SESSION['i']}}</td>
        <td>{{$subcategory->id}}</td>
        <td>{{$dash}}{{$subcategory->name}}</td>
        <td>{{$subcategory->parent->name}}</td>
        <td>
            @if($subcategory->image_category)
            <img src="{{asset('storage/'.$subcategory->image_category)}}" width="50px" height="50px" />
            @else
            N/A
            @endif
        </td>
        <td>
            <a class="btn btn-info btn-xs" href="{{route('categories.edit',[$vendor,Crypt::encrypt($subcategory->id)])}}"><i class="material-icons">edit</i></a>&nbsp;
            <button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$subcategory->id}}"><i class="material-icons">delete</i></button>&nbsp;
            <!--
            <button type="button" class="btn bg-grey waves-effect" data-toggle="modal" data-target="#detailModal{{$c->id}}">Detail</button>
            -->
            <!-- Modal Delete -->
            <div class="modal fade" id="deleteModal{{$subcategory->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content modal-col-red">
                        <div class="modal-header">
                            <h4 class="modal-title" id="deleteModalLabel">Delete Category Permanent</h4>
                        </div>
                        <div class="modal-body">
                            Delete permanent this category ..? 
                        </div>
                        <div class="modal-footer">
                            <form action="{{route('categories.delete-permanent',[$vendor,$subcategory->id])}}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-link waves-effect">Delete</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Detail 
            <div class="modal fade" id="detailModal{{$subcategory->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-col-indigo">
                        <div class="modal-header">
                            <h4 class="modal-title" id="detailModalLabel">Detail Category</h4>
                        </div>
                        <div class="modal-body">
                        <b>Category Name:</b>
                        <br/>
                        {{$dash}}{{$subcategory->name}}
                        <br/>
                        <br/>
                        @if($subcategory->image_category)
                        <img src="{{asset('storage/'.$subcategory->image_category)}}" width="128px"/>
                        @else
                        No Image
                        @endif
                        
                        <br/>
                        <br/>
                        <b>Category Slug:</b>
                        <br/>
                        {{$subcategory->slug}}
                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                        </div>
                        
                    </div>
                </div>
            </div>
            -->
        </td>
    </tr>
    @if(count($subcategory->subcategory))
        @include('category.sub-category-list',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach