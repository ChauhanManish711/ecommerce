@extends('layouts.app')
@section('main')
<div class=" col-md-12 mt-2">
  @if(Session::has('success'))
<h3 class="text-center text-success">{{Session::get('success')}}</h3>     
    @endif
    <h3 class="text-center text-primary">Registred Accounts</h3>
<div class="row">
  <div class="col-md-9"></div>
  @if(Auth::user()->hasPermissionTo('users-create'))
  <div class="col-md-2">
    <a class="btn btn-primary" href="{{route('register')}}">+ Add account</a></div>
  </div>
  @endif
  @if(Auth::user()->hasPermissionTo('users-list'))
    <table class="table mt-3" style="width:100%">
        <thead>
            <th class="dashboard_table_head">Name</th>
            <th class="dashboard_table_head">Email</th>
            <th class="dashboard_table_head">Role</th>
            <th class="dashboard_table_head">Created At</th>
            <th class="dashboard_table_head">Action</th>
        </thead>
        <tbody>
            @if (isset($users))
                @forelse($users as $user)
            <tr>
                <td class="dashboard_table_data">{{ucfirst($user->name)}}</td>
                <td class="dashboard_table_data">{{$user->email}}</td>
                <td class="dashboard_table_data">{{$user->roles->first()->name??''}}</td>
                <td class="dashboard_table_data">{{$user->created_at}}</td>
                <td class="dashboard_table_data">
                <button class="btn btn-primary user_profile" value="{{$user->id}}">View</button>
                @if(Auth::user()->hasPermissionTo('users-edit'))
                <a class="btn btn-success" href="{{route('register.edit',['id'=>$user->id])}}">Edit</a>
                @endif
                @if(Auth::user()->hasPermissionTo('users-delete'))
                <a class="btn btn-danger" href="{{route('register.trash',['id'=>$user->id])}}">Trash</a>
                @endif
                </td>
            </tr>
                @empty
                <h3>No Record Found</h3>
                @endforelse
            @endif
        </tbody>
    </table>
  @endif
  <!-- Modal -->
<div class="modal fade" id="user_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userModalLongTitle">Profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 text-center" id="user_image">        
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-5" style="text-align:end;">Name:</div>
            <div class="col-md-7" style="text-align:start;" id="name"></div>
          </div>
          <div class="row">
            <div class="col-md-5" style="text-align:end;"">Email:</div>
            <div class="col-md-7" id="email" style="text-align:start;"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection