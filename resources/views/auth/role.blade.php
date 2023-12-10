@extends('layouts.app')
@section('main')
@if(Session::has('success'))
<p style="color:green;">{{Session::get('success')}}</p>
@endif
@if(Session::has('error'))
<p style="color:red;">{{Session::get('error')}}</p>
@endif
<h2 class="text-center text-primary">Roles</h2>
<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-2"><button class="btn btn-success" id="addRole">+ Add Role</button></div>
</div>
<table class="mt-1 table text-center">
    <thead>
        <th>Sr.no </th>
        <th>Name</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Action</th>
    </thead>
    <tbody>
    @if(isset($roles))
    @php $a = 1; @endphp
    @foreach($roles as $role)
    <tr>
        <td>{{$a++}}</td>
    <td>{{ucfirst($role->name)}}</td>
    <td>{{$role->created_at}}</td>
    <td>{{$role->updated_at}}</td>
    <td>Edit / Delete </td>
    </tr>
    @endforeach
    @endif
</tbody>
</table>
  <!-- Modal -->
  <div class="modal fade" id="rolesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('add_role')}}" method="POST">
            @csrf
            <div class="row">
                <label for="name" class="col-md-3">Name</label>
                <div class="col-md-8">
                    <input type="text" name="role_name" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="row mt-2">
                <label for="permission" class="col-md-3">Give Permission</label>
                <div class="col-md-8 mt-3">
                    <span id="choose_permission" style="background-color: lightblue;
                    padding: 3%;">Choose Permission <br></span>
                    <span id="select_permission" style="display:none;">
                    @if(isset($permissions))
                    @foreach($permissions as $permission)
                   <input type="checkbox" name="permission[]" value="{{$permission->name}}"> {{$permission->name}}<br>
                    @endforeach
                    @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection