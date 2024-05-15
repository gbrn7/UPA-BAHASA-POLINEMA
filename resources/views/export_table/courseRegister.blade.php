<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Course Register</title>
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
        <th><strong>Email</strong></th>
        <th><strong>NO. Wa</strong></th>
        <th><strong>Alamat</strong></th>
        <th><strong>Tujuan</strong></th>
        <th><strong>Experience</strong></th>
        <th><strong>Tanggal Daftar</strong></th>
        <th><strong>Foto KTP/Passport</strong></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($detailRegisters as $data)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$data->name}}</td>
        <td>{{$data->email}}</td>
        <td>{{$data->phone_num}}</td>
        <td>{{$data->address}}</td>
        <td>{{$data->goal}}</td>
        <td>{{$data->experience}}</td>
        <td>{{$data->created_at->format('Y-m-d')}}</td>
        <td>
          <a target="blank" href="{{url('storage/ktp/'.$data->ktp_or_passport_img)}}">
            <p class="">{{$data->ktp_or_passport_img}}</p>
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>

</html>