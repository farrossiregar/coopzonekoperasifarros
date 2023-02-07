<html>
    <head>
    <style>
         @page {
            font-family: Arial, Helvetica, sans-serif;
            size: 58mm 23.5cm;  potrait; 
            margin:0 10px;
            padding-left:0; 
            font-size:12px;
        }
        @media print {
            @page {
                font-family: Arial, Helvetica, sans-serif;
                padding-left:0; 
                size: 58mm 23.5cm;  potrait; 
                margin:0 10px; 
                font-size: 12px;
            }
        }
    </style>
    </head>
<body>
    <div style="border-bottom:1px dotted black;margin-top:20px;width:100%">
        <p style="text-align:center;">
            {{get_setting('company')}}<br />
            <small>{!!get_setting('address')!!}</small>
        </p>
        <div style="clear:both"></div>
    </div>
    <div style="border-bottom:1px dotted black;width:100%">
        <div style="width:100%;margin:0;padding:0;">
            {{$data->no_transaksi}}<br />
            Kasir : {{isset($data->user->name) ? $data->user->name : '-'}} 
            {{date('d.F.Y H:i',strtotime($data->created_at))}}
        </div>
        <div style="clear:both"></div>
    </div>
    <table style="width:100%">
        @php($total=0)
        @foreach($data->items as $item)
            <tr>
                <td style="width:80%;padding-right:10px;">{{$item->description}}</td>
                <td style="width:10%;">{{$item->qty}}</td>
                <td style="width:10%;">{{format_idr($item->price)}}</td>
                <td style="width:10%;padding-left:10px;">{{format_idr($item->price*$item->qty)}}</td>
            </tr>
            @php($total += $item->price)
        @endforeach
        <tr>
            <td colspan="3" style="border-top:1px dotted black;">Sub Total</td>
            <td style="text-align:right;border-top:1px dotted black;">Rp.{{format_idr($total)}}</td>
        </tr>
        <tr>
            <td colspan="3">Rounding</td>
            <td style="text-align:right;">-</td>
        </tr>
        <tr>
            <td colspan="3">Total</td>
            <td style="text-align:right;">{{format_idr($total)}}</td>
        </tr>
        
        <tr>
            <td colspan="4" style="border-top:1px dotted black;" >
                <strong>{{$data->metode_pembayaran ? metode_pembayaran($data->metode_pembayaran) : 'TUNAI'}}</strong>
                 @if(in_array($data->metode_pembayaran,[7,8]))
                  ({{substr_replace($data->no_kartu_debit_kredit,"*****",-5)}})
                 @endif
            </td>
        </tr>
        <tr>
            <td colspan="2">Amount</td>
            <td style="text-align:right;" colspan="2">Rp. {{format_idr($data->uang_tunai)}}</td>
        </tr>
        <tr>
            <td colspan="2">Change</td>
            <td style="text-align:right;" colspan="2">Rp. {{format_idr($data->uang_tunai_change)}}</td>
        </tr>
        <tr>
            <td colspan="2">Saving</td>
            <td style="text-align:right;" colspan="2">Rp. 0</td>
        </tr>
        <!-- <tr>
            <td colspan="2">DPP</td>
            <td style="text-align:right;" colspan="2">Rp. {{format_idr($total - ($total * 0.11))}}</td>
        </tr>
        <tr>
            <td colspan="2">Pajak</td>
            <td style="text-align:right;" colspan="2">Rp. {{format_idr($total * 0.11)}}</td>
        </tr> -->
        <tr>
            <td colspan="4" style="border-top:1px dotted black;" ></td>
        </tr>
        @if($data->jenis_transaksi==1)
            <tr>
                <td colspan="4">{{isset($data->anggota->no_anggota_platinum) ? $data->anggota->no_anggota_platinum .' / '. $data->anggota->name : ''}}</td>
            </tr>
            <tr>
                <td colspan="4" style="border-top:1px dotted black;" ></td>
            </tr>
        @endif
    </table>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <p style="text-align:center;">
    Yuk segera download<br/>
    Coopzone mobile apps &<br />
    dapatkan penawaran seru!<br />
    di google play/apps store</p>
    <p style="text-align:center">
        <img src="{{$data->id}}.png" style="width:60px;" />
    </p>
</body>
</html>