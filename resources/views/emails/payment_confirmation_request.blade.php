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
            <h2>Payment Confirmation</h2>
            <h5 style=" font-family:Tahoma, Geneva, sans-serif; line-height: 16px; font-size: 12px; color:#000; font-weight: 500;">
            </h5>
        </td>
    </tr>
        <tr height="0" align="center">
        <td style="padding: 0 30px;">
            <h5 style=" font-family:Tahoma, Geneva, sans-serif; line-height: 16px; font-size: 12px; color:#000; font-weight: 500;">
                
                <b style="font-size: 20px;"><u>Detail Trasaksi</u></b> <br>

                <b>Booking Code</b>     : #{{ $transaction->booking->code }} <br>
                <b>Product Name</b>     : {{ $transaction->booking->product->name }} <br><br>

                <b style="font-size: 20px;"><u>Detail Bank Pengirim</u></b> <br>

                <b>Bank Name</b>            : {{ $transaction->bank_name_of_sender }} <br>
                <b>Account Name</b>         : {{ $transaction->account_name_of_sender }} <br>
                <b>Account Number</b>       : {{ $transaction->account_number_of_sender }} <br><br>

                <b style="font-size: 20px;"><u>Detail Bank Tujuan</u></b> <br>

                <b>Bank Name</b>            : {{ $bank->name }} <br>
                <b>Account Name</b>         : {{ $bank->owner }} <br>
                <b>Account Number</b>       : {{ $bank->number }} <br>
            </h5>
        </td>
    </tr>
    <tr height="0" align="center">
        <td>
            <h5 style=" font-family:Tahoma, Geneva, sans-serif; line-height: 16px; font-size: 12px; color:#000; font-weight: 500;">
                Silahkan Klik Tombol Link di Bawah ini, Untuk Melihat Informasi Lebih Lengkap.
            </h5>
        </td>
    </tr>
    <tr align="center">
        <td colspan="30">
            <a href="{{ route('payment_confirmation.index') }}/{{ $transaction->id }}" class="button">VIEW Transaction</a>
        </td>
    </tr>
</table>
</body>
</html>