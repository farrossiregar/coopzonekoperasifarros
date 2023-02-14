<div>
    <div class="row">
        <div class="col-md-2">
            <select class="form-control">
                <option value=""> -- Tahun -- </option>
            </select>
        </div>
       
        <div class="col-md-8">
            <a href="javascript:void(0)" data-target="#modal_add_simpanan" data-toggle="modal" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a>
        </div>
    </div>
    <div class="table-responsive mt-3">
        <table class="table table-hover m-b-0 c_list">
            <thead>
                <tr>
                    <th>No</th>
                    <!-- <th class="text-center">Status</th> -->
                    <th>Kode Produksi / Barcode</th>
                    <th>Produk</th>
                    <th>UOM</th>
                    <th class="text-right">Harga Jual</th>
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
                        <td>@livewire('product.editable',['field'=>'product_uom_id','data'=>(isset($item->uom->name) ? $item->uom->name : ''),'id'=>$item->id],key('uom'.$item->id))</td>
                        <td class="text-right">{{format_idr($item->price)}}</td>
                        <td></td>
                    </tr>
                    @php($number--)
                @endforeach
            </tbody>
        </table>
    </div>
</div>

