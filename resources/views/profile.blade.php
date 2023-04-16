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

<div class="pd-ltr-20">
    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="title">
                        <h4>Profile</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                <div class="pd-20 card-box height-50-p">
                    <div class="profile-photo">
                        <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-search"></i></a>
                        <img src="{{ url('/assets/img/'.$data->gambar) }}" alt="" class="avatar-photo">
                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body pd-5">
                                        <div class="img-container">
                                            <img id="image" src="{{ url('/assets/img/'.$data->gambar) }}" alt="Picture">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center h5 mb-0">{{ $data->nama }}</h5>
                    <p class="text-center text-muted font-14">Jabatan : {{ $data->name }}</p>
                    <div class="profile-info">
                        <h5 class="mb-20 h5 text-blue">Contact Information</h5>
                        <ul>
                            <li>
                                <span>Email :</span>
                                {{ $data->email }}
                            </li>
                            <li>
                                <span>No Handphone :</span>
                                {{ $data->no_hp }}
                            </li>
                            <li>
                                <span>Alamat :</span>
                                {{ $data->alamat }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
                <div class="card-box height-100-p overflow-hidden">
                    <h4 class="ml-4 mt-4">Edit Profil</h4>
                    <form method="POST" action="{{ route('profile.update', Auth::user()->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="nama"
                                    value="{{ $data->nama }}" placeholder="Nama Anggota">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i
                                            class="icon-copy dw dw-user-1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="kelas"
                                    value="{{ $data->kelas }}" placeholder="Kelas">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-name"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="email"
                                    value="{{ $data->email }}" placeholder="Email">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i
                                            class="icon-copy dw dw-mail"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg" name="no_hp"
                                    value="{{ $data->no_hp }}" placeholder="Nama Anggota">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i
                                            class="icon-copy dw dw-smartphone-1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg"
                                    name="alamat" value="{{ $data->alamat }}" placeholder="Alamat">
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
                                            <h3>Gambar</h3>
                                            <p>Pilih file untuk upload gambar baru</p>
                                        </div>
                                    </div>
                                    <div class="file-upload-content">
                                        <img class="file-upload-image" src="{{ url('assets/img/'.$data->gambar) }}" style="width: 80px; height: 80px;" alt="gambar" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary"
                                data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
        SIPSC - Sistem Informasi Perpustakaan Berbasis Web <a href="#">Andrean Jodi Setyawan </a>
    </div>
</div>
@endsection
