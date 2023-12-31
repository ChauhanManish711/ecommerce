<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">    
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
  </head>
<body>
  @include('../admin/bootstrap_models')
    @include('layouts.navbar')
    <div style="margin-top:2%">   
      <div class="row">
      {{-- sidebar --}}
        <div class="col-md-2">
          @include('layouts.sidebar')
        </div>
      {{-- main --}}
       <div class="col-md-10">
      @yield('main')
       </div>
    </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <script src="{{asset('js/app.js')}}"></script>
      <script src="{{asset('js/registration.js')}}"></script>
      {{-- add script --}}
      @yield('pagescript')
</body>
</html>
