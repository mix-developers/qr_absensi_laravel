<!-- [ Mobile header ] start -->
<div class="pc-mob-header pc-header">
    <div class="pcm-logo">
        <img src="{{ asset('') }}/img/{{ config('app.name') }}.png" alt="" class="logo logo-lg"
            style="max-width: 150px;">
    </div>
    <div class="pcm-toolbar">
        <a href="#!" class="pc-head-link" id="mobile-collapse">
            <div class="hamburger hamburger--arrowturn">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                </div>
            </div>
            <!-- <i data-feather="menu"></i> -->
        </a>
        <a href="#!" class="pc-head-link" id="header-collapse">
            <i data-feather="more-vertical"></i>
        </a>
    </div>
</div>
<!-- [ Mobile header ] End -->
<header class="pc-header ">
    <div class="header-wrapper">
        <div class="mr-auto pc-mob-drp">
            <ul class="list-unstyled">
            </ul>
        </div>
        @php
            // get notification of recent booking and recent review
            $notif_booking = \App\Transaction::where('read_booking', 0)
                ->with(['member', 'wisata'])
                ->get();
            $notif_review = \App\Transaction::where('read_review', 0)
                ->with(['member', 'wisata'])
                ->get();
        @endphp
        <div class="ml-auto">
            <ul class="list-unstyled">
                @if (Auth::user()->isAdmin())
                    <li class="pc-h-item">
                        <a class="pc-head-link mr-0" href="#" data-toggle="modal"
                            data-target="#notification-modal">
                            <i data-feather="bell"></i>
                            @if ($notif_booking->count() + $notif_review->count() > 0)
                                <span class="badge badge-danger pc-h-badge dots"><span class="sr-only"></span></span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none mr-0" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ Auth::user()->avatar == '' ? asset('img/user.png') : url(Storage::url(Auth::user()->avatar)) }}"
                            alt="user-image" class="user-avtar">
                        <span>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-desc">{{ Auth::user()->role }}</span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pc-h-dropdown">
                        <div class=" dropdown-header">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>
                        <a href="{{ route('dashboard.akun') }}" class="dropdown-item">
                            <i data-feather="user"></i>
                            <span>Akun</span>
                        </a>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i data-feather="power"></i>
                            <span>Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</header>
