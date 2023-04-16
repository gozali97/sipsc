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
                        <h4>Petugas</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/petugas">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Petugas</li>
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
                                <th>Nama Anggota</th>
                                <th>Alamat</th>
                                <th>No Handphone</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($petugas as $p)
                            <tr>
                                <td class="table-plus">{{ $no++ }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->alamat }}</td>
                                <td>{{ $p->no_hp }}</td>
                                <td><img src="{{ url('assets/img/'.$p->gambar) }}"
                                        style="width:80px; height:80px;border-radius: 70%;" alt=""></td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                    <button class="btn btn-warning" data-toggle="modal"
                                        data-target="#editModal{{ $p->id }}"><i class="icon-copy fa fa-edit"
                                            aria-hidden="true" style="margin-right: 5px"></i></button>
                                    <button class="btn btn-danger" data-toggle="modal"
                                        data-target="#deleteModal{{ $p->id }}">
                                        <i class="icon-copy fa fa-trash" aria-hidden="true"
                                            style="margin-right: 5px"></i>
                                    </button>
                                    <button class="btn btn-info" data-toggle="modal"
                                        data-target="#resetPasswordModal{{ $p->id }}">
                                        <i class="icon-copy fa fa-key" aria-hidden="true"
                                            style="margin-right: 5px"></i>
                                    </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Update -->
                            <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModal{{ $p->id }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModal{{ $p->id }}Label">Ubah
                                                Data Anggota</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="editForm{{ $p->id }}" method="POST"
                                            action="{{ route('petugas.update', $p->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="input-group custom">
                                                    <input type="text" class="form-control form-control-lg" name="nama"
                                                        value="{{ $p->nama }}" placeholder="Nama Petugas">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-user-1"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group custom">
                                                    <input type="text" class="form-control form-control-lg" name="email"
                                                        value="{{ $p->email }}" placeholder="Email">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-mail"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group custom">
                                                    <input type="text" class="form-control form-control-lg" name="no_hp"
                                                        value="{{ $p->no_hp }}" placeholder="Nama Anggota">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-smartphone-1"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group custom">
                                                    <input type="text" class="form-control form-control-lg"
                                                        name="alamat" value="{{ $p->alamat }}" placeholder="Alamat">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-building-1"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group custom">
                                                    <div class="file-upload">
                                                        <div class="image-upload-wrap">
                                                            <input class="file-upload-input" type='file' name="gambar" onchange="readURL(this);" accept="image/*" />
                                                            <div class="drag-text">
                                                                <h3>Gambar Anggota</h3>
                                                                <p>Pilih file untuk upload gambar baru</p>
                                                            </div>
                                                        </div>
                                                        <div class="file-upload-content">
                                                            <img class="file-upload-image" src="{{ url('assets/img/'.$p->gambar) }}" alt="gambar" />
                                                        </div>
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
                            <div class="modal fade" id="deleteModal{{ $p->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModal{{ $p->id }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModal{{ $p->id }}Label">Hapus Anggota
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="deleteForm{{ $p->id }}" method="POST"
                                            action="{{ route('petugas.destroy', $p->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Anda yakin ingin menghapus Anggota <strong>{{ $p->nama
                                                        }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reset Password Modal -->
                            <div class="modal fade" id="resetPasswordModal{{ $p->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('petugas.resetPassword', ['id' => $p->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin mereset password anggota ini?</p>
                                                <div class="form-group">
                                                    <label for="password">Password Baru</label>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Reset Password</button>
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
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Pengarang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('petugas.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group custom">
                        <input type="text" name="nama" class="form-control form-control-lg" placeholder="Nama Petugas">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-user-1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="text" name="email" class="form-control form-control-lg" placeholder="Email">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-email"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="text" name="no_hp" class="form-control form-control-lg" placeholder="No Handphone">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-smartphone-1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="text" name="alamat" class="form-control form-control-lg" placeholder="Alamat">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-building-1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="file" name="gambar" class="form-control-file form-control height-auto">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-image"></i></span>
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
