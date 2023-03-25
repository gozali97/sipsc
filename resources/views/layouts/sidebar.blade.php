<div class="left-side-bar">
    <div class="brand-logo ml-4">
        <a href="index.html">
           <h3 class="text-white">SIPSC</h3>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                @auth
                @if (Auth::user()->role->name === 'admin')
                <li>
                    <a href="#" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-package"></span><span class="mtext">Master</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="/kategori">Data Kategori</a></li>
                    </ul>
                    <ul class="submenu">
                        <li><a href="/pengarang">Data Pengarang</a></li>
                    </ul>
                    <ul class="submenu">
                        <li><a href="index.html">Data Penerbit</a></li>
                    </ul>
                    <ul class="submenu">
                        <li><a href="index.html">Data Pustaka</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-shopping-cart"></span><span class="mtext">Transaksi</span>
                    </a>
                </li>
                @elseif (Auth::user()->role->name === 'petugas')
                <li>
                    <a href="#" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-invoice"></span><span class="mtext">Data Buku</span>
                    </a>
                </li>
                @elseif (Auth::user()->role->name === 'anggota')
                <li>
                    <a href="#" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-invoice"></span><span class="mtext">Daftar Buku</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('logout') }}" class="dropdown-toggle no-arrow" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <span class="micon dw dw-logout1"></span><span class="mtext">Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
                @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</div>
