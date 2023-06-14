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
                        <h4>Peminjaman</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/listpinjam">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Peminjaman</li>
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
                        <button class="btn btn-info sync-data" data-url="{{ route('listpinjam.sync') }}"><i class="icon-copy dw dw-rotate"></i> Sync Data</button>
                <div class="p-4">
                    <table id="datatable" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jumlah</th>
                                <th>Tanggal Pinjam</th>
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
                                <td>{{ $p->jumlah }}</td>
                            <!--    <td>@php
                                    if($p->status = 1){
                                    $status = "Aktif";
                                    }else{
                                    $status = "Tidak Aktif";
                                    }
                                    @endphp
                                    <span class="badge {{$p->status == 1 ? 'badge-success' : 'badge-danger' }}">{{
                                        $status }}</span> 
                                </td> -->
                                <td> {{ $p->created_at }}</td>
                                <td><img src="{{ url('assets/img/'.$p->gambar) }}" style="width:80px; height:80px;"
                                        alt=""></td>
                                <td>
                                    <a type="button" href="{{ route('listpinjam.view', $p->no_pinjam) }}"
                                        class="btn btn-outline-info"><i class="icon-copy fa fa-info-circle mr-1"
                                            aria-hidden="true"></i>Detail</a>
                                    <button class="btn btn-outline-danger" data-toggle="modal"
                                        data-target="#deleteModal{{ $p->no_pinjam }}">
                                        <i class="icon-copy dw dw-trash" aria-hidden="true"
                                            style="margin-right: 5px"></i>
                                        Hapus
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="deleteModal{{ $p->no_pinjam }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModal{{ $p->no_pinjam }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModal{{ $p->no_pinjam }}Label">Hapus
                                                Peminjaman</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="deleteForm{{ $p->no_pinjam }}" method="POST"
                                            action="{{ route('listpinjam.destroy', $p->no_pinjam) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Anda yakin ingin menghapus peminjaman <strong>{{ $p->nama
                                                        }} - {{ $p->kelas }}</strong>?</p>
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
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Pinjaman</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('listpinjam.insert') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group custom">
                        <select id="user" name="id_user" class="form-control" placeholder="Nama Anggota">
                            <option value="">-- Nama Anggota --</option>
                            @foreach ($anggota as $a)
                            <option value="{{ $a->id }}">{{ $a->nama }} - Kelas {{ $a->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group custom">
                        <label for="pustaka">Daftar Buku</label>
                        <select id="pustaka" name="pustaka[]" class="custom-select2 form-control" multiple="multiple"
                            style="width: 100%;">
                            @foreach ($pustaka as $p)
                            <option value="{{ $p->id_pustaka }}">{{ $p->judul }} - {{ $p->tahun_terbit }}</option>
                            @endforeach
                        </select>
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

    $('select[name="pustaka"]').change(function() {
        var imgSrc = $('option:selected', this).data('img');
            if (imgSrc) {
                $('#buku-image').html('<img src="{{ url('/assets/img') }}/'+imgSrc+'" alt="gambar pustaka" width="200px">');
            } else {
                $('#buku-image').empty();
            }
    });

    $(document).ready(function() {
        $('.sync-data').click(function(e) {
            e.preventDefault();
            var url = $(this).data('url');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message
                    });
                }
            });
        });
    });
</script>
@endsection
