<!-- Title -->
<title> Valex -  Premium dashboard ui bootstrap rwd admin html5 template </title>
<!-- Favicon -->
<link rel="icon" href="{{URL::asset('assets/admin/img/brand/favicon.png')}}" type="image/x-icon"/>
<!-- Icons css -->
<link href="{{URL::asset('assets/admin/css/icons.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('assets/admin/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--  Sidebar css -->
<link href="{{URL::asset('assets/admin/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- Sidemenu css -->
@if (App::getLocale() == 'ar')
    <link rel="stylesheet" href="{{URL::asset('assets/admin/css-rtl/sidemenu.css')}}">
@else
    <link rel="stylesheet" href="{{URL::asset('assets/admin/css/sidemenu.css')}}">
@endif
@yield('css')
<!--- Style css -->
@if (App::getLocale() == 'ar')
    <link href="{{URL::asset('assets/admin/css-rtl/style.css')}}" rel="stylesheet">
@else
    <link href="{{URL::asset('assets/admin/css/style.css')}}" rel="stylesheet">
@endif
<!--- Dark-mode css -->
<link href="{{URL::asset('assets/admin/css-rtl/style-dark.css')}}" rel="stylesheet">
<!---Skinmodes css-->
<link href="{{URL::asset('assets/admin/css-rtl/skin-modes.css')}}" rel="stylesheet">
