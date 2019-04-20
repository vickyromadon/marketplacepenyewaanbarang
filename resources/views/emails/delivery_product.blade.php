<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <title>RentOnCome</title>
      <link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">
    <style>
        .body {
            background: #efefef;
            padding: 30px 30px;
            font-family: Tahoma, Geneva, sans-serif;
        }
        .button {
            display: block;
            width: 40%;
            height: 25px;
            background: orange;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .boxshadow {
            background-color: #FFF;
            padding: 30px 30px;
            box-shadow: 0px 0px 50px 0px rgba(0, 0, 0, 0.1);
            -webkit-box-shadow: 0px 0px 50px 0px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0px 0px 50px 0px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-family: Comfortaa, Tahoma, Geneva, sans-serif;
            font-size: 16pt;
            font-weight: 700;
        }
    </style>
</head>

<body class="body">

<table width="600" cellpadding="10" cellspacing="0" border="0" align="center" bgcolor="#ffffff" class="boxshadow">

    <tr height="20" align="center">
        <td colspan="30">
            <h2>Hello {{$member->name}}</h2>
            <h5 style=" font-family:Tahoma, Geneva, sans-serif; line-height: 16px; font-size: 12px; color:#000; font-weight: 500;">
                Product yang Anda Rental Sudah di Kirim.
            </h5>
        </td>
    </tr>
        <tr height="0" align="center">
        <td style="padding: 0 30px;">
            <h5 style=" font-family:Tahoma, Geneva, sans-serif; line-height: 16px; font-size: 12px; color:#000; font-weight: 500;">
                <b>Booking Code</b>    : #{{ $booking->code }} <br>
                <b>Product Name</b>    : {{ $product->name }} <br><br>

                <b style="font-size: 20px;"><u>Detail Pengiriman</u></b> <br>

                <b>Nama</b>             : {{ $delivery->name }} <br>
                <b>Phone</b>            : {{ $delivery->phone }} <br>
                <b>Address</b>          : {{ $delivery->address }} <br> <br>

                <b>Tanggal Dikirim</b>  : {{ $delivery->delivery_date }} <br>
                <b>Tanggal Tiba</b>     : {{ $delivery->arrive_date }} <br>
            </h5>
        </td>
    </tr>
    <tr height="0" align="center">
        <td>
            <h5 style=" font-family:Tahoma, Geneva, sans-serif; line-height: 16px; font-size: 12px; color:#000; font-weight: 500;">
                Silahkan Klik Tombol Link di Bawah ini Untuk Informasi Lebih Lengkap.
            </h5>
        </td>
    </tr>
    <tr align="center">
        <td colspan="30">
            <a href="{{ route('member.delivery.show', ['id' => $delivery->id]) }}" class="button">CONFIRM DELIVERY</a>
        </td>
    </tr>
</table>
</body>
</html>