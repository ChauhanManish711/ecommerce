{{-- navbar --}}
<div style="display: flex;    background-color: azure;">
    <div style="width:90%;margin-top: 1%;">
      <ul style="display:flex;list-style-type: none;">
        <li>
          <a href="{{route('home')}}">Home</a>
        </li>
        <li style="margin-inline: 3%;">
          <a href="#">Link</a>
        </li>
        <li class="nav-item">
          <a href="#">Disabled</a>
        </li>
      </ul>
    </div>
    <div style="width:10%;margin-top: 1%;">
      <button type="button" class="btn" id="logout_user">
        {{ucfirst(auth()->user()->name)}}
      </button>        
    </div>
</div> 
@include('bootstrap_modals.logout')