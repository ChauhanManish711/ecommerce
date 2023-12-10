@extends('layouts.app')
@section('main')
<div>
    <h2 class="text-primary text-center mt-2">Activity Log</h2>
<table class="table">
    <thead>
        <th>Name</th>
        <th>Email</th>
        <th>Operations</th>
        <th>Status</th>
        <th>Date and Time</th>
    </thead>
    <tbody>
        @if(isset($activities))
        @foreach($activities as $activity)
        <tr>
            <td>{{ucfirst($activity->name)}}</td>
            <td>{{$activity->email}}</td>
            <td>{{$activity->operation}}</td>
            <td>{{$activity->status}}</td>
            <td>{{$activity->created_at}}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
</div>
<div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-6">
            {!! $activities->links('pagination::bootstrap-4') !!}
        </div>
    </div>
</div>
@endsection