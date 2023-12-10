<!-- Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ucfirst(auth()->user()->name)}}</h5>
        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">X</button>
    </div>
    <div class="modal-body text-center">
       Name : {{ucfirst(auth()->user()->name)}}<br>
       Email : {{auth()->user()->email}}<br>    
       Role :  Admin
    </div>
    <div class="modal-footer">
        <a href="{{route('logout')}}" class="btn btn-primary">Logout</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
    </div>
</div>
</div> 