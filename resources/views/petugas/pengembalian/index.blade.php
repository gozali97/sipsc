@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 5000);
            });
        </script>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 5000);
            });
        </script>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".alert").alert('close');
                }, 5000);
            });
        </script>
    @endif

    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Pengembalian</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/anggota">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Pengembalian</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-box mb-30">
                <div class="pd-20">
                    {{-- <a href="/list" type="button" class="btn btn-success"><i
                        class="icon-copy fa fa-plus" aria-hidden="true"
                        style="margin-right: 5px"></i></i>Tambah</a> --}}
                    <div class="p-4">
                        <table id="datatable" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Email</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Jumlah</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $p)
                                    <tr>
                                        <td class="table-plus">{{ $no++ }}</td>
                                        <td>{{ $p->nama }}</td>
                                        <td>{{ $p->kelas }}</td>
                                        <td>{{ $p->email }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->tgl_kembali)->timezone('Asia/Jakarta')->format('H:i d-m-Y') }}
                                        </td>
                                        <td>{{ $p->jumlah }}</td>
                                        <td><img src="{{ url('assets/img/' . $p->gambar) }}"
                                                style="width:80px; height:80px;" alt=""></td>
                                        <td>
                                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                                <a href="{{ route('listkembali.detail', $p->no_kembali) }}"
                                                    class="btn btn-outline-info"><i class="icon-copy fa fa-info-circle"
                                                        aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal Info -->
                                    <div class="modal fade bs-example-modal-lg"
                                        id="bd-example-modal-lg{{ $p->no_kembali }}" tabindex="-1" role="dialog"
                                        aria-labelledby="myLargeModalLabel{{ $p->no_kembali }}" aria-hidden="true"
                                        style="display: none;">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="bd-example-modal-lg{{ $p->no_kembali }}">
                                                        Detail Pustaka</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">×</button>
                                                </div>
                                                <form id="bd-example-modal-lg{{ $p->no_kembali }}"
                                                    action="{{ route('pinjam.store') }}" method="POST">
                                                    @csrf
                                                    <div id="detail" class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <img src="{{ url('/assets/img/' . $p->gambar) }}"
                                                                    style="width: 362px;height: 550px;" alt="">

                                                                <h5>{{ $p->judul }}</h5>
                                                                <p>{{ $p->deskripsi }}</p>
                                                                <p class="font-weight-bold">Tahun Terbit: </p>
                                                                <p class="">{{ $p->tahun_terbit }}</p>
                                                                <p class="font-weight-bold">ISBN</p>
                                                                <p>{{ $p->isbn }}</p>
                                                                <p class="font-weight-bold">Status</p>
                                                                <p>@php
                                                                    if ($p->status == 1) {
                                                                        $status = 'Dipinjam';
                                                                    } else {
                                                                        $status = 'Dikembalikan';
                                                                    }
                                                                @endphp
                                                                    {{ $status }}</p>
                                                                <p class="font-weight-bold">Tanggal Pinjam</p>
                                                                <p>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d-m-Y') }}
                                                                    Jam :
                                                                    {{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('H:i') }}
                                                                    WIB</p>
                                                                <p class="font-weight-bold">Tanggal Dikembalikan</p>
                                                                <p>{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d-m-Y') }}
                                                                    Jam :
                                                                    {{ \Carbon\Carbon::parse($p->tgl_kembali)->format('H:i') }}
                                                                    WIB</p>
                                                                <p class="font-weight-bold">Jumlah Keterlambatan</p>
                                                                <p>{{ $p->jml_terlambat }} Hari</p>
                                                                <p class="font-weight-bold">Denda</p>
                                                                <p>Rp. {{ number_format($p->nominal_denda, 0, ',', '.') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Simple Datatable End -->

            <div class="footer-wrap pd-20 mb-20 card-box">
                SIPSC - Sistem Informasi Perpustakaan Berbasis Web <a href="#">Andrean Jodi Setyawan </a>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
