<div>
   <ul class="sidebar_container">
   @if(Auth::user()->hasPermissionTo('admin-dashboard'))
    <li class="sidebar-list"><a href="{{route('dashboard')}}">User Management</a></li>
   @endif
    <li class="sidebar-list"><a href="{{route("roles")}}">Roles</a></li>
    <li class="sidebar-list"><a href="{{route('products.all')}}">Product Management</a></li>
    {{-- <li class="sidebar-list"><a href="">Orders</a></li> --}}
    <li class="sidebar-list"><a href="{{route('activity.all')}}">Activity Log</a></li>
    <li class="sidebar-list"><a href="{{route('logout')}}">Logout</a></li>
   </ul>
</div>