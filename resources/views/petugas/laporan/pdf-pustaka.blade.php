<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Pustaka</title>
    <style>
            body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        thead th {
            background-color: #f2f2f2;
        }

        tfoot td {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
   
   <div>
    <h2>Laporan Data Pustaka <br> Perpustakaan SMK N 1 Cangkringan</h2>
    </div>

    @php
    $total = 0;
        $jmlDipinjam = \App\Models\Peminjaman::query()
                        ->where('peminjaman.jumlah', '>', '0')
                        ->sum('jumlah'); 
        $jmlPustaka = \App\Models\Pustaka::query()
                        ->where('pustakas.jumlah', '>', '0')
                     ->sum('jumlah');                   

        $total = $jmlDipinjam + $jmlPustaka;
                        @endphp
    <p>Jumlah Dipinjam : {{ $jmlDipinjam }}</p>
    <p>Stok Pustaka : {{ $jmlPustaka }}</p>
    <p>Jumlah Dimiliki : {{ $total }}</p>

    <table style="width:100%; border-collapse: collapse; border: 1px solid black;">
        <thead>
            <tr style="border: 1px solid black;">
                <th style="border: 1px solid black; padding: 5px;">No</th>
                <th style="border: 1px solid black; padding: 5px;">Nama Pustaka</th>
                <th style="border: 1px solid black; padding: 5px;">Kategori</th>
                <th style="border: 1px solid black; padding: 5px;">Pengarang</th>
                <th style="border: 1px solid black; padding: 5px;">Penerbit</th>
                <th style="border: 1px solid black; padding: 5px;">Tahun Terbit</th>
                <th style="border: 1px solid black; padding: 5px;">Stok</th>
                <th style="border: 1px solid black; padding: 5px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data as $d)
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black; padding: 5px;">{{ $no++ }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->judul }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->kategori }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->nama_pengarang }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->nama_penerbit }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->tahun_terbit }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->jumlah }}</td>
                    <td style="border: 1px solid black; padding: 5px;">
                                @php
                                    if($d->status == "1"){
                                        $status = "Aktif";
                                    }
                                    elseif($d->status == "0"){
                                        $status = "Tidak Aktif";
                                    }
                                    else{
                                        $status = "Tidak Aktif";
                                    }
                                @endphp    
                                <p> {{$status }} </p>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" class="footer">Yogyakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}   
                <p></p>
                <p>Azka Petugas</p>
<<<<<<< HEAD
                
=======
>>>>>>> e80cd290ccfc698b1548b133fe56cd69a7cbba38
                </td>
                
            </tr>
        </tfoot>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.7.0/jspdf.umd.min.js"></script>
    <script>
        // Function to generate PDF
        function generatePDF() {
            // Create a new jsPDF instance
            var doc = new jsPDF();

            // Get the HTML content of the table
            var html = document.querySelector('table').outerHTML;

            // Generate the PDF
            doc.fromHTML(html, 15, 15, {
                'width': 170
            });

            // Save the PDF
            doc.save('laporan.pdf');
        }
    </script>
</body>

</html>
