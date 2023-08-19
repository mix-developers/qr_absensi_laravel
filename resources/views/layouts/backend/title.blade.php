<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ $title }}</h5>
                </div>
                <ul class="breadcrumb">
                    @if (Auth::user()->role == 'admin')
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ url('/konter') }}">Dashboard</a></li>
                    @endif
                    <li class="breadcrumb-item">{{ $title }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
