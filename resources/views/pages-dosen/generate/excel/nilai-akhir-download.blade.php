<table class="table table-bordered">
    <thead>
      <tr>
        <th style="width: 150px;" class="align-middle">Kode Matakuliah</th>
        <th>Kelas</th>
        <th style="width: 150px;" class="align-middle">NIM</th>
        <th>Quiz</th>
        <th>Prosentase Quiz</th>
        <th>Tugas</th>
        <th>Prosentase Tugas</th>
        <th>Praktikum</th>
        <th>Prosentase Praktikum</th>
        <th>UTS</th>
        <th>Prosentase UTS</th>
        <th>UAS</th>
        <th>Prosentase UAS</th>
        {{-- <th style="width: 200px;" class="align-middle">Nilai Akhir</th> --}}
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $key => $mhs)
      {{-- @foreach ($data['mahasiswa'] as $mahasiswa) --}}
        <tr>
            <td>{{ $mhs['kode_matkul'] }}</td>
            <td>{{ $mhs['kelas'] }}</td>
            <td>{{ $mhs['nim'] }}</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>{{ $mhs['nilai_akhir'] }}</td>
            <td>100</td>
            {{-- <td>{{ $mhs['nama'] }}</td> --}}
        </tr>
      {{-- @endforeach --}}
    @endforeach
    </tbody>
  </table>
