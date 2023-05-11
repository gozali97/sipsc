<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi Perpustakaan</title>
</head>

<body>
    <h1 style="text-align: center;">Laporan peminjaman yang belum dikembalikan namun sudah terlambat</h1>

    <table style="width:100%; border-collapse: collapse; border: 1px solid black;">
        <thead>
            <tr style="border: 1px solid black;">
                <th style="border: 1px solid black; padding: 5px;">No</th>
                <th style="border: 1px solid black; padding: 5px;">Nama Anggota</th>
                <th style="border: 1px solid black; padding: 5px;">Kelas</th>
                <th style="border: 1px solid black; padding: 5px;">Judul</th>
                <th style="border: 1px solid black; padding: 5px;">Tanggal Pinjam</th>
                <th style="border: 1px solid black; padding: 5px;">Jumlah Terlambat</th>
                <th style="border: 1px solid black; padding: 5px;">Denda</th>
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
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->nama }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->kelas }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->judul }}</td>
                    <td style="border: 1px solid black; padding: 5px;">
                        {{ \Carbon\Carbon::parse($d->tgl_pinjam)->format('d-m-Y') }}</td>
                    <td style="border: 1px solid black; padding: 5px;">{{ $d->jumlah_hari_terlambat }}</td>
                    <td style="border: 1px solid black; padding: 5px;">Rp.
                        {{ number_format($d->nominal_denda, 0, ',', '.') }}</td>

                    <td style="border: 1px solid black; padding: 5px;">{{ $d->status }}</td>
                </tr>
            @endforeach
        </tbody>
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
