<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Allied Health Practitioners Council</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">

    <link href="{{asset('dist/css/style.min.css')}}" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{asset('dist/css/pages/dashboard1.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style-horizontal.min.css')}}">

    @livewireStyles
</head>

<body class="horizontal-nav skin-megna fixed-layout">

<div class="page-wrapper">

    @livewire('practitioners-table')


</div>

@livewireScripts
</body>

</html>
