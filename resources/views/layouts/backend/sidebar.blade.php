<nav class="pc-sidebar ">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="index.html" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="{{ asset('/') }}img/favicon-3.png" alt="" class="logo logo-lg"
                    style="max-width:150px;">
                <img src="{{ asset('admin_theme') }}/assets/images/logo-sm.svg" alt="" class="logo logo-sm">
            </a>
        </div>
        <div class="navbar-content">
            @include('layouts.partials.menu_admin')
            {{-- @switch(Auth::user()->role)
                @case('super_admin')
                    @include('layouts.partials.menu_admin')
                @break

                @case('staff')
                    @include('layouts.partials.menu_staff')
                @break

                @case('admin')
                    @include('layouts.partials.menu_member')
                @break

                @default
            @endswitch --}}
        </div>
    </div>
</nav>
