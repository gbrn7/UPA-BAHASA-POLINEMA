<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Toeic Register</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      font-family: arial, sans-serif;
    }

    td,
    th {
      padding: 8px;
      text-align: left;
    }

    td {
      border: 1px solid #999999dd;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }

    thead {
      background-color: rgb(0, 0, 0);
      color: white;
    }
  </style>
</head>

<body>
  <div class="title-wrapper">
    @isset($title)
    <h3 style="text-align: center">{{$title}}</h3>
    @endisset
  </div>
  <table>
    <thead>
      <tr>
        <th><strong>No</strong></th>
        <th><strong>Nama Lengkap</strong></th>
        <th><strong>NIM</strong></th>
        <th><strong>NIK</strong></th>
        <th><strong>Jurusan</strong></th>
        <th><strong>Program Studi</strong></th>
        <th><strong>Semester</strong></th>
        <th><strong>Email</strong></th>
        <th><strong>NO. Wa</strong></th>
        <th><strong>Tanggal Daftar</strong></th>
        <th><strong>Foto KTP</strong></th>
        <th><strong>Foto KTM</strong></th>
        <th><strong>Surat Pernyataan Nominasi IISMA</strong></th>
        <th><strong>Pas Foto</strong></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($detailRegisters as $data)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$data->name}}</td>
        <td>{{$data->nim}}</td>
        <td>{{$data->nik}}</td>
        <td>{{$data->departement}}</td>
        <td>{{$data->program_study}}</td>
        <td>{{$data->semester}}</td>
        <td>{{$data->email}}</td>
        <td>{{$data->phone_num}}</td>
        <td>{{date("d-m-Y", strtotime($data->created_at)) }}</td>
        <td>
          <a target="blank" href="{{url('storage/ktp/'.$data->ktp_img)}}">
            <p class="">{{$data->ktp_img}}</p>
          </a>
        </td>
        <td>
          <a target="blank" href="{{url('storage/ktm/'.$data->ktm_img)}}">
            <p class="">{{$data->ktm_img}}</p>
          </a>
        </td>
        <td>
          <a class="text-decoration-none" target="blank"
            href="{{url('storage/surat_pernyataan_iisma/'.$data->surat_pernyataan_iisma)}}">
            <p class="">{{$data->surat_pernyataan_iisma}}</p>
          </a>
        </td>
        <td>
          <a target="blank" href="{{url('storage/pasFoto/'.$data->pasFoto_img)}}">
            <p class="">{{$data->pasFoto_img}}</p>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>