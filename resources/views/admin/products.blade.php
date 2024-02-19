@extends('..layouts.app')
@section('main')
<h2 class="text-center mt-2" style="color:darkblue" id="record_listing_heading">Items</h2>
<div class="mt-4"  style="width:95%;text-align: end;">
    @if(Auth::user()->hasPermissionTo(8))
        <div style="width:95%;align-items:end;">    
        <a class="btn btn-primary" href="{{route('add.items')}}">+ Add Items</a>
        </div>
    @endif
    <div style="width:95%;align-items:end;margin-top:4px;">    
        <input type="text" name="search" id="search_item" placeholder="search item" style="border: 1px solid #ccc;
        border-radius: 4px;padding: 12px 20px;">
    </div>
</div>
@if(isset($products))
<select name="" id="specific_product" class="dropdown">
<option value="">Choose Category</option>
@foreach($products as $product)
    <option value="{{$product->id}}">{{ucfirst($product->name)}}</option>
@endforeach 
</select>
@endif  
<select name="" id="brands" class="dropdown" style="display:none;">
</select>
@if(Session::has('success'))
<h4 class="text-success text-center">{{Session::get('success')}}</h4>
@endif
@if(Session::has('error'))
<h4 class="text-danger">{{Session::get('error')}}</h4>
@endif
<div class="text-center">
    <table  class="table" id="record_listing_container" style="display:none;width:90%;">
    <thead>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Action</th>
    </thead>
    <tbody id="record_listing_body">
    </tbody>
    </table>
</div>
    <div class="text-center">
    <span id="pagination">
    </span>
    </div>
@endsection
@section('pagescript')
<script src="{{asset('js/products.js')}}"></script>
@endsection