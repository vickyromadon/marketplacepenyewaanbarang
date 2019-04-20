<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>RentOnCome</title>

    <style>
        .body{
            background: #efefef;
            padding: 30px 30px;
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
<table width="600px" cellpadding="10" cellspacing="0" border="0" align="center" bgcolor="#ffffff" class="boxshadow">
    <tr height="20" align="center">
        <td>
            <h2>Hello {{$name}}</h2>
            <h5 style=" font-family:Tahoma, Geneva, sans-serif; line-height: 16px; font-size: 12px; color:#000; font-weight: 500;">
                Thank you for joining us at <b>RentOnCome</b>! Your account is almost ready. Please click the link below to
                activate your account :
            </h5>
        </td>
    </tr>
    <tr align="center">
        <td>
            <a href="{{$link}}" class="button">ACTIVATE ACCOUNT</a>
        </td>
    </tr>
</table>
</body>
</html>