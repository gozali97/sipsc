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
                    <div class="title inline-flex">
                        <h4>Pustaka</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">List Pustaka</li>
                        </ol>
                    </nav>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <button type="button" data-toggle="modal" data-target="#modalPinjam"
                                class="btn btn-success"><i class="icon-copy dw dw-add-file mr-1"></i>Pinjam
                                Buku</button>
                                <div class="modal fade bs-example-modal-lg" id="modalPinjam" tabindex="-1" role="dialog"
                                    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modalPinjam">Detail Pustaka</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <form method="POST" id="modalPinjam{{ Auth::user()->id }}" action="{{ route('pinjam.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="input-group custom">
                                                        <input type="text" name="nama" value="{{ Auth::user()->nama }}" class="form-control form-control-lg" placeholder="Nama Anggota" readonly>
                                                        <input type="hidden" name="id_user" value="{{ Auth::user()->id }}">
                                                        <div class="input-group-append custom">
                                                            <span class="input-group-text"><i class="icon-copy dw dw-user-1"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="input-group custom">
                                                        <select name="pustaka[]" class="custom-select2 form-control" multiple="multiple" style="width: 100%;">
                                                            @foreach ($pustaka as $p)
                                                            <option value="{{ $p->id_pustaka }}">{{ $p->judul }} - {{ $p->tahun_terbit }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="mt-1 mr-4">
                                <form action="{{ route('list.index') }}" method="GET">
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-10">
                                            <select name="kategori" class="custom-select col-12">
                                                <option value="">Semua Kategori Pustaka</option>
                                                @foreach ($kategori as $k)
                                                <option value="{{ $k->id_kategori }}">{{ $k->kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="col-sm-12 col-md-2 btn btn-secondary"><i
                                                class="icon-copy fa fa-search" aria-hidden="true"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-wrap">
            <div class="product-list">
                <ul class="row">
                    @foreach ($pustaka as $p)
                    <li class="col-lg-4 col-md-6 col-sm-12">
                        <div class="product-box">
                            <div class="producct-img"><img src="{{ url('/assets/img/'.$p->gambar) }}" alt=""></div>
                            <div class="product-caption">
                                <h5>{{ $p->judul }}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>{{ $p->tahun_terbit }}
                                        </p>
                                    </div>
                                    <div class="col-md-6 float-right">
                                        <p>Stock : {{ $p->jumlah }}
                                        </p>
                                    </div>
                                </div>

                                <button class="btn btn-outline-primary" data-toggle="modal"
                                    data-target="#bd-example-modal-lg{{ $p->id_pustaka }}" type="button">
                                    Detail Pustaka</button>
                                <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg{{ $p->id_pustaka }}"
                                    tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel{{ $p->id_pustaka }}"
                                    aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="bd-example-modal-lg{{ $p->id_pustaka }}">
                                                    Detail Pustaka</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <form id="bd-example-modal-lg{{ $p->id_pustaka }}"
                                                action="{{ route('pinjam.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <img src="{{ url('/assets/img/'.$p->gambar) }}"
                                                                style="width: 362px;height: 400px;" alt="">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="hidden" name="pustaka"
                                                                value="{{ $p->id_pustaka }}">
                                                            <h5>{{ $p->judul }}</h5>
                                                            <p>{{ $p->deskripsi }}</p>
                                                            <p class="font-weight-bold">Tahun Terbit: </p>
                                                            <p class="">{{ $p->tahun_terbit }}</p>
                                                            <p class="font-weight-bold">ISBN</p>
                                                            <p>{{ $p->isbn }}</p>
                                                            <p class="font-weight-bold">Stock</p>
                                                            <p>{{ $p->jumlah }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    {{-- <button type="submit" class="btn btn-primary">Tambah</button>
                                                    --}}
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    @endforeach
                </ul>
            </div>
            <div class="blog-pagination mb-30">
                <div class="btn-toolbar justify-content-center mb-15">
                    <div class="btn-group">
                        {{ $pustaka->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
        SIPSC - Sistem Informasi Perpustakaan Berbasis Web <a href="#">Andrean Jodi Setyawan </a>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#multiple').select2();
});
</script>
@endsection
