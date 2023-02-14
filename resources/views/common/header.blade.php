<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
     <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <style type="text/css">
       .stu_profile img {
             border: 1px solid green;
             margin: 11px;
         }
       .stu_listing {
          float: right;
          padding-bottom: 26px;
       }
       .stu_add {
          float: right;
          padding-top: 26px;
       }  
    </style>
</head>
<body>
 @if (session()->has('msg'))
    <div class="alert alert-success" id="success-alert">
     <button type="button" class="close" data-dismiss="alert">x</button>
     <strong>Success!</strong>
     {{ session('msg') }}
    </div>
 @endif

