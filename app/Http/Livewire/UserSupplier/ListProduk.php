<?php

namespace App\Http\Livewire\UserSupplier;

use Livewire\Component;
use App\Models\UserMember;
use App\Models\SupplierProduct;
use Auth;

class ListProduk extends Component
{
    public $supplier_id;
    protected $listeners = ['reload'=>'$refresh'];
    public function render()
    {
        // $data = SupplierProduct::where('id_supplier',$this->transaksi->id)->orderBy('id','DESC');
        // $user = Auth::user();
        // dd($this->supplier_id);
        $data = SupplierProduct::where('id_supplier', $this->supplier_id)->orderBy('id','DESC');
        // dd($data->get());

        return view('livewire.user-supplier.list-produk')->with(['data'=>$data->paginate(200)]);
    }

    public function mount($id)
    {
        $this->supplier_id = $id;
        
    }
}
