<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241, 245, 249);
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 0.5rem;
            text-align: left;
        }
        table th {
            background-color: rgb(3, 58, 112);
            color: #ffffff;
        }
        .margin-top {
            margin-top: 1.25rem;
        }
    </style>
</head>
<body>
    <h1 style="color:rgb(3, 58, 112); margin-bottom: 50px;"><strong>SchoolTech</strong></h1>
    <h2 class="text-center">Detail User</h2>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>NISN/NIP</th>
            <th>Role</th>
            <th>School</th>
        </tr>
        <?php $i = 1 ?>
        @foreach($users as $user)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone_number }}</td>
            <td>{{ $user->NISN_NIP }}</td>
            <td>{{ $user->role ? $user->role->name : 'No Role' }}</td>
            <td>{{ $user->school ? $user->school->name : 'No School' }}</td>
        </tr>
        @endforeach
    </table>

    <div class="footer margin-top">
        <div>Copyright &copy; SchoolTech</div>
        <div>Terakhir diunduh: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</div>
    </div>
</body>
</html>
