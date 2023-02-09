@section('title', 'Kasir')
<div class="row clearfix">
    <div class="col-8">
        <div class="card">
            <div class="body">
                <div class="row mb-4">
                    <div class="col-md-5">
                        <div wire:ignore>
                            <label>KODE PRODUKSI / BARCODE <code>(ALT+Q)</code></label>
                            <!-- <input type="text" class="form-control" id="barcode" wire:model="kode_produksi" wire:keydown.enter="getProduct" placeholder="BARCODE" /> -->
                            <select class="form-control" id="barcode">
                                <option value=""> -- BARCODE -- </option>
                            </select>
                        </div>
                        @error('kode_produksi') <h6 class="text-danger">{{ $message }}</h6> @enderror
                        @if($msg_error) <h6 class="text-danger">{{ $msg_error }}</h6> @endif
                    </div>
                    <div class="col-md-2 px-0">
                        <label>QTY <code>(ALT+W)</code></label>
                        <input type="number" class="form-control" id="qty" wire:keydown.enter="getProduct" wire:model="qty" />
                    </div>
                    <div class="col-2 pt-4">
                        <span wire:loading wire:target="getProduct">
                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                            <span class="sr-only">{{ __('Loading...') }}</span>
                        </span>
                        <button type="button" wire:loading.remove wire:click="getProduct" id="btnGetProduct" wire:target="getProduct" class="btn btn-info btn-lg"><i class="fa fa-plus"></i> TAMBAH <code>(ALT+E)</code></button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table center-aligned-table table-bordered" id="table_product">
                        <thead>
                            <tr style="background:#16a3b8;color:white;">
                                <th class="text-center">NO</th>
                                <th>KODE PRODUKSI / BARCODE</th>
                                <th>PRODUK</th>
                                <th class="text-right">HARGA</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">SISA STOK</th>
                                <th class="text-right">TOTAL</th>
                                <th></th>
                            </tr>
                        </thead>
                        @if(!$data)
                            <tr>
                                <td class="text-center" colspan="7">KOSONG</td>
                            </tr>
                        @endif
                        @php($num=1)
                        <tbody>
                            @foreach($data as $k => $item)
                                <tr tabindex="0">
                                    <td class="text-center" onkeypress="alert(0)">{{$num}}@php($num++)</td>
                                    <td>{{$item['kode_produksi']}}</td>
                                    <td>{{$item['keterangan']}}</td>
                                    <td class="text-right">{{format_idr($item['harga_jual'])}}</td>
                                    <td class="text-center">{{$item['qty']}}</td>
                                    <td class="text-center">{{$item['stock']}}</td>
                                    <td class="text-right">{{format_idr($item['harga_jual'] * $item['qty']);}}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-danger" wire:click="delete({{$k}})" title="Hapus"><i class="fa fa-close"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="body">
                @if($jenis_transaksi==1)
                    <div style="background:#eeeeee4f;" class="mb-3">
                        <table class="table table_total">
                            <tr>
                                <th>NO ANGGOTA</th>
                                <td class="text-right">{{isset($anggota->no_anggota_platinum) ? $anggota->no_anggota_platinum : ''}}</td>
                            </tr>    
                            <tr>
                                <th>NAMA</th>
                                <td class="text-right">{{isset($anggota->name) ? $anggota->name : ''}}</td>
                            </tr>
                            <tr>
                                <th>COOPAY</th>
                                <td class="text-right">Rp. {{isset($anggota->simpanan_ku) ? format_idr($anggota->simpanan_ku) : '0'}}</td>
                            </tr>   
                            <tr>
                                <th>SALDO LIMIT</th>
                                <td class="text-right">Rp. {{isset($anggota->plafond) ? format_idr($anggota->plafond - $anggota->plafond_digunakan) : '0'}}</td>
                            </tr>    
                        </table>
                    </div>
                @endif
                <div style="background:#eeeeee4f">
                    <table class="table table_total">
                        <tr>
                            <th>NO TRANSAKSI</th>
                            <td class="text-right">{{isset($transaksi->no_transaksi) ? $transaksi->no_transaksi : ''}}</td>
                        </tr>    
                        <tr>
                            <th>QTY</th>
                            <td class="text-right">{{format_idr($total_qty)}}</td>
                        </tr>
                        <tr>
                            <th>TOTAL</th>
                            <td class="text-right">Rp. {{format_idr($total_and_ppn)}}</td>
                        </tr>
                    </table>
                    <button type="button" data-toggle="modal" data-target="#modal_input_anggota" id="btn_input_anggota" class="btn btn-warning btn-lg col-12 mb-2"><i class="fa fa-user"></i> 
                        @if($anggota)
                            {{$anggota->no_anggota_platinum}} / {{$anggota->name}} <code>(ALT+P)</code>
                        @else
                            <span>INPUT NO ANGGOTA <code>(ALT+P)</code></span>
                        @endif
                    </button>
                    @if($status_transaksi==1)
                        <div class="row">
                            <span wire:loading wire:target="bayar">
                                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                <span class="sr-only">{{ __('Loading...') }}</span>
                            </span>
                            <div class="col-7 pr-0">
                                <a href="javascript:voi(0)" data-toggle="modal" data-target="#modal_pembayaran" id="btn_bayar" wire:loading.remove wire:target="bayar,cancel_transaction" class="btn btn-info btn-lg col-12" style=""><i class="fa fa-check-circle"></i> <span>BAYAR <code>(ALT+A)</code></span></a>
                            </div>
                            <div class="col-5">
                                <a href="javascript:void(0)" wire:click="cancel_transaction" wire:loading.remove wire:target="bayar,cancel_transaction" class="btn btn-danger btn-lg col-12" id="btn_batalkan"><i class="fa fa-close"></i> BATAL <code>(ALT+S)</code></a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        #table_product tr td:focus{
            background: red;
            color: red;
        }
        .table_total tr td {
            font-size:16px;
        }
        .table_total tr th,.table_total tr td {padding-top:10px;padding-bottom:10px;}
    </style>
    <div wire:ignore.self class="modal fade" id="modal_pembayaran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" style="margin:auto;" id="exampleModalLabel"><i class="fa fa-check-circle"></i> Pembayaran</h4>
                </div>
                <form wire:submit.prevent="bayar">
                    <div class="modal-body">
                        @if($this->status_transaksi==1)
                            <div class="row">
                                <div class="col-4">
                                    <div class="list-group">
                                        <a href="javascript:void(0);" wire:click="$set('metode_pembayaran',4)" class="list-group-item list-group-item-action {{ $metode_pembayaran==4 ? 'active' : ''}}">Tunai</a>
                                        <a href="javascript:void(0);" wire:click="$set('metode_pembayaran',3)" class="list-group-item list-group-item-action {{ $metode_pembayaran==3 ? 'active' : ''}}">Bayar Nanti</a>
                                        <a href="javascript:void(0);" wire:click="$set('metode_pembayaran',5)" class="list-group-item list-group-item-action {{ $metode_pembayaran==5 ? 'active' : ''}}">Coopay</a>
                                        <a href="javascript:void(0);" wire:click="$set('metode_pembayaran',7)" class="list-group-item list-group-item-action {{ $metode_pembayaran==7 ? 'active' : ''}}"">Kartu Kredit</a>
                                        <a href="javascript:void(0);" wire:click="$set('metode_pembayaran',8)" class="list-group-item list-group-item-action {{ $metode_pembayaran==8 ? 'active' : ''}}"">Kartu Debit</a>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div>
                                        <table style="width:100%">
                                            <tr>
                                                <td>
                                                    <h5>Grand Total</h5>
                                                </td>
                                                <td class="text-right text-success">
                                                    <h5 style="font-size:20px;">Rp. {{format_idr($total_and_ppn)}}</h5>
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    @if($message_metode_pembayaran)
                                                        <div class="alert alert-danger" role="alert">{{$message_metode_pembayaran}}</div> 
                                                    @endif    
                                                    <hr />
                                                </td>
                                            </tr>
                                            @if($metode_pembayaran==4)
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="mt-2"> 
                                                            <strong>UANG TUNAI</strong>
                                                            <input type="text" class="form-control text-right format_price" wire:model="uang_tunai" style="font-size:20px;" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>KEMBALI</th>
                                                    <td class="text-right text-success" style="font-size:20px;color:red;font-weight:bold;">Rp. {{format_idr($total_kembali)}}</td>
                                                </tr>
                                            @endif
                                            @if($metode_pembayaran==3)
                                                @if($anggota) 
                                                    <tr>
                                                        <th>SALDO LIMIT</th>
                                                        <td class="text-right text-success" style="font-size:20px;color:red;font-weight:bold;">
                                                            Rp. {{format_idr($anggota->plafond - $anggota->plafond_digunakan)}}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="2" class="text-center">
                                                        <div wire:loading.remove wire:target="event_bayar">
                                                            <label>Gunakan Aplikasi CoopZone dan Scan disini</label>
                                                            {!! QrCode::size(200)->generate(get_setting('no_koperasi')); !!}
                                                        </div>
                                                        <span wire:loading wire:target="event_bayar">
                                                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                                            <span class="sr-only">{{ __('Loading...') }}</span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($metode_pembayaran==5)
                                                <tr>
                                                    <th colspan="2" class="text-center">
                                                        <div wire:loading.remove wire:target="event_bayar">
                                                            <label>Gunakan Aplikasi CoopZone dan Scan disini</label>
                                                            {!! QrCode::size(200)->generate(get_setting('no_koperasi')); !!}
                                                        </div>
                                                        <span wire:loading wire:target="event_bayar">
                                                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                                            <span class="sr-only">{{ __('Loading...') }}</span>
                                                        </span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($metode_pembayaran==7 or $metode_pembayaran==8)
                                                <tr>
                                                    <td colspan="2">
                                                        <label> No Kartu / No Transaksi</label>
                                                        <input type="text" class="form-control" wire:model="no_kartu_debit_kredit" />
                                                        @error('no_kartu_debit_kredit')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>

                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($this->status_transaksi==0 and $success)
                            <h4 class="text-success text-center"><i class="fa fa-check-circle"></i> Pembayaran Berhasil dilakukan</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <span wire:loading wire:target="getProduct">
                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                            <span class="sr-only">{{ __('Loading...') }}</span>
                        </span>
                        @if($this->status_transaksi==1)
                            <button wire:loading.remove wire:target="setAnggota" type="submit" class="btn btn-info col-12 btn-lg"><i class="fa fa-check-circle"></i> BAYAR</button>
                        @endif
                        @if($this->status_transaksi==0 and $success)
                            <a href="javascript:void(0)" class="btn btn-success col-6 btn-lg" data-dismiss="modal" aria-label="Close"><i class="fa fa-check-circle"></i> OKE</a>
                            <a href="javascript:void(0)" class="btn btn-info col-6 btn-lg" wire:click="cetakStruk"><i class="fa fa-print"></i> CETAK</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal_input_anggota" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="setAnggota">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>ANGGOTA <code>(ALT+T)</code></label>
                            <div wire:ignore>
                                <select class="form-control" id="anggota">
                                    <option value=""> -- ANGGOTA -- </option>
                                </select>
                            </div>
                            <!-- <input type="number" class="form-control" id="no_anggota" wire:model="no_anggota"  wire:keydown.enter="setAnggota" placeholder="NOMOR ANGGOTA" /> -->
                            @error('no_anggota')
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                            @enderror
                            @if($msg_error_anggota)
                                <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $msg_error_anggota }}</li></ul>
                            @endif
                        </div>
                        @if($temp_anggota)
                            <table class="table">
                                <tr>
                                    <th>Nama</th>
                                    <td> : {{$temp_anggota->name}}</td>
                                </tr>
                                <tr>
                                    <th>No Telepon</th>
                                    <td> : {{$temp_anggota->phone_number}}</td>
                                </tr>
                                <tr>
                                    <th>Saldo Limit</th>
                                    <td> : Rp. {{format_idr($temp_anggota->plafond - $temp_anggota->plafond_digunakan)}}</td>
                                </tr>
                                <tr>
                                    <th>COOPAY</th>
                                    <td> : Rp. {{format_idr($temp_anggota->simpanan_ku)}}</td>
                                </tr>
                            </table>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <span wire:loading wire:target="getProduct">
                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                            <span class="sr-only">{{ __('Loading...') }}</span>
                        </span>
                        @if($temp_anggota)
                            <a href="javascript:void(0)" wire:loading.remove wire:target="setAnggota" wire:click="okeAnggota" id="btn_find_anggota_oke" class="btn btn-success col-9 btn-lg"><i class="fa fa-check-circle"></i> Oke <code>(ALT+U)</code></a>
                            <a href="javascript:void(0)" wire:loading.remove wire:target="setAnggota" wire:click="deleteAnggota" id="btn_find_anggota_hapus" class="btn btn-danger col-3 btn-lg"><i class="fa fa-times"></i> Hapus <code>(ALT+I)</code></a>
                        @else
                            <button wire:loading.remove wire:target="setAnggota" type="submit" id="btn_find_anggota" class="btn btn-warning col-12 btn-lg"><i class="fa fa-search-plus"></i> FIND <code>(ALT+Y)</code></button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_start_work" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <livewire:kasir.start-work />
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal_end_work" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <livewire:kasir.end-work />
            </div>
        </div>
    </div>
    
    @push('after-scripts')
        <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"/>
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
        <style>
            .select2-container .select2-selection--single {height:36px;padding-left:10px;}
            .select2-container .select2-selection--single .select2-selection__rendered{padding-top:1px;}
            .select2-container--default .select2-selection--single .select2-selection__arrow{top:4px;right:10px;}
            .select2-container {width: 100% !important;}
        </style>
        <script>
            var select_barcode = $('#barcode').select2({
                    placeholder: " -- BARCODE -- ",
                    data : {!!json_encode($data_product)!!}
                }
            );

            $('#barcode').on('change', function (e) {
                var data = $(this).select2("val");
                Livewire.emit('getProduct',data);
            });

            Livewire.on('clear-barcode',()=>{
                $('#barcode').val("").trigger('change');
            });

            var select_anggota = $('#anggota').select2({
                    placeholder: " -- ANGGOTA -- ",
                    data : {!!json_encode($data_anggota)!!}
                }
            );
            $('#anggota').on('change', function (e) {
                var data = $(this).select2("val");
                Livewire.emit('setAnggota',data);
            });


            // on first focus (bubbles up to document), open the menu
            $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            // steal focus during close - only capture once and stop propogation
            $('select.select2').on('select2:closing', function (e) {
                $(e.target).data("select2").$selection.one('focus focusin', function (e) {
                    e.stopPropagation();
                }); 
            });

        </script>
        <script src="{{ asset('assets/js/jquery.priceformat.min.js') }}"></script>
        <script>

            document.addEventListener("keydown", onKeyPressed);
            
            function onKeyPressed(e) {
                if(e.which==13){
                    console.log(document.activeElement);
                }
                console.log(e.which);
                if(e.altKey){
                    if(e.which==81){ // Q
                        $("#barcode").select2('open');
                    }
                    if(e.which==87){ // W
                        $("#qty").focus();
                    }
                    if(e.which==69){ // E
                        $("#btnGetProduct").trigger('click');
                    }
                    if(e.which==80){ // P
                        $("#btn_input_anggota").trigger('click');
                    }
                    if(e.which==84){ // T
                        $("#anggota").select2("open");
                    }
                    if(e.which==89){ // T
                        $("#btn_find_anggota").trigger('click');
                    }
                    if(e.which==85){ // U
                        Livewire.emit('okeAnggota');
                    }
                    if(e.which==73){ // I
                        Livewire.emit('deleteAnggota');
                    }
                    if(e.which==65){ // A
                        $('#btn_bayar').trigger('click');
                    }
                }
            }
           

            $('.format_price').priceFormat({
                prefix: '',
                centsSeparator: '.',
                thousandsSeparator: '.',
                centsLimit: 0
            });
            
            var transaction_id;

            Livewire.on('close-modal-start-work',()=>{
                $("#modal_start_work").modal("hide");
            });
            
            Livewire.on('close-modal-input-anggota',()=>{
                $("#modal_input_anggota").modal("hide");
                console.log("#modal_input_anggota");
            });

            @if(!$user_kasir)
                $("#modal_start_work").modal("show");
            @endif

            Livewire.on('on-print',(url)=>{
                var ifrm = document.createElement("iframe");
                ifrm.setAttribute("src", url);
                ifrm.setAttribute('id','printf_struk');
                ifrm.style.width = "640px";
                ifrm.style.height = "480px";
                ifrm.style.display = "none";
                document.body.appendChild(ifrm);
                document.getElementById("printf_struk").contentWindow.print();
            });

            Livewire.on('set_transaction_id',(id)=>{
                console.log('Transaction id :'+id);
                transaction_id = id;
            });
            var channel = pusher.subscribe('kasir');
            channel.bind('bayar_qrcode', function(data) {
                Livewire.emit('event_bayar',data.transaction_id);
            });
        </script>
    @endpush

</div>