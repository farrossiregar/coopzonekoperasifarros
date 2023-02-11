@section('title', $data->name .' / '. $data->no_anggota_platinum)
@section('parentPageTitle', 'Anggota')
<div class="mt-2 card">
    <div class="card-body">
        <ul class="nav nav-tabs-new2">
            <!-- <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_simpanan">Produk</a></li> -->
            <li class="nav-item">
                <a class="nav-item" data-toggle="tab" href="#tab_coopay" style="padding-bottom:17px">
                    <img src="{{asset('assets/img/coopay-1.png')}}" style="height:25px;" />
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane show active" id="tab_simpanan">
                @livewire('user-supplier.list-produk',['data'=>$data->id])
            </div>
            
        </div>
        <div class="form-group">
            <hr />
            <a href="/"><i class="fa fa-arrow-left"></i> {{__('Kembali')}}</a>
        </div>
    </div>
</div>
@push('after-scripts')
    <script>
        $('#btn-upload-photo').on('click', function() {
            $(this).siblings('#filePhoto').trigger('click');
        });
        Livewire.on('reload',()=>{
            $(".modal").modal('hide');
        });
    </script>
@endpush