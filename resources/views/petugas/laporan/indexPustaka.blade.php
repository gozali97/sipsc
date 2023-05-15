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
                            <h4>Laporan</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/laporan">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Laporan Pustaka</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="card-box mb-30">
                <div class="pd-20">
                    <a href="/printPustaka" type="button" class="btn btn-secondary"><i class="icon-copy fa fa-print"
                            aria-hidden="true" style="margin-right: 5px"></i></i>Print</a>
                    <div class="p-4">
                        <table id="datatable" class="table table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th>Gambar</th>
                                    <th>Stok</th>
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
                                        <td>{{ $d->judul }}</td>
                                        <td>{{ $d->kategori }}</td>
                                        <td>{{ $d->nama_pengarang }}</td>
                                        <td>{{ $d->nama_penerbit }}</td>
                                        <td>{{ $d->tahun_terbit }}</td>
                                        <td>{{ $d->jumlah }}</td>
                                        <td><img src="{{ url('assets/img/' . $d->gambar) }}"
                                                style="width:80px; height:80px;border-radius: 5%;" alt=""></td>
                                        <td>Aktif</td>
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
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
