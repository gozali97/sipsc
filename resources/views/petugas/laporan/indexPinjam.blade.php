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
                            <h4>Laporan Peminjaman</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/laporan">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Laporan Peminjaman</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-box mb-30">
                <div class="pd-20">
                    <form action="{{ route('laporan.printPinjam') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="bulan">Pilih Periode</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control date-picker" name="stat_date" placeholder="Mulai"
                                        type="text">
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control date-picker" name="end_date" placeholder="Akhir"
                                        type="text">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="icon-copy fa fa-print" aria-hidden="true"
                                            style="margin-right: 5px"></i>Print
                                    </button>
                                </div>
                            </div>

                        </div>

                    </form>
                    <div class="p-4">
                        <table id="datatable" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Kelas</th>
                                    <th>Judul</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $d->nama }}</td>
                                        <td>{{ $d->kelas }}</td>
                                        <td>{{ $d->judul }}</td>
                                        <td>{{ \Carbon\Carbon::parse($d->tgl_pinjam)->format('d-m-Y') }}</td>
                                        <td>{{ $d->status }}</td>
                                    </tr>
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
        $(document).on('click', '.acc-button', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Buku akan dibawa oleh anggota.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, konfirmasi!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/listpinjam/accpinjam/" + id,
                        type: "GET",
                        success: function() {
                            Swal.fire({
                                title: "Sukses!",
                                text: "Buku sudah dibawa oleh anggota.",
                                type: "success",
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        },
                        error: function() {
                            swal("Oops!", "Terjadi kesalahan saat konfirmasi Pustaka.",
                                "error");
                        }
                    });
                }
            });
        });
    </script>


    
@endsection
