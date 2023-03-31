@extends('layouts.app')

@section('content')
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
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class=" mr-4">
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
                                    <button type="submit" class="col-sm-12 col-md-2 btn btn-secondary"><i class="icon-copy fa fa-search" aria-hidden="true"></i></button>
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
                                <h5>{{ $p->Judul }}</h5>
                                <p>{{ $p->tahun_terbit }}
                                </p>
                                <a href="/list/detail/$p->id_pustaka" class="btn btn-outline-primary">Detail Buku</a>
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
@endsection
