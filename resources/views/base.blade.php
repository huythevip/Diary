<!DOCTYPE html>
<head>
    <title>My Diary | @yield('title')</title>
    @include('partials._head')
</head>
<body>
    @include('partials._nav')
    @include('partials._message')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @yield('body')
        </div>
    </div>


    @yield('scripts')
</body>
