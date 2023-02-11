<?php

namespace App\Http\Livewire\UserSupplier;

use Livewire\Component;
use App\Models\UserMember;
use App\Models\SupplierProduct;

class ListProduk extends Component
{
    public $transaksi;
    protected $listeners = ['reload'=>'$refresh'];
    public function render()
    {
        // $data = SupplierProduct::where('id_supplier',$this->transaksi->id)->orderBy('id','DESC');
        $data = SupplierProduct::orderBy('id','DESC');

        return view('livewire.user-supplier.list-produk')->with(['data'=>$data->paginate(200)]);
    }

    public function mount(UserMember $data)
    {
        // dd($data->id);
        $this->transaksi = $data;
        
    }
}
