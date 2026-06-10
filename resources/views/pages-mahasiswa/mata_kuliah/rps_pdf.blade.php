{{-- <!DOCTYPE html>
<html>
<head>
    <title>Portfolio Penilaian</title>
    <style>
        /* Atur border untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Portfolio Penilaian</h1>
    <table class="table table-bordered">
        <tr>
            <th>Kode Mata Kuliah</th>
            <td>{{ $matkul->kode_matkul }}</td>
        </tr>
        <tr>
            <th>Nama Mata Kuliah</th>
            <td>{{ $matkul->nama_matkul }}</td>
        </tr>
        <tr>
            <th>SKS</th>
            <td>{{ $matkul->sks }}</td>
        </tr>
        <tr>
            <th>Semester</th>
            <td>{{ $matkul->semester }}</td>
        </tr>
        <tr>
            <th>Tahun RPS</th>
            <td>{{ $matkul->tahun_rps }}</td>
        </tr>
    </table>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Minggu</th>
                <th>CPL</th>
                <th>CPMK</th>
                <th>Sub-CPMK</th>
                <th>Bentuk Soal</th>
                <th>Jenis Tugas</th>
                <th>Bobot Sub-CPMK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rps as $data)
                <tr>
                    <td>{{ $data->waktu_pelaksanaan }}</td>
                    <td>{{ $data->kode_cpl }}</td>
                    <td>{{ $data->kode_cpmk }}</td>
                    <td>{{ $data->kode_subcpmk }}</td>
                    <td>{{ $data->bentuk_soal }}</td>
                    <td>{{ $data->jenis_tugas ?? 'Tidak Ada' }}</td>
                    <td>{{ $data->bobot_soal }}%</td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="6">Total Bobot</td>
                    <td>{{ $total_bobot }}%</td>
                </tr>
        </tbody>
    </table>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Portofolio Perkuliahan</title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      /* font-family: Arial, sans-serif; */
      font-size: 10pt;
      margin: 0;
      padding: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      margin-bottom: 10px;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }

    td, th {
      padding: 5px;
      vertical-align: top;
    }

    .bordered td, .bordered th {
      border: 1px solid #000;
    }

    .center {
      text-align: center;
    }

    .section-title {
      font-weight: bold;
      background: #f0f0f0;
    }

    img.logo {
      width: 80px;
    }

    .indent {
      text-indent: 30px;
    }
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }
    .info-soal {
        table-layout: fixed;
        font-size: 8pt;
        max-width: 20px;
            /* text-decoration: capitalize; Menetapkan lebar tetap untuk kolom info soal */
    }
    .no-column{
            font-size: 8pt;
    }
    .nama-column{
        width: 12%;
    }
    .chart-column {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .chart-item-left{
        width: 45%;
        margin-bottom: 20px;
        /* background-color: #f0f0f0; */
        padding: 10px;
        /* border: 1px solid #ccc; */
        text-align: center;
        float: left;
        /* height:300px; */
    }

    .chart-item-right{
        width: 45%;
        margin-bottom: 20px;
        /* background-color: #f0f0f0; */
        padding: 10px;
        /* border: 1px solid #ccc; */
        text-align: center;
        float: right;
        /* height:300px; */
    }

    .chart-item-left img {
        max-width: 100%;
    }

    .chart-item-right img {
        max-width: 100%;
    }

    .clear {
        clear: both;
    }

    .center-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
        max-width: 50%;
        align: center;
    }
    .kosong {
        border-top: none !important;
        border-bottom: none !important;
        background: transparent !important;
    }
  </style>
</head>
<body>

<table class="center">
  <tr>
    <td style="width: 15%;vertical-align: middle;">
            @php
                // phpinfo();
                $imagePath = public_path('dist/img/logo_uin.png');
                $imageData = base64_encode(file_get_contents($imagePath));
                $src = 'data:image/png;base64,' . $imageData;
            @endphp

            <img src="{{ $src }}" width="100px" alt="logo UIN Malang">
    </td>
    <td class="center" style="width: 85%;font-size: 11pt;vertical-align: middle;"">
        UNIVERSITAS ISLAM NEGERI MAULANA MALIK IBRAHIM
        <br>
        FAKULTAS SAINS DAN TEKNOLOGI
        <br>
        <strong style="font-size: 14pt">PROGRAM STUDI TEKNIK ARSITEKTUR</strong>
    </td>
  </tr>
</table>

{{-- <table>
  <tr><td class="center" colspan="2"><h2>PORTOFOLIO PERKULIAHAN</h2></td></tr>
</table> --}}

<!-- Informasi MK -->
<table class="bordered">
  <tr class="section-title">
    <td colspan="5" class="center" style="font-size: 12pt">Portofolio Perkuliahan</td>
  </tr>
  <tr class="section-title">
    <td>Mata Kuliah</td><td>Kode</td>
    <td>Rumpun MK</td><td>Bobot SKS</td>
    <td>Semester</td>
  </tr>
  <tr>
    <td>{{ $kelas->nama_matkul }}</td><td>{{ $kelas->kode_matkul }}</td>
    <td>{{ $kelas->rumpun_mk }}</td><td>{{ $kelas->sks }}</td><td style="text-transform: capitalize;">{{ $kelas->semester }}</td>
  </tr>
  <tr class="section-title">
    <td>Tahun Ajaran</td><td>Koordinator MK</td>
    <td colspan="2">Dosen Pengampu</td><td>Kelas</td>
  </tr>
  <tr>
    <td>{{ $kelas->tahun_ajaran }}</td><td>{{ $koordinator }}</td>
    <td colspan="2">{{ $kelas->nama_dosen }}</td><td>{{ $kelas->nama_kelas }}</td>
  </tr>
</table>

<!-- Tujuan -->
<table class="bordered">
    <tr class="section-title">
        <td style="width: 5%;">1. </td>
        <td colspan="3">Tujuan</td>
    </tr>
    <tr style="page-break-inside: avoid;">
        <td class="kosong"></td>
        {{-- <td rowspan="{{ $rowspan }}"></td> --}}
        <td colspan="3">
            Capaian CPL
            <br>
            Mata kuliah ini diajarkan untuk mendukung Capaian Pembelajaran Program Studi (CPL) berikut:
        </td>
    </tr>
    <!-- foreach tr cpl -->
    @foreach($cpl as $dataCpl)
    <tr>
        <td class="kosong"></td>
        <td style="width: 10%;">{{ $dataCpl->kode_cpl }}</td>
        <td colspan="2">{{ $dataCpl->deskripsi }}</td>
    </tr>
    @endforeach

    <tr>
        <td class="kosong"></td>
        <td colspan="3">
            Capaian CPMK
            <br>
            Secara khusus, mata kuliah ini diajarkan agar mahasiswa dapat menguasai Capaian Pembelajaran Mata Kuliah CPMK Sains Bangunan. Masing-masing CPMK memberikan dukungan terhadap CPL.
        </td>
    </tr>
    <!-- foreach tr cpmk -->
    @foreach($cpmk as $dataCpmk)
    <tr>
        <td class="kosong"></td>
        <td style="width: 10%;">
            {{ $dataCpmk->kode_cpmk }}
        </td>
        <td colspan="2">{{ $dataCpmk->deskripsi }} ({{ $dataCpmk->kode_cpl }})</td>
    </tr>
    @endforeach
    <tr>
        <td class="kosong"></td>
        <td colspan="3">
            Capaian Sub-CPMK
            <br>
            Masing-masing Sub-CPMK memberikan dukungan terhadap CPMK.
        </td>
    </tr>
    <!-- foreach tr sub-cpmk -->
    @foreach($subcpmk as $dataSubCpmk)
    <tr>
        <td class="kosong"></td>
        <td style="width: 10%;">
            {{ $dataSubCpmk->kode_cpl }}
        </td>
        <td style="width: 10%;">{{ $dataSubCpmk->kode_cpmk }}</td>
        <td>{{ $dataSubCpmk->kode_subcpmk }}: {{ $dataSubCpmk->deskripsi }}</td>
    </tr>
    @endforeach
{{-- </table> --}}

<!-- Deskripsi Mata Kuliah -->
{{-- <table class="bordered"> --}}
    <tr class="section-title">
        <td>2. </td>
        <td colspan="3">Deskripsi Mata Kuliah</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            {!! $kelas->deskripsi_mk !!}
            {{-- <p class="indent">Mata kuliah ini membahas tentang iklim, karakteristiknya, dan pengaruhnya terhadap desain arsitektur. Mata kuliah ini juga membahas tentang lingkungan penghawaan.</p> --}}
        </td>
    </tr>
{{-- </table> --}}

    <tr class="section-title">
        <td>4. </td>
        <td colspan="3">Bahan Kajian/Materi Pembelajaran</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            {!! $kelas->bahan_kajian !!}
            {{-- <p class="indent">Iklim, karakteristiknya, dan pengaruhnya terhadap desain arsitektur</p>
            {{-- <ol>
                <li>Iklim, karakteristiknya, dan pengaruhnya terhadap desain arsitektur</li>
                <li>Lingkungan Penghawaan</li>
            </ol> --}}
        </td>
    </tr>

<!-- Pustaka -->
{{-- <table class="bordered"> --}}
    <tr class="section-title">
        <td>4. </td>
        <td colspan="3">Pustaka</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            {!! $kelas->pustaka !!}
            {{-- <ol>
                <li>Olgyay, Victor, dkk. (2015)...</li>
                <li>Givoni, Baruch. (1998)...</li>
            </ol> --}}
        </td>
    </tr>
{{-- </table> --}}

<!-- Sistem Evaluasi -->
{{-- <table class="bordered"> --}}
  <tr class="section-title">
    <td>5. </td>
    <td colspan="3">Sistem Evaluasi</td></tr>
  <tr>
    <td></td>
    <td colspan="3">
        {{-- <p> --}}
            Setiap jenis evaluasi yang dilakukan kepada mahasiswa memberikan dukungan terhadap Sub-CPMK. Tabel 1 menjelaskan jenis evaluasi pada mata kuliah ini, beserta matriks hubungan antara bobot penilaian tugas dan hubungannya dengan CPL, CPMK dan Sub-CPMK yang didukung:
        {{-- </p> --}}
        <p style="text-align: center;"><b>Tabel 1.</b> Matriks hubungan dan pembobotan antara CPL, CPMK, Sub-CPMK dan Penugasan di Mata Kuliah</p>
        <table>
            <tr>
                <th>CPL</th>
                <th>CPMK</th>
                <th>Sub-CPMK</th>
                <th>Evaluasi</th>
                <th>Bobot</th>
            </tr>
            @foreach ($tugas as $itemTugas)
            <tr>
                <td>{{ $itemTugas['kode_cpl'] }}</td>
                <td>{{ $itemTugas['kode_cpmk'] }}</td>
                <td>{{ $itemTugas['kode_subcpmk'] }}</td>
                <td>{{ $itemTugas['bentuk_soal'] . '-' . $itemTugas['jenis_tugas']}}</td>
                <td>{{ $itemTugas['bobot_soal'] }}%</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4">Total Bobot</td>
                <td>{{ $total_bobot }}%</td>
            </tr>
        </table>
    </td>
  </tr>

  <!-- Tambah baris lainnya -->
</table>
</body>
</html>
