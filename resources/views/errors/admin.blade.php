@extends('layouts.error')

@section('main-content')
    <!-- Begin Page Content -->
    <div class="container-fluid " style="margin-top: 100px; margin-bottom:100px;">

        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto" data-text="  @yield('code')"> @yield('code')</div>
            <p class="lead text-gray-800 mb-5">@yield('message')</p>
            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
            <a href="{{ url('/') }}">&larr; Back</a>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
