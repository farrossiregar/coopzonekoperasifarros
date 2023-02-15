
<div class="clearfix row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header row">
                <div class="col-md-2">
                    <input type="text" class="form-control" wire:model="keyword" placeholder="Pencarian" />
                </div>
              
                <!-- <div class="col-md-6">
                   
                    <a href="javascript:void(0)" wire:click="$set('insert',true)" class="btn btn-warning"><i class="fa fa-plus"></i> Supplier</a>
                    <span wire:loading>
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                        <span class="sr-only">{{ __('Loading...') }}</span>
                    </span>
                </div> -->
            </div>
            <div class="body pt-0">
                <div class="table-responsive" style="min-height:250px; overflow: scroll;">
                    <table class="table table-hover m-b-0 c_list">
                        <thead style="background: #eee;">                        
                            <tr>
                                <th>No</th>
                                <!-- <th class="text-center">Status</th> -->
                                <th>Kode Produksi / Barcode</th>
                                <th>Produk</th>
                                <th>Deskripsi</th>
                                <th>Stock Supplier</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-right">UOM</th>
                                <th></th>
                            </tr>
                        </thead>
                           
                        <tbody>
                            @php($number= $data->total() - (($data->currentPage() -1) * $data->perPage()) )
                            @foreach($data as $k => $item)
                                <tr>
                                    <td style="width: 50px;">{{$number}}</td>
                                    <!-- <td class="text-center">
                                        
                                        @if($item->status==1)
                                            <span class="badge badge-success">Aktif</span>
                                        @endif
                                        @if($item->status==0 || $item->status=="")
                                            <span class="badge badge-default">Tidak Aktif</span>
                                        @endif
                                    </td> -->
                                    <td>@livewire('product.editable',['field'=>'barcode','data'=>$item->barcode,'id'=>$item->id],key('barcode'.$item->id))</td>
                                    <td><a href="{{route('product.detail',$item->id)}}">{{$item->nama_product}}</a></td>
                                    <td>{{$item->desc_product}}</td>
                                    <td>{{$item->qty}}</td>
                                    <td class="text-right">{{format_idr($item->price)}}</td>
                                    <td class="text-right"></td>
                                    <td></td>
                                </tr>
                                @php($number--)
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card mb-2">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_pembelian">{{ __('Pembelian') }} </a></li>
                </ul>
                <div class="tab-content px-0">
                    <div class="tab-pane active show" id="tab_pembelian">
                        <div class="table-responsive">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <input type="text" class="form-control" placeholder="Pencarian" />
                                </div>
                                <div class="col-2">
                                    <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_form_pembelian" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a> -->
                                    <a href="javascript:void(0)" wire:click="$set('insert',true)" class="btn btn-warning"><i class="fa fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                            <table class="table m-b-0 c_list table-hover">
                                <thead>
                                    <tr style="background: #eee;">
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Diskon</th>
                                        <th>Total Harga</th>
                                        <th>Created Date</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($insert)
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="text" class="form-control" wire:model="produk" />
                                            @error('produk') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" wire:model="price" />
                                            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" wire:model="qty" />
                                            @error('qty') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" wire:model="diskon" />
                                            @error('diskon') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" wire:model="total_price" readonly />
                                            @error('total_price') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly />
                                            
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" wire:click="save" class="btn btn-info"><i class="fa fa-save"></i> Simpan</a>
                                            <a href="javascript:void(0)" wire:click="$set('insert',false)" class="btn btn-danger"><i class="fa fa-close"></i> Batal</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @foreach($data as $k => $item)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{$item->item}}</td>
                                            <td>{{$item->price}}</td>
                                            <td>{{$item->qty}}</td>
                                            <td>{{$item->disc}}</td>
                                            <td>{{$item->total_price}}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-navicon"></i></a>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" wire:click="delete({{$item->id}})"><i class="fa fa-trash"></i> Hapus</a>
                                                    </div>
                                                </div>    
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
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
<script>
    Livewire.on('modal-konfirmasi-meninggal',(data)=>{
        $("#modal_konfirmasi_meninggal").modal("show");
    });
    Livewire.on('modal-detail-meninggal',(data)=>{
        $("#modal_detail_meninggal").modal("show");
    });
</script>
@endpush
@section('page-script')
function autologin(action,name){
    $("#modal_autologin form").attr("action",action);
    $("#modal_autologin .modal-body").html('<p>Autologin as '+name+' ?</p>');
    $("#modal_autologin").modal("show");
}
@endsection