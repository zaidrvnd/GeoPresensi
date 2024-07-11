@php
     function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Laporan Presensi</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
    @page { 
        size: A4 
        }

    #title{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-weight: bold;
    }

    .tabeldatakaryawan{
        margin-top: 40px;
    }

    .tabeldatakaryawan tr td{
        padding: 5px;
    }

    .tabelpresensi{
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .tabelpresensi tr th {
        border:2px solid #131212;
        padding: 8px;
        background-color: #c8c4c4;
    }

    .tabelpresensi tr td {
        border:2px solid #131212;
        padding: 5px;
        font-size: 14px;
    }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <table style="width: 100%" >
        <tr>
            <td style="width: 30px">
                <img src="{{ asset('assets/img/logopresensi.png') }}" width="70" height="70" alt="">
            </td>
            <td>
                <span id="title">
                    LAPORAN PRESENSI KARYAWAN <br>
                    PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                    GEOPRESENSI <br>
                </span>
                <span><i>Jln. Moh Kahfi 2 No 43 , Kecamatan Jagakarsa, Kabupaten Jakarta selatan</i></span>
            </td>
        </tr>
    </table>
    <table class="tabeldatakaryawan">
        <tr>
            <td rowspan="6">
                @php
                    $path = Storage::url('upload/karyawan/'.$karyawan->foto);
                @endphp
                <img src="{{ url($path) }}" alt="" width="120" height="150">
            </td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $karyawan->nik }}</td>
        </tr>
        <tr>
            <td>Nama Karyawan</td>
            <td>:</td>
            <td>{{ $karyawan->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $karyawan->jabatan }}</td>
        </tr>
        <tr>
            <td>Departemen</td>
            <td>:</td>
            <td>{{ $karyawan->nama_dept }}</td>
        </tr>
        <tr>
            <td>No. Telpon</td>
            <td>:</td>
            <td>{{ $karyawan->no_hp }}</td>
        </tr>
    </table>
    <table class="tabelpresensi" >
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Keterangan</th>
            <th>Jam Kerja</th>
        </tr>
        @foreach ($presensi as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</td>
            <td>{{ $d->jam_in }}</td>
            <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
            <td>
                @if ($d->jam_in >= '07:00')
                <span class="badge bg-danger">Terlambat!</span>
                @else
                '<span class="badge bg-success">Tepat Waktu!</span>
                @endif
            </td>
            <td>
                @if ($d->jam_out != null)
                    @php
                        $jamkerja = selisih($d->jam_in,$d->jam_out);
                        if ($d->jam_in >= "07:15") {
                            $jamkerja = 0;
                        }
                        
                    @endphp
                @else
                    @php
                        $jamkerja = 0;
                    @endphp
                @endif
                {{ $jamkerja }}
            </td>
        </tr>
            
        @endforeach
    </table>

  </section>

</body>

</html>