@extends('layouts.app')

@section('content')
<div class="pd-ltr-20 xs-pd-20-10">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Kategori</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    <div class="card-box mb-30">
        <div class="pd-20">
            <button class="btn btn-success" ><i class="icon-copy fa fa-plus" aria-hidden="true" style="margin-right: 5px"></i></i>Tambah</button>
        </div>
        <div class="p-4">
            <table id="datatable" class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($kategori as $k)
                    <tr>
                        <td class="table-plus">{{ $no++ }}</td>
                        <td>$k->kategori</td>
                        <td>
                            <button class="btn btn-warning" ><i class="icon-copy fa fa-edit" aria-hidden="true" style="margin-right: 5px"></i>Ubah</button>
                            <button class="btn btn-danger" ><i class="icon-copy fa fa-trash" aria-hidden="true" style="margin-right: 5px"></i></i>Hapus</button>
                          </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
