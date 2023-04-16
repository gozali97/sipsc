<style>
    .logo{
        width: 35px;
        margin-right: 8px;
    }
</style>

<div class="left-side-bar">
    <div class="brand-logo ml-4">
        <a href="#">
            <img src="{{ url('assets/img/logosmk.png') }}" class="light-logo logo" alt="">
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
                    <a href="/admin" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-shopping-cart"></span><span class="mtext">Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="/listpetugas" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-user-2"></span><span class="mtext">Kelola Petugas</span>
                    </a>
                </li>
                @elseif (Auth::user()->role->name === 'petugas')
                <li>
                    <a href="/petugas" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span></span><span class="mtext">Dashboard</span>
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
                        <li><a href="/penerbit">Data Penerbit</a></li>
                    </ul>
                    <ul class="submenu">
                        <li><a href="/pustaka">Data Pustaka</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-shopping-cart"></span><span class="mtext">Transaksi</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="/listpinjam">Peminjaman</a></li>
                    </ul>
                    <ul class="submenu">
                        <li><a href="/listkembali">Pengembalian</a></li>
                    </ul>

                </li>
                <li>
                    <a href="/laporan" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-notebook"></span></span><span class="mtext">Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="/users" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-user-2"></span><span class="mtext">Kelola Anggota</span>
                    </a>
                </li>
                @elseif (Auth::user()->role->name === 'anggota')
                <li>
                    <a href="/anggota" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/list" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-book-1"></span><span class="mtext">List Pustaka</span>
                    </a>
                </li>
                <li>
                    <a href="/pinjam/list" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-open-book-2"></span><span class="mtext">History Peminjaman</span>
                    </a>
                </li>
                @endif
                <li>
                    <a href="/profil" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-user-12"></span><span class="mtext">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle no-arrow" onclick="event.preventDefault(); Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: 'Anda akan keluar dari aplikasi!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, logout!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logout-form').submit();
                            }
                        });">
                    <span class="micon dw dw-logout1"></span><span class="mtext">Logout</span>
                </a>

                </li>
                @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</div>
