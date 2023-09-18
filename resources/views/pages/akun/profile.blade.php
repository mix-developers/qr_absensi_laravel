@extends('layouts.backend.admin')

@section('content')
    <div class="pc-container">
        <div class="pcoded-content">
            @include('layouts.backend.title')
            <!-- Page Heading -->
            {{-- <h1 class="h3 mb-4 text-gray-800">{{ __($title) }}</h1> --}}

            @if (session('success'))
                <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-left-danger" role="alert">
                    <ul class="pl-4 my-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-4 order-lg-2">
                    <div class="card shadow ">
                        <div class="card-profile-image text-center mt-4">
                            <img src="{{ asset('img/user.png') }}"style="height:100px;">
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-center">
                                        <h5>{{ Auth::user()->name . isset(Auth::user()->last_name) }}</h5>
                                        <p>
                                            @if (Auth::user()->role == 'super_admin' || Auth::user()->role == 'admin')
                                                Administrator
                                            @elseif(Auth::user()->role == 'dosen')
                                                Dosen
                                            @elseif(Auth::user()->role == 'mahasiswa')
                                                Mahasiswa
                                            @elseif(Auth::user()->role == 'ketua_jurusan')
                                                Jurusan
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-lg-8 order-lg-1">

                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <input type="hidden" name="_method" value="PUT">

                                <h6 class="heading-small text-muted mb-4">User information</h6>

                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="name">Name<span
                                                        class="small text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" name="name"
                                                    placeholder="Name"
                                                    value="{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::guard('pegawai')->user()->nama }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="last_name">Last name</label>
                                                <input type="text" id="last_name" class="form-control" name="last_name"
                                                    placeholder="Last name"
                                                    value="{{ old('last_name', Auth::user()->last_name) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-control-label" for="email">Email address<span
                                                        class="small text-danger">*</span></label>
                                                <input type="email" id="email" class="form-control" name="email"
                                                    placeholder="example@example.com"
                                                    value="{{ old('email', Auth::user()->email) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="current_password">Current
                                                    password</label>
                                                <input type="password" id="current_password" class="form-control"
                                                    name="current_password" placeholder="Current password">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="new_password">New password</label>
                                                <input type="password" id="new_password" class="form-control"
                                                    name="new_password" placeholder="New password">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="confirm_password">Confirm
                                                    password</label>
                                                <input type="password" id="confirm_password" class="form-control"
                                                    name="password_confirmation" placeholder="Confirm password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col text-center">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
