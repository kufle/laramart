<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Kartu Member</title>
</head>
<style>
    .box{position:relative;}
    .card{width:501.732pt; height:147.402pt;}
    .kode{
        position : absolute;
        top: 110pt;
        left: 10pt;
        color : #fff;
        font-size: 15pt;
    }
    .barcode{
        position : absolute;
        top : 15pt;
        left : 280pt;
        font-size : 10pt;
    }
</style>
<body>
    <table width="100%">
        @foreach($member as $row)
        <tr>
            <td align="center">
            <div class="box">
            <img src="{{asset('storage/cardmember/card.png')}}" class="card">
            <div class="kode">{{$row->code_member}}</div>
            <div class="barcode">
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($row->code_member,'C39') }}" height="30" width="130">
                <br>
                {{$row->code_member}}
            </div>
            </div>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>