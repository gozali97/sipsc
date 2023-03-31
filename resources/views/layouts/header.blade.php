<div class="header">
    <div class="header-left">
        <div class="menu-icon dw dw-menu"></div>
        <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
        <div class="header-search">
            <h5>Aplikasi Perpustakaan SMK Negeri 1 Cangkringan</h5>
        </div>
    </div>
    <div class="header-right">
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">
                        <img src="{{ url('assets/img/'.Auth::user()->gambar) }}" alt="">
                    </span>
                    <span class="user-name">{{ Auth::user()->nama }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="/anggota/profil/{{ Auth::user()->id }}"><i class="dw dw-user1"></i> Profile</a>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); Swal.fire({
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
                    <i class="dw dw-logout"></i> Log Out</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
