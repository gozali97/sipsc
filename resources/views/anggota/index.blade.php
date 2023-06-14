@extends('layouts.app')

@section('content')

<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="{{ url('assets/img/logosmk.png') }}" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>50%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div> 
<div class="pd-ltr-20">
    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center">
            <div class="col-md-4">
                <img src="{{ url('/assets/vendors/images/banner-img.png') }}" alt="">
            </div>
            <div class="col-md-8">
                <h4 class="font-20 weight-500 mb-10 text-capitalize">
                    Hallo, <div class="weight-600 font-30 text-blue">{{ Auth::user()->nama }}</div>
                </h4>
                <p class="font-18 max-width-600"></p>
                <p class="font-18 max-width-600">Ada informasi menarik nih, kini kamu bisa langsung memesan buku bacaan melalui website SIPSC loh. Caranya cukup mudah, tinggal pilih buku mana yang mau dipinjam melalui web, kemudian tinggal ambil bukunnya ke perpustakaan 😊</p>
            </div>  
        </div>
    </div>
    <div class="footer-wrap pd-20 mb-20 card-box">
        SIPSC - Sistem Informasi Perpustakaan Berbasis Web <a href="#">Andrean Jodi Setyawan </a>
    </div>
</div>
@endsection
