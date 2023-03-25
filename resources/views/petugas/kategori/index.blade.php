@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<script>
    $(document).ready(function(){
            setTimeout(function(){
                $(".alert").alert('close');
            }, 5000);
        });
</script>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<script>
    $(document).ready(function(){
            setTimeout(function(){
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
                        <h4>Kategori</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/petugas">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card-box mb-30">
            <div class="pd-20">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#input-modal"><i
                        class="icon-copy fa fa-plus" aria-hidden="true"
                        style="margin-right: 5px"></i></i>Tambah</button>
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
                                <td>{{ $k->kategori }}</td>
                                <td>
                                    <button class="btn btn-warning" data-toggle="modal"
                                        data-target="#editModal{{ $k->id_kategori }}"><i class="icon-copy fa fa-edit"
                                            aria-hidden="true" style="margin-right: 5px"></i>Ubah</button>
                                    <button class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteModal{{ $k->id_kategori }}">
                                        <i class="icon-copy fa fa-trash" aria-hidden="true"
                                            style="margin-right: 5px"></i>Hapus
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Update -->
                            <div class="modal fade" id="editModal{{ $k->id_kategori }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModal{{ $k->id_kategori }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModal{{ $k->id_kategori }}Label">Ubah
                                                Kategori</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="editForm{{ $k->id_kategori }}" method="POST"
                                            action="{{ route('kategori.update', $k->id_kategori) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="input-group custom">
                                                    <input type="text" class="form-control form-control-lg"
                                                        name="kategori" value="{{ $k->kategori }}"
                                                        placeholder="Nama Kategori">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-book"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal{{ $k->id_kategori }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $k->id_kategori }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="deleteModal{{ $k->id_kategori }}Label">Hapus Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <form id="deleteForm{{ $k->id_kategori }}" method="POST" action="{{ route('kategori.destroy', $k->id_kategori) }}">
                            @csrf
                            <div class="modal-body">
                                <p>Anda yakin ingin menghapus kategori <strong>{{ $k->kategori }}</strong>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
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

<!-- Modal insert -->
<div class="modal fade bs-example-modal-lg" id="input-modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('kategori.store') }}">
                    @csrf
                    <div class="input-group custom">
                        <input type="text" name="kategori" class="form-control form-control-lg"
                            placeholder="Nama Kategori">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-book"></i></span>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
      $('#datatable').DataTable();
    });
</script>
@endsection
