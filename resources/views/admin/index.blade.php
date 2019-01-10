<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="{{asset('/assets/admin/css/admin.css')}}">
</head>
<body class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">
<div id="admin"></div>
<script type="text/javascript" src="{{asset('/assets/admin/js/admin.js')}}"></script>
</body>
</html>
