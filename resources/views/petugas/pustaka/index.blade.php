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
                        <h4>Pustaka</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/petugas">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pustaka</li>
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
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Gambar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($pustaka as $p)
                            <tr>
                                <td class="table-plus">{{ $no++ }}</td>
                                <td>{{ $p->judul }}</td>
                                <td>{{ $p->kategori }}</td>
                                <td>{{ $p->pengarang }}</td>
                                <td>{{ $p->penerbit }}</td>
                                <td>{{ $p->tahun_terbit }}</td>
                                <td><img src="{{ url('assets/img/'.$p->gambar) }}"
                                        style="width:80px; height:80px;border-radius: 5%;" alt=""></td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <button class="btn btn-outline-warning" data-toggle="modal"
                                            data-target="#editModal{{ $p->id_pustaka }}"><i class="icon-copy fa fa-edit"
                                                aria-hidden="true"></i></button>
                                        <button class="btn btn-outline-danger" data-toggle="modal"
                                            data-target="#deleteModal{{ $p->id_pustaka }}">
                                            <i class="icon-copy fa fa-trash" aria-hidden="true"
                                                style="margin-right: 5px"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Update -->
                            <div class="modal fade" id="editModal{{ $p->id_pustaka }}" tabindex="-1" role="dialog"
                                aria-labelledby="editModal{{ $p->id_pustaka }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModal{{ $p->id_pustaka }}Label">Ubah
                                                Data Pustaka</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="editForm{{ $p->id_pustaka }}" method="POST"
                                            action="{{ route('pustaka.update', $p->id_pustaka) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="input-group custom">
                                                    <input type="text" class="form-control form-control-lg" name="judul"
                                                        value="{{ $p->judul }}" placeholder="">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-book"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group custom">
                                                    <select name="kategori" class="form-control form-control-lg"
                                                        placeholder="Nama Anggota">
                                                        <option value="">-- Kategori --</option>
                                                        @foreach ($kategori as $kategoris)
                                                        <option value="{{ $kategoris->id_kategori }}" {{ $kategoris->
                                                            id_kategori == $p->id_kategori ? 'selected' : '' }}>{{
                                                            $kategoris->kategori }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group custom">
                                                    <select name="pengarang" class="form-control form-control-lg"
                                                        placeholder="Nama Anggota">
                                                        <option value="">-- Pengarang --</option>
                                                        @foreach ($pengarang as $pengarangs)
                                                        <option value="{{ $pengarangs->id_pengarang }}" {{ $pengarangs->
                                                            id_pengarang == $p->id_pengarang ? 'selected' : '' }}>{{
                                                            $pengarangs->nama_pengarang }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group custom">
                                                    <select name="penerbit" class="form-control form-control-lg"
                                                        placeholder="Nama Anggota">
                                                        <option value="">-- Penerbit --</option>
                                                        @foreach ($penerbit as $penerbits)
                                                        <option value="{{ $penerbits->id_penerbit }}" {{ $penerbits->
                                                            id_penerbit == $p->id_penerbit ? 'selected' : '' }}>{{
                                                            $penerbits->nama_penerbit }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group custom">
                                                    <input type="number" class="form-control form-control-lg"
                                                        name="jumlah" value="{{ $p->jumlah }}" placeholder="Jumlah">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-book1"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group custom">
                                                    <input type="number" class="form-control form-control-lg"
                                                        name="terbit" value="{{ $p->tahun_terbit }}"
                                                        placeholder="Terbit">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-calendar-1"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group custom">
                                                    <input type="text" class="form-control form-control-lg" name="isbn"
                                                        value="{{ $p->isbn }}" placeholder="Terbit">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-open-book-2"></i></span>
                                                    </div>
                                                </div>
                                                <div class="input-group custom">
                                                    <select name="status" class="form-control form-control-lg"
                                                        placeholder="Status">
                                                        <option value="1" {{ $p->status == "1" ? 'selected' : ''
                                                            }}>Aktif</option>
                                                        <option value="0" {{ $p->status == "0" ? 'selected' : ''
                                                            }}>Tidak Aktif</option>
                                                    </select>
                                                </div>
                                                <div class="input-group custom">
                                                    <input type="text" class="form-control form-control-lg" name="deskripsi"
                                                        value="{{ $p->deskripsi }}" placeholder="Deskripsi">
                                                    <div class="input-group-append custom">
                                                        <span class="input-group-text"><i
                                                                class="icon-copy dw dw-open-book-2"></i></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="input-group custom">
                                                    <div class="file-upload">
                                                        <div class="image-upload-wrap">
                                                            <input class="file-upload-input" type='file' name="gambar"
                                                                onchange="readURL(this);" accept="image/*" />
                                                            <div class="drag-text">
                                                                <h3>Gambar Pustaka</h3>
                                                                <p>Pilih file untuk upload gambar baru</p>
                                                            </div>
                                                        </div>
                                                        <div class="file-upload-content">
                                                            <img class="file-upload-image"
                                                                src="{{ url('assets/img/'.$p->gambar) }}"
                                                                alt="gambar" />
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
                            <div class="modal fade" id="deleteModal{{ $p->id_pustaka }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModal{{ $p->id_pustaka }}Label" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModal{{ $p->id_pustaka }}Label">Hapus
                                                Pustaka
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form id="deleteForm{{ $p->id_pustaka }}" method="POST"
                                            action="{{ route('pustaka.destroy', $p->id_pustaka) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Anda yakin ingin menghapus pustaka <strong>{{ $p->judul
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
                <h4 class="modal-title" id="myLargeModalLabel">Tambah Pustaka</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('pustaka.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group custom">
                        <input type="text" name="judul" class="form-control form-control-lg" placeholder="Judul">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-user-1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <select name="kategori" class="selectpicker form-control" data-style="btn-outline-secondary"
                            data-size="5">
                            <optgroup label="Kategori" data-max-options="2">
                                <option value="">-- Kategori --</option>
                                @foreach ($kategori as $kategoris)
                                <option value="{{ $kategoris->id_kategori }}">{{ $kategoris->kategori }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="input-group custom">
                        <select name="pengarang" class="selectpicker form-control" data-style="btn-outline-secondary"
                            data-size="5">
                            <optgroup label="Pengarang" data-max-options="2">
                                <option value="">-- Pengarang --</option>
                                @foreach ($pengarang as $pengarangs)
                                <option value="{{ $pengarangs->id_pengarang }}">{{ $pengarangs->nama_pengarang }}
                                </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="input-group custom">
                        <select name="penerbit" class="selectpicker form-control" data-style="btn-outline-secondary"
                            data-size="5">
                            <optgroup label="Penerbit" data-max-options="2">
                                <option value="">-- Penerbit --</option>
                                @foreach ($penerbit as $penerbits)
                                <option value="{{ $penerbits->id_penerbit }}">{{ $penerbits->nama_penerbit }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="input-group custom">
                        <input type="number" name="jumlah" class="form-control form-control-lg" placeholder="Jumlah">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-book1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="number" name="terbit" class="form-control form-control-lg"
                            placeholder="Tahun Terbit">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-calendar-1"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="text" name="isbn" class="form-control form-control-lg" placeholder="ISBN">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-open-book-2"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <input type="text" name="deskripsi" class="form-control form-control-lg" placeholder="Deskripsi">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-open-book-2"></i></span>
                        </div>
                    </div>
                    <div class="input-group custom">
                        <select name="status" class="form-control form-control-lg"
                            placeholder="Status">
                                <option value="1" {{ $p->status == "1" ? 'selected' : ''
                                    }}>Aktif</option>
                                <option value="0" {{ $p->status == "0" ? 'selected' : ''
                                    }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="input-group custom">
                        <input type="file" id="gambar-input" name="gambar"
                            class="form-control-file form-control height-auto">
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-image"></i></span>
                        </div>
                    </div>
                    <div id="gambar-preview"></div>
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

const gambarInput = document.getElementById('gambar-input');
  const gambarPreview = document.getElementById('gambar-preview');

  gambarInput.addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.addEventListener('load', function() {
        gambarPreview.innerHTML = `<img src="${this.result}" class="img-fluid mt-2" style="max-height: 200px;">`;
      });
      reader.readAsDataURL(file);
    }
  });
</script>



@endsection
