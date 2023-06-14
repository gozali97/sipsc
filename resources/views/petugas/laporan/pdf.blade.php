<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi Perpustakaan</title>
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
    <h2>Laporan Pengembalian Pustaka <br> Perpustakaan SMK N 1 Cangkringan</h2>
    <p>Periode Transaksi, Mulai : {{ \Carbon\Carbon::parse($start)->format('d-m-Y') }} Akhir :
        {{ \Carbon\Carbon::parse($end)->format('d-m-Y') }}</p>
        
    @php
       $jmlKembali = \App\Models\DetailPengembalian::query()
<<<<<<< HEAD
                        ->whereBetween('detail_pengembalian.tgl_kembali', [$start, $end])
                        ->count(); 
        $kembaliRusak = \App\Models\DetailPengembalian::query()
                        ->where('detail_pengembalian.kd_kondisi', '2')
                        ->whereBetween('detail_pengembalian.tgl_kembali', [$start, $end])
                        ->count(); 
        $kembaliBaik = \App\Models\DetailPengembalian::query()
                        ->where('detail_pengembalian.kd_kondisi', '1')
                        ->whereBetween('detail_pengembalian.tgl_kembali', [$start, $end])
                        ->count();        
        $totalDenda = \App\Models\DetailPengembalian::query()
                        ->where('detail_pengembalian.nominal_denda', '>', '0')
                        ->whereBetween('detail_pengembalian.tgl_kembali', [$start, $end])
=======
                        ->whereBetween('detail_pengembalian.created_at', [$start, $end])
                        ->count(); 
        $kembaliRusak = \App\Models\DetailPengembalian::query()
                        ->where('detail_pengembalian.kd_kondisi', '2')
                        ->whereBetween('detail_pengembalian.created_at', [$start, $end])
                        ->count(); 
        $kembaliBaik = \App\Models\DetailPengembalian::query()
                        ->where('detail_pengembalian.kd_kondisi', '1')
                        ->whereBetween('detail_pengembalian.created_at', [$start, $end])
                        ->count();        
        $totalDenda = \App\Models\DetailPengembalian::query()
                        ->where('detail_pengembalian.nominal_denda', '>', '0')
                        ->whereBetween('detail_pengembalian.created_at', [$start, $end])
>>>>>>> e80cd290ccfc698b1548b133fe56cd69a7cbba38
                        ->sum('nominal_denda');                      

                        @endphp
    <p>Jumlah Transaksi : {{ $jmlKembali }}</p>
    <p>Kondisi Rusak : {{ $kembaliRusak }}</p>
    <p>Kondisi Baik   : {{ $kembaliBaik }}</p>
    <p>Total Denda   : Rp.{{ number_format($totalDenda, 0, ',', '.') }}</p>
    
        
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Kelas</th>
                <th>Judul</th>
                <th>ISBN</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Kondisi</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @if ($data->isEmpty())
                <tr>
                    <td colspan="9" style="font-weight: bold; text-align: center;">Tidak ada data</td>
                </tr>
            @else
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->kelas }}</td>
                        <td>{{ $d->judul }}</td>
                        <td>{{ $d->isbn }}</td>
                        <td>{{ \Carbon\Carbon::parse($d->tgl_pinjam)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($d->tgl_kembali)->format('d-m-Y') }}</td>
                        <td>{{ $d->jenis_kondisi }}</td>
                        <td>Rp. {{ number_format($d->nominal_denda, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" class="footer">Yogyakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}
                <p></p>
                <p>Azka Petugas</p>
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
