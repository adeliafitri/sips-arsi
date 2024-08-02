<table class="table table-bordered">
    <thead>
      <tr>
        <th style="width: 10px" rowspan="2" class="align-middle">No</th>
        <th style="width: 150px;" rowspan="2" class="align-middle">NIM</th>
        <th style="width: 200px;" rowspan="2" class="align-middle">Nama</th>
        @foreach ($info_soal as $data)
        {{-- @foreach ($data['bentuk_soal'] as $bentuk) --}}
            <th class="p-1">{{$data['bentuk_soal'] }}</th>
        {{-- @endforeach --}}
        @endforeach
      </tr>
      <tr>
        @foreach ($info_soal as $data)
            {{-- @foreach ($data['bobot_soal'] as $bobot) --}}
                <th class="p-1">{{$data['bobot_soal']}} %</th>
            {{-- @endforeach --}}
        @endforeach
        </tr>
    </thead>
    <tbody>
      @foreach ($mahasiswa_data as $key => $mhs)
      {{-- @foreach ($data['mahasiswa'] as $mahasiswa) --}}
        <tr>
            <td>{{ $mhs['nomor'] }}</td>
            <td>{{ $mhs['nim'] }}</td>
            <td>{{ $mhs['nama'] }}</td>
        </tr>
      {{-- @endforeach --}}
    @endforeach
    </tbody>
  </table>
