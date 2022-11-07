@include('layouts.dashboard.layouts.header')
@include('layouts.dashboard.layouts.navbar')
@include('layouts.dashboard.layouts.aside')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content">
        @yield('content')
    </div>
</div>
@include('partials._session')
@include('layouts.dashboard.layouts.footer')
