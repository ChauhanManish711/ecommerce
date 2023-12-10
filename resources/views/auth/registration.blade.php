@extends('..layouts/app')
@section('main')
  <div class="col-md-12">
    @if(isset($user))
    <h3 class="text-center mt-2" style="color: darkslateblue">Update Account</h3>
    @else
    <h3 class="text-center mt-2" style="color: darkslateblue">Create Account</h3>
    @endif
  </div>
    <div class="col-md-10 main_container p-4 text-center">
  <h4 class="text-danger text-center errors" id="error"></h4>
<form action="@if(isset($user)){{route('register.update')}}@else {{route('register.create')}}@endif" method="post" id="createUpdateUser">
  @csrf
        <div class="row">
          <label class="col-md-3" for="name">Name</label>
            <div class="col-md-8">
                <input type="hidden" name="id" value="{{$user->id??''}}">
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{$user->name??''}}">
                <span  class="errors" id="nameErr" style="color:red;display: flex;">
                </span>
              </div>
        </div>
        
         <div class="row mt-4">
            <label class="col-md-3" for="email">Email</label>
              <div class="col-md-8">
                  <input type="text" name="email" class="form-control" placeholder="Email" value="{{$user->email??''}}">
                  <span class="errors" id="emailErr" style="color:red;display: flex;">
                  </span>
              </div>
          </div>
        @if(isset($roles))
          <div class="row mt-4">
          <label class="col-md-3" for="role">Role</label>
            <div class="col-md-2">
              <select name="role_id" class="dropdown">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                @if(isset($user) && $user->hasRole($role))
                <option value="{{$role->id}}" selected>{{$role->name}}</option>
                @else
                <option value="{{$role->id}}">{{$role->name}}</option>
                @endif
                @endforeach
              </select>
                <span class="errors" id="roleErr" style="color:red;display: flex;">
                </span>
            </div>
          </div>
        @endif
          <div class="row mt-4">
            <label class="col-md-3" for="image">Picture</label>
            <div class="col-md-4">
              <input type="file" name="image" id="image">
              <span class="errors" id="imageErr" style="color:red;display: flex;"></span>
            </div>
          </div>
          <div class="row mt-4">
            <label class="col-md-3" for="password">Password</label>
            <div class="col-md-8">
                <input type="text" name="password" class="form-control password" placeholder="Password">
                <span  class="errors" id="passwordErr" style="color:red;display:table-row;">
                </span>
            </div>   
          </div>
          <div class="row mt-4">
            <label class="col-md-3" for="password_confirmation">Confirm Password</label>
              <div class="col-md-8">
                  <input type="text" name="password_confirmation" class="form-control password" placeholder="Confirm Password">
                  <span class="errors"  id="password_confirmationErr" style="color:red;display: flex;">
                  </span>
              </div>
          </div>
          <div class="row mt-4">
          <div class="col-md-12 text-center">
            @if(isset($user))
            <button class="btn btn-success submit" type="submit">Update</button>
            @else
            <button class="btn btn-success submit" type="submit">Register</button>
            @endif
            <a class="btn btn-danger" href="{{route('dashboard')}}" >Cancel</a>
  </form>  
          </div>
        </div>
      </div>
    </div>
@endsection