@extends('..layouts.app')
@section('main')
@if(Session::has('success'))
<h3 class="text-center text-success">{{Session::get('success')}}</h3>
@endif
<span style="" ><a class="btn btn-primary" href="{{route('products.all')}}"><- back</a></span>
<h2 class="text-center text-primary" id="main_heading"></h2>
<form action="@if(isset($all_categories)) {{route('update.item')}}@else {{route('add.items')}}  @endif" method="POST" id="create_item">
   @csrf
   <div class="container" style="border-style:outset;padding:3%;width: 68%;" id="add_item">
      <div class="row mt-3">
         <label for="" class="col-md-3">Name</label>
         <div class="col-md-8">
            <input type="hidden" name="id" value="{{$item->id??''}}">
            <input type="text" name="item_name" placeholder="Name" class="form-control" value="{{$item->name??''}}">
            <span style="color:red;" class="errors" id="item_nameErr"></span>
         </div>
      </div>
      <div class="row mt-3">
         <label for="" class="col-md-3">Price</label>
         <div class="col-md-8">
            <input type="number" name="price" placeholder="Price" class="form-control" value="{{$item->price??''}}">
            <span style="color:red;" class="errors" id="priceErr"></span>
         </div>
      </div>
      <div class="row mt-3" id="category_container" style="display:none;">
         <label for="" class="col-md-3">Category</label>
         <div class="col-md-8">
            @if(isset($all_categories))
            <select name="product_id" id="select_product" class="dropdown" onchange="changeProduct(this.value)">
               <option value=''>Choose Category</option>
               @foreach($all_categories as $categeries)
               @if($category->id == $categeries->id)
               <option value="{{$categeries->id}}" selected>{{$categeries->name}}</option>
               @else
               <option value="{{$categeries->id}}">{{$categeries->name}}</option>
               @endif
               @endforeach
            </select>
            <br>
            @else
            <select name="product_id" id="select_product" class="dropdown" onchange="changeProduct(this.value)">
            </select>
            <br>
            @endif
            <span style="color:red;" class="errors" id="product_idErr"></span>
         </div>
      </div>
      <div class="row mt-3" id="brand_container" style="display:none;">
         <label for="" class="col-md-3">Brand</label>
         <div class="col-md-8">
            @if(isset($all_brands))
            <select name="brand_id" id="select_brand" class="dropdown">
               <option value="">Choose Brand</option>
               @foreach($all_brands as $brands)
               @if($brands->id == $brand->id)
               <option value="{{$brands->id}}" selected>{{ucfirst($brands->name)}}</option>
               @else
               <option value="{{$brands->id}}">{{$brands->name}}</option>
               @endif
               @endforeach
            </select><br>
            @else
            <select name="brand_id" id="select_brand" class="dropdown">
            </select><br>
            @endif
            <span style="color:red;" class="errors" id="brand_idErr"></span>
         </div>
      </div>
      <div class="row mt-3">
         <label for="" class="col-md-3">Quantity</label>
         <div class="col-md-8">
            <input type="number" name="quantity" id="quantity" placeholder="Quantity" class="form-control" value="{{$item->quantity??''}}">
            <span style="color:red;" class="errors" id="quantityErr"></span>
         </div>
      </div>
      <div class="row mt-3">
         <label for="" class="col-md-3">Description</label>
         <div class="col-md-8">
            <textarea type="text" name="description" placeholder="Description" class="form-control" value="{{$item->description??''}}"></textarea>
            <span style="color:red;" class="errors" id="descriptionErr"></span>
         </div>
      </div>
      <div class="row mt-4">
         <label for="" class="col-md-3">Image</label>
         <div class="col-md-8">
            <input type="file" name="image" id="image"><br>
            <span id="image_preview" style="display:none;" >
               <img style="width: 20%;" id="imgPreview" src=""/>
            </span>
            <span style="color:red;" class="errors" id="imageErr"></span>
         </div>
      </div>
      <div class="row mt-4">
         <div class="col-md-3"></div>
         <div class="col-md-8">
            @if(isset($all_categories))
            <button class="btn btn-success" id="submit" type="submit">update</button>
            @else
            <button class="btn btn-success" id="submit" type="submit">Submit</button>
            @endif
         </div>
      </div>
</form>
</div>
@endsection
@section('pagescript')
<script src="{{asset('js/item.js')}}"></script>
@endsection