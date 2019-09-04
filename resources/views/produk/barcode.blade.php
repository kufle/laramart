<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Barcode</title>
</head>
<body>
    <table width="100%">
        <tr>
            @foreach($dataproduk as $produk)
                <td align='center' style="border: 1px solid #ccc">
                    {{$produk->product_name}} - {{ format_uang($produk->harga_jual)}}
                    </span><br><br>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($produk->code_product,'C39') }}" alt="" height="60" width="180">
                    <br>
                    {{$produk->code_product}}
                </td>
                @if($no++ % 3 == 0)
                <tr></tr>
                @endif
            @endforeach
        </tr>
    </table>
</body>
</html>