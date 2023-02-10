@section('title', 'Transaksi')
<div class="clearfix row">
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state mb-2">
            <div class="body">
                <div class="icon">
                    <i class="fa fa-shopping-cart text-info"></i>
                </div>
                <div class="content">
                    <div class="text">Penjualan hari ini</div>
                    <h5 class="number">Rp. {{format_idr($penjualan_hari_ini)}}</h5>
                </div>
            </div>                        
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state mb-2">
            <div class="body">
                    <div class="icon text-warning">
                        <i class="fa fa-database"></i>
                    </div>
                <div class="content">
                    <div class="text">Transaksi hari ini</div>
                    <h5 class="number">{{$transaksi_hari_ini}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state mb-2">
            <div class="body">
                    <div class="icon text-danger">
                        <i class="fa fa-calendar"></i>
                    </div>
                <div class="content">
                    <div class="text">Penjualan bulan ini</div>
                    <h5 class="number">Rp. {{format_idr($penjualan_bulan_ini)}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12">
        <div class="card top_counter currency_state mb-2">
            <div class="body">
                    <div class="icon">
                        <i class="fa fa-database text-success"></i>
                    </div>
                <div class="content">
                    <div class="text">Transaksi bulan ini</div>
                    <h5 class="number">{{format_idr($transaksi_bulan_ini)}}</h5>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-1">
                    <div class="pl-3 pt-2 form-group mb-0" x-data="{open_dropdown:false}" @click.away="open_dropdown = false">
                        <a href="javascript:void(0)" x-on:click="open_dropdown = ! open_dropdown" class="dropdown-toggle">
                            Filter <i class="fa fa-search-plus"></i>
                        </a>
                        <div class="dropdown-menu show-form-filter" x-show="open_dropdown">
                            <form class="p-2">
                                <div class="from-group my-2">
                                    <select class="form-control" wire:model="filter.status">
                                        <option value=""> -- Status -- </option>
                                        <option value="1"> Sukses</option>
                                        <option value="2"> Batal</option>
                                        <option value="3"> Gagal</option>
                                    </select>
                                </div>
                                <div class="from-group my-2">
                                    <input type="text" class="form-control" wire:model="filter.no_transaksi" placeholder="No Transaksi" />
                                </div>
                                <div class="from-group my-2">
                                    <select class="form-control" wire:model="filter.pembayaran">
                                        <option value=""> -- Status Pembayaran -- </option>
                                        <option value="1"> Lunas</option>
                                        <option value="2"> Belum Lunas</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <small>Tanggal Transaksi</small>
                                    <input type="text" class="form-control tanggal_transaksi" />
                                </div>
                                <a href="javascript:void(0)" wire:click="clear_filter()"><small>Clear filter</small></a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="javascript:void(0);" wire:click="downloadExcel"><i class="fa fa-download"></i> Download</a>
                            <a href="javascript:void(0)" class="dropdown-item"><i class="fa fa-plus"></i> Transaksi</a>
                        </div>
                    </div>
                    <span wire:loading>
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </span>
                </div>
            </div>
            <div class="body pt-0">
                <div class="table-responsive" style="min-height:400px;">
                    <table class="table table-hover m-b-0 c_list">
                        <thead style="background: #eee;">
                           <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Jenis Transaksi</th>
                                <th>No Transaksi</th>
                                <th class="text-center">Metode Pembayaran</th>
                                <th>Tanggal Transaksi</th>
                                <th>Status Pembayaran</th>
                                <th class="text-center">Tanggal Pembayaran</th>
                                <th class="text-right">Nominal</th>
                                <th class="text-right">PPN</th>
                                <th class="text-right">Total</th>
                                <th></th>
                           </tr>
                        </thead>
                        <tbody>
                            @php($number= $data->total() - (($data->currentPage() -1) * $data->perPage()) )
                            @foreach($data as $k => $item)
                                <tr>
                                    <td style="width: 50px;">{{$number}}</td>
                                    <td>{!!status_transaksi($item->status)!!}</td>
                                    <td>
                                        @if($item->jenis_transaksi==1)
                                            <span class="badge badge-info">Anggota</span>
                                        @endif
                                        @if($item->jenis_transaksi==2)
                                            <span class="badge badge-warning">Non Anggota</span>
                                        @endif
                                    </td>
                                    <td><a href="{{route('transaksi.items',$item->id)}}">{{$item->no_transaksi}}</a></td>
                                    <td class="text-center">{{$item->metode_pembayaran ? metode_pembayaran($item->metode_pembayaran) : 'TUNAI'}}</td>
                                    <td>{{date('d-M-Y H:i',strtotime($item->created_at))}}</td>
                                    <td class="text-center">
                                        @if($item->payment_date)
                                            <span class="badge badge-success">Lunas</span>
                                        @else
                                            <span class="badge badge-warning">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{$item->payment_date ? date('d-M-Y',strtotime($item->payment_date)) : '-'}}</td>
                                    <td class="text-right">
                                        <!-- @if($item->type_amount==0)
                                            <span class="text-success" title="In"><i class="fa fa-arrow-down"></i></span>
                                        @endif
                                        @if($item->type_amount==1)
                                            <span class="text-danger" title="Out"><i class="fa fa-arrow-up"></i></span>
                                        @endif -->
                                        {{format_idr($item->amount - ($item->amount * 0.11))}}
                                    </td>
                                    <td class="text-right">{{format_idr($item->amount * 0.11)}}</td>
                                    <td class="text-right">{{format_idr($item->amount)}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-navicon"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            </div>
                                        </div>    
                                    </td>
                                </tr>
                                @php($number--)
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <br />
                {{$data->links()}}
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal_set_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="changePassword">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-sign-in"></i> Set Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" wire:model="password" />
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger close-modal">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_autologin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-sign-in"></i> Autologin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger close-modal">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <livewire:transaksi.upload />
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirm_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-warning"></i> Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <p>Are you want delete this data ?</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">No</button>
                <button type="button" wire:click="delete()" class="btn btn-danger close-modal">Yes</button>
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
    <script type="text/javascript" src="{{ asset('assets/vendor/daterange/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor/daterange/daterangepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/daterange/daterangepicker.css') }}" />
    <script>
        $('.tanggal_transaksi').daterangepicker({
            opens: 'left',
            locale: {
                cancelLabel: 'Clear'
            },
            autoUpdateInput: false,
        }, function(start, end, label) {
            @this.set("filter_created_start", start.format('YYYY-MM-DD'));
            @this.set("filter_created_end", end.format('YYYY-MM-DD'));
            $('.tanggal_transaksi').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
        });
        
</script>
@endpush