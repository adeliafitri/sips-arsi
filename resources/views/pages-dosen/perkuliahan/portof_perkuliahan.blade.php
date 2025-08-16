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
    <td>{{ $kelas->rumpun_mk }}</td><td>{{ $kelas->sks }}</td><td>{{ $kelas->semester }}</td>
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
        </table>
    </td>
  </tr>

  <!-- Tambah baris lainnya -->
{{-- </table> --}}

  <tr class="section-title">
    <td>6. </td>
    <td colspan="3">Rubik Penilaian</td>
    {{-- <td class="center">100%</td> --}}
  </tr>
  <tr>
    <td></td>
    <td colspan="3">Terlampir</td>
    {{-- <td class="center">100%</td> --}}
  </tr>

<!-- Peserta Kuliah -->
{{-- <table class="bordered"> --}}
    <tr class="section-title">
        <td>7. </td>
        <td colspan="3">Peserta Kuliah</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            Mata kuliah ini merupakan mata kuliah wajib/pilihan di Program Studi Teknik Arsitektur UIN Malang. Pada tahun ajaran {{ $kelas->tahun_ajaran }} semester {{ $kelas->semester }} ini, mata kuliah {{ $kelas->nama_matkul }} kelas {{ $kelas->nama_kelas }} diikuti oleh sebanyak {{ $kelas->jumlah_mahasiswa }} mahasiswa
        </td>
    </tr>

    <tr class="section-title">
        <td>8. </td>
        <td colspan="3">Kehadiran</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            Kehadiran dosen sebesar {{ $kelas->kehadiran_dosen }}% dan kehadiran mahasiswa sebesar {{ $kelas->kehadiran_mahasiswa }}%. {{ $kelas->keterangan_kehadiran }}
        </td>
    </tr>

    <tr class="section-title">
        <td>9. </td>
        <td colspan="3">Pengamatan Kelas</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            {{ $kelas->pengamatan_kelas }}
        </td>
    </tr>

    <tr class="section-title">
        <td>10. </td>
        <td colspan="3">Hasil Pembelajaran</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            <div class="center">
                <img src="{{ $chartUrls[0] }}" alt="ChartTugas" class="center-image">
                <p><b>Gambar 1.</b> Diagram nilai hasil evaluasi mahasiswa</p>
            </div>
            <p>Gambar 1 menunjukkan rata-rata nilai mahasiswa di kelas berdasarkan jenis tugasnya.</p>
            <div class="chart-column">
                <div class="chart-item-left">
                    <img src="{{ $chartUrls[1] }}" alt="ChartSubcpmk">
                    <span class="center"><b>(a)</b></span>
                </div>
                <div class="chart-item-right">
                    <img src="{{ $chartUrls[2] }}" alt="ChartCpmk">
                    <span class="center"><b>(b)</b></span>
                </div>
            </div>
            <div class="clear"></div>
            <div class="center">
                <img src="{{ $chartUrls[3] }}" alt="ChartCpl" class="center-image">
                <p class="center"><b>(c)</b></p>
            </div>
            <p class="center"><b>Gambar 2.</b> Diagram rata-rata nilai mahasiswa berdasarkan (a) Sub-CPMK; (b) CPMK dan (c) CPL nya</p>
            <p>{{ $kelas->evaluasi }}</p>
        </td>
    </tr>

    <tr class="section-title">
        <td>11. </td>
        <td colspan="3">Nilai Akhir</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            Nilai akhir diperoleh dari pembobotan seluruh penilaian pada tabel 1. Rata-rata nilai akhir mahasiswa adalah {{ $avg_nilai_akhir }}. Mahasiswa dengan nilai akhir terendah sebesar {{ $min_nilai_akhir }} dan tertinggi sebesar {{ $max_nilai_akhir }}.
            Diagram 5 menunjukkan sebaran nilai huruf mahasiswa di kelas, dapat dilihat bahwa paling banyak mahasiswa memiliki nilai {{ $huruf_terbesar }} yaitu sebesar {{ $max_persentase }}% mahasiswa di kelas.
            <div class="center">
                <img src="{{ $barChartUrl }}" class="center-image" alt="Diagram Sebaran Nilai Akhir Huruf Mahasiswa">
                <p><b>Diagram 5.</b> Sebaran nilai akhir huruf mahasiswa</p>
            </div>
        </td>
    </tr>

    <tr class="section-title">
        <td>12. </td>
        <td colspan="3">Kesimpulan</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            {{ $kelas->kesimpulan }}
            {{-- <p>Kesimpulan
            {{-- <p>Penjelasan lainnya</p> --}}
        </td>
    </tr>

    <tr class="section-title">
        <td>13. </td>
        <td colspan="3">Rencana Perbaikan</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3">
            {{ $kelas->rencana_perbaikan }}
        </td>
    </tr>
</table>

@php
    $rubrik = [
        [
            'no' => 1,
            'aspek' => 'Progress Asistensi',
            'skor' => [
                'Tanda tangan progres 11-14x, asistensi 7-10x, dan validasi',
                'Tanda tangan progres 7-10x, asistensi 4-6x dan validasi',
                'Tanda tangan progres 2-6x, asistensi 2-3x dan validasi',
                'Ada ttd progres 1x, asistensi 1x dan validasi',
                'Ada ttd progres 1x, tidak ada ttd asistensi dan validasi',
                'Tidak ada ttd progres, asistensi dan validasi',
            ]
        ],
        [
            'no' => 2,
            'aspek' => 'Logbook',
            'skor' => [
                'Hasil kerja mahasiswa terorganisasi dengan lengkap, rapi, menarik dan inovatif...',
                'Hasil kerja mahasiswa terorganisasi dengan baik...',
                'Hasil kerja mahasiswa cukup... dengan finishing sederhana',
                'Hasil kerja mahasiswa kurang... dengan finishing sederhana',
                'Hasil kerja mahasiswa tidak lengkap... tanpa finishing',
                'Mahasiswa tidak mengerjakan dan tidak mengumpulkan tugas',
            ]
        ],
        [
            'no' => 3,
            'aspek' => 'Sketsa Arsitektur',
            'skor' => [
                'Sketsa sangat ekspresif, proporsional, detail, dan komunikatif...',
                'Sketsa ekspresif dan proporsional, cukup komunikatif',
                'Sketsa cukup baik, masih ada kekurangan proporsi/detail',
                'Sketsa kurang proporsional dan kurang komunikatif',
                'Sketsa tidak sesuai objek dan tidak proporsional',
                'Tidak membuat atau mengumpulkan sketsa',
            ]
        ],
        [
            'no' => 4,
            'aspek' => 'Analisis Tapak',
            'skor' => [
                'Analisis sangat lengkap: iklim, akses, topografi, sirkulasi, sosial, dll; disajikan visual dan tekstual dengan baik',
                'Analisis lengkap dan cukup visual',
                'Analisis cukup lengkap namun kurang visualisasi atau kedalaman',
                'Analisis kurang lengkap dan minim visualisasi',
                'Analisis dangkal dan tidak relevan',
                'Tidak mengerjakan analisis tapak',
            ]
        ],
        [
            'no' => 5,
            'aspek' => 'Studi Preseden',
            'skor' => [
                'Kajian preseden sangat relevan, kritis, dan terhubung kuat dengan desain; Kajian disusun secara runut',
                'Kajian cukup relevan dan terhubung dengan desain',
                'Kajian relevan namun kurang mendalam',
                'Kajian kurang relevan dan kurang dalam',
                'Kajian dangkal dan tidak sesuai topik',
                'Tidak mengerjakan studi preseden',
            ]
        ],
        [
            'no' => 6,
            'aspek' => 'Project Desain',
            'skor' => [
                'Sangat lengkap & detail, desain dan finishing sangat menarik dan inovatif; sangat mampu memahami, menjelaskan isu, proses, dan relevansi desain',
                'Lengkap & detail, desain dan finishing menarik dan inovatif; mampu memahami dan menjelaskan isu, proses, dan relevansi desain',
                'Cukup lengkap & detail, desain menarik; cukup mampu menjelaskan isu, proses, dan relevansi desain',
                'Kurang lengkap & detail, desain kurang menarik; kurang mampu menjelaskan isu, proses, dan relevansi desain',
                'Tidak lengkap/detail, desain tidak menarik; tidak mampu menjelaskan isu, proses, dan relevansi desain',
                'Tidak dikerjakan/tidak dikumpulkan',
            ]
        ],
        [
            'no' => 7,
            'aspek' => 'Gambar Arsitektural',
            'skor' => [
                'Gambar arsitektural sangat ekspresif, proporsional, representatif terhadap konsep, dengan penguasaan teknik presentasi visual tinggi (baik manual maupun digital)',
                'Gambar arsitektural proporsional, ekspresif dan komunikatif, dengan teknik yang baik',
                'Gambar cukup komunikatif dan representatif terhadap desain namun kurang konsisten secara teknis',
                'Gambar kurang jelas, komposisi atau teknik penyajian lemah',
                'Gambar tidak proporsional, dan tidak merepresentasikan desain dengan baik',
                'Tidak menggambar atau hasil tidak sesuai dengan standar minimum tugas',
            ]
        ],
        [
            'no' => 8,
            'aspek' => 'Gambar Kerja',
            'skor' => [
                'Gambar kerja sangat lengkap, akurat, jelas, mengikuti standar grafis arsitektur (garis, notasi, dimensi, material), dan dapat dipahami oleh pelaksana lapangan',
                'Gambar kerja lengkap, cukup akurat dan mengikuti standar grafis dengan baik',
                'Gambar kerja cukup lengkap, terdapat kekurangan minor pada notasi atau detail',
                'Gambar kerja kurang lengkap dan kurang mengikuti kaidah grafis teknis',
                'Gambar kerja tidak lengkap dan membingungkan secara teknis',
                'Tidak mengerjakan atau tidak layak digunakan sebagai dokumen teknis',
            ]
        ],
        [
            'no' => 9,
            'aspek' => 'Architectural Presentation Board',
            'skor' => [
                'Hasil kerja mahasiswa sangat lengkap dan detail serta penataan layouting dan finishing yang menarik; Mahasiswa mampu mengkomunikasikan perancangan ke dalam format APREB',
                'Hasil kerja mahasiswa lengkap serta penataan layouting dan finishing yang menarik; Mahasiswa mampu mengkomunikasikan tugas perancangan ke dalam format APREB',
                'Hasil kerja mahasiswa cukup dalam penataan layouting dan finishing sederhana; Mahasiswa cukup mampu mengkomunikasikan tugas perancangan ke dalam format APREB',
                'Hasil kerja mahasiswa kurang dalam penataan layouting dan finishing sederhana; Mahasiswa kurang mampu dalam mengkomunikasikan tugas perancangan ke dalam format APREB',
                'Hasil kerja mahasiswa tidak lengkap dalam penataan layouting dan finishing: Mahasiswa tidak mampu mengkomunikasikan perancangan ke dalam format APREB',
                'Mahasiswa tidak mengerjakan APREB; Mahasiswa tidak mampu mengkomunikasikan tugas perancangan ke dalam format APREB',
            ]
        ],
        [
            'no' => 10,
            'aspek' => 'Maket',
            'skor' => [
                'Hasil kerja mahasiswa sangat lengkap, benar, rapi, dan detail serta finishing yang menarik; Mahasiswa mampu mempresentasikan rancangan dalam bentuk maket 3 dimensi',
                'Hasil kerja mahasiswa lengkap, benar, dan detail serta finishing yang menarik; Mahasiswa mampu mempresentasikan rancangan dalam bentuk maket 3 dimensi',
                'Hasil kerja mahasiswa cukup lengkap, benar, dan detail serta finishing sederhana; Mahasiswa cukup mampu mempresentasikan rancangan dalam bentuk maket 3 dimensi',
                'Hasil kerja mahasiswa kurang lengkap, benar, dan detail; Mahasiswa kurang mampu mempresentasikan rancangan dalam bentuk maket 3 dimensi',
                'Hasil kerja mahasiswa tidak lengkap dan detail, tidak sesuai dengan ketentuan-ketentuan tugas; mahasiswa tidak mampu mempresentasikan rancangan dalam bentuk maket 3 dimensi',
                'Tidak mengumpulkan maket',
            ]
        ],
        [
            'no' => 11,
            'aspek' => 'Kuis',
            'skor' => [
                'Mahasiswa menjawab minimal 85% pertanyaan dengan benar',
                'Mahasiswa menjawab 75-84% pertanyaan dengan benar',
                'Mahasiswa menjawab 70-74% pertanyaan dengan benar',
                'Mahasiswa menjawab 65-69% pertanyaan dengan benar',
                'Mahasiswa menjawab 60-64% pertanyaan dengan benar',
                'Mahasiswa menjawab pertanyaan dengan benar dibawah 60% atau tidak jujur',
            ]
        ],
        [
            'no' => 12,
            'aspek' => 'Analisis',
            'skor' => [
                'Analisis sangat tajam, kritis, logis, dan berbasis data',
                'Analisis cukup tajam dan logis, berbasis data',
                'Analisis cukup logis namun terbatas',
                'Analisis kurang mendalam dan lemah logika',
                'Analisis tidak relevan atau tidak logis',
                'Tidak melakukan analisis',
            ]
        ],
        [
            'no' => 13,
            'aspek' => 'Karya Tulis',
            'skor' => [
                'Tulisan sangat sistematis, kritis, dan akademik; referensi relevan & banyak',
                'Tulisan sistematis, cukup kritis; referensi relevan',
                'Tulisan cukup sistematis; referensi terbatas',
                'Tulisan kurang runtut; referensi tidak relevan',
                'Tulisan tidak sistematis; tidak menyertakan referensi',
                'Tidak mengumpulkan karya tulis',
            ]
        ],
        [
            'no' => 14,
            'aspek' => 'Presentasi',
            'skor' => [
                'Sangat percaya diri, Komunikasi verbal sangat jelas dan runtut, didukung media yang baik, mampu menjawab pertanyaan dengan kritis',
                'Percaya diri, Komunikasi cukup jelas dan logis, mampu menjawab pertanyaan umum',
                'Cukup percaya diri, Penjelasan cukup namun tidak meyakinkan',
                'Kurang percaya diri, penjelasan terbatas dan tidak runtut',
                'Tidak siap, banyak kekeliruan, tidak runut, tidak komunikatif',
                'Tidak melakukan presentasi',
            ]
        ],
    ];
@endphp

<p>Lampiran 1. Rubrik Deskripsi Penilaian Mahasiswa</p>
<table class="bordered" style="font-size: 8pt; font-family: 'DejaVu Serif', serif;">
    <tr>
        <th rowspan="3" style="width: 5%;">No</th>
        <th rowspan="3">Jenis Tugas</th>
        <th colspan="6">SKALA</th>
    </tr>
    <tr>
        <th>Sangat Baik</th>
        <th>Baik</th>
        <th>Cukup</th>
        <th>Kurang</th>
        <th>Sangat Kurang</th>
        <th>Perlu diulang</th>
    </tr>
    <tr>
        <td>A (Skor &ge; 85)</td>
        <td>B+ (75-84)</td>
        <td>B (70-74)</td>
        <td>C+ (65-69)</td>
        <td>C (60-64)</td>
        <td>D (&le; 59) / E</td>
    </tr>
    @foreach($rubrik as $item)
    <tr>
        <td>{{ $item['no'] }}.</td>
        <td>{{ $item['aspek'] }}</td>
        @foreach($item['skor'] as $nilai)
            <td>{{ $nilai }}</td>
        @endforeach
    </tr>
    @endforeach
</table>

<p>Lampiran 2: Mingguan perkuliahan</p>
<p></p>

{{-- <p>Lampiran 3: Nilai mahasiswa</p> --}}
{{-- <table id="" class="bordered">
        <thead>
          <tr>
            <th class="no-column" rowspan="3" width="5%">No</th>
            <th rowspan="3" class="no-column">NIM</th>
            <th rowspan="3" class="no-column nama-column">Nama</th>
            @foreach ($info_soal as $data) --}}
            {{-- @foreach ($data['waktu_pelaksanaan'] as $waktu) --}}
                {{-- <th class="info-soal">{{$data['waktu_pelaksanaan']}}</th> --}}
            {{-- @endforeach --}}
            {{-- @endforeach
            <th rowspan="3" class="no-column">Nilai Akhir</th>
            <th rowspan="3" class="no-column">Huruf</th>
            <th rowspan="3" class="no-column">Keterangan</th>
          </tr>
          <tr>
              @foreach ($info_soal as $data) --}}
                  {{-- @foreach ($data['kode_subcpmk'] as $kode) --}}
                      {{-- <th class="info-soal">{{ implode(', ', $data['kode_subcpmk']) }}</th> --}}
                  {{-- @endforeach --}}
              {{-- @endforeach
          </tr> --}}
          {{-- <tr>
              @foreach ($info_soal as $data) --}}
                  {{-- @foreach ($data['bobot_soal'] as $bobot) --}}
                      {{-- <th class="info-soal">{{$data['bobot_soal']}} %</th> --}}
                  {{-- @endforeach --}}
              {{-- @endforeach
          </tr> --}}
          {{-- <tr>
              @foreach ($info_soal as $data) --}}
                  {{-- @foreach ($data['bentuk_soal'] as $bentuk) --}}
                      {{-- <th class="info-soal">{{$data['bentuk_soal'] }}</th> --}}
                  {{-- @endforeach --}}
              {{-- @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($mahasiswa_data as $key => $mhs) --}}
          {{-- @foreach ($data['mahasiswa'] as $mahasiswa) --}}
            {{-- <tr>
                <td class="no-column">{{ $mhs['nomor'] }}</td>
                <td class="no-column">{{ $mhs['nim'] }}</td>
                <td class="no-column nama-column">{{ $mhs['nama'] }}</td> --}}
                  {{-- @foreach ($mhs['id_nilai'] as $id_nilai) --}}
                  {{-- @foreach($mhs['nilai'] as $key => $nilai)
                  <td class="info-soal">
                      <div id="nilai-tugas-{{ $mhs['id_nilai'][$key] }}"> --}}
                          {{-- @php
                              $nilai =  $mhs['nilai'][$loop->index];
                          @endphp --}}
                          {{-- {{ $nilai }} --}}
                          {{-- <i class="nav-icon fas fa-edit" onclick="editNilaiTugas({{ $id_nilai }})" style="cursor: pointer"></i> --}}
                      {{-- </div>
                  </td>
                  @endforeach
                <td class="no-column">{{ $mhs['nilai_akhir'] ?? '-' }}</td>
                <td class="no-column">{{ $mhs['nilai_huruf'] ?? '-' }}</td>
                <td class="no-column">{{ $mhs['keterangan'] ?? '-' }}</td>
            </tr> --}}
          {{-- @endforeach --}}
        {{-- @endforeach
        </tbody>
    </table> --}}

<!-- Tambah bagian lain dengan pola yang sama -->

</body>
</html>
