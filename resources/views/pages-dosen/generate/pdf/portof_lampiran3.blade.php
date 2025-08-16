
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
<p>Lampiran 3: Nilai mahasiswa</p>
<table id="" class="bordered">
        <thead>
          <tr>
            <th class="no-column" rowspan="3" width="5%">No</th>
            <th rowspan="3" class="no-column">NIM</th>
            <th rowspan="3" class="no-column nama-column">Nama</th>
            @foreach ($info_soal as $data)
            {{-- @foreach ($data['waktu_pelaksanaan'] as $waktu) --}}
                <th class="info-soal">{{$data['waktu_pelaksanaan']}}</th>
            {{-- @endforeach --}}
            @endforeach
            <th rowspan="3" class="no-column">Nilai Akhir</th>
            <th rowspan="3" class="no-column">Huruf</th>
            <th rowspan="3" class="no-column">Keterangan</th>
          </tr>
          <tr>
              @foreach ($info_soal as $data)
                  {{-- @foreach ($data['kode_subcpmk'] as $kode) --}}
                      <th class="info-soal">{{ implode(', ', $data['kode_subcpmk']) }}</th>
                  {{-- @endforeach --}}
              @endforeach
          </tr>
          {{-- <tr>
              @foreach ($info_soal as $data) --}}
                  {{-- @foreach ($data['bobot_soal'] as $bobot) --}}
                      {{-- <th class="info-soal">{{$data['bobot_soal']}} %</th> --}}
                  {{-- @endforeach --}}
              {{-- @endforeach
          </tr> --}}
          <tr>
              @foreach ($info_soal as $data)
                  {{-- @foreach ($data['bentuk_soal'] as $bentuk) --}}
                      <th class="info-soal">{{$data['bentuk_soal'] }}</th>
                  {{-- @endforeach --}}
              @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($mahasiswa_data as $key => $mhs)
          {{-- @foreach ($data['mahasiswa'] as $mahasiswa) --}}
            <tr>
                <td class="no-column">{{ $mhs['nomor'] }}</td>
                <td class="no-column">{{ $mhs['nim'] }}</td>
                <td class="no-column nama-column">{{ $mhs['nama'] }}</td>
                  {{-- @foreach ($mhs['id_nilai'] as $id_nilai) --}}
                  @foreach($mhs['nilai'] as $key => $nilai)
                  <td class="info-soal">
                      <div id="nilai-tugas-{{ $mhs['id_nilai'][$key] }}">
                          {{-- @php
                              $nilai =  $mhs['nilai'][$loop->index];
                          @endphp --}}
                          {{ $nilai }}
                          {{-- <i class="nav-icon fas fa-edit" onclick="editNilaiTugas({{ $id_nilai }})" style="cursor: pointer"></i> --}}
                      </div>
                  </td>
                  @endforeach
                <td class="no-column">{{ $mhs['nilai_akhir'] ?? '-' }}</td>
                <td class="no-column">{{ $mhs['nilai_huruf'] ?? '-' }}</td>
                <td class="no-column">{{ $mhs['keterangan'] ?? '-' }}</td>
            </tr>
          {{-- @endforeach --}}
        @endforeach
        </tbody>
    </table>

    <p>Lampiran 4: Absen</p>
</body>
</html>
