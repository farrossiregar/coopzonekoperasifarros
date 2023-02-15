<?php

namespace App\Http\Livewire\UserSupplier;

use Livewire\Component;
use App\Models\UserMember;
use App\Models\SupplierProduct;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Auth;

class ListProduk extends Component
{
    public $supplier_id,$insert=false;
    protected $listeners = ['reload'=>'$refresh'];
    public function render()
    {
        // $data = SupplierProduct::where('id_supplier',$this->transaksi->id)->orderBy('id','DESC');
        // $user = Auth::user();
        // dd($this->supplier_id);
        $data = SupplierProduct::where('id_supplier', $this->supplier_id)->orderBy('id','DESC');
        // $po_detail = PurchaseOrder::where()
        // dd($data->get());

        return view('livewire.user-supplier.list-produk')->with(['data'=>$data->paginate(200)]);
    }

    public function mount($id)
    {
        $this->supplier_id = $id;
        
    }


    public function save()
    {
        // $this->validate([
        //     'nama_supplier'=>'required',
        //     'alamat_supplier'=>'required',
        //     'email'=>'required',
        //     'no_telp'=>'required'
        // ]);

        // $find = Supplier::where('nama_supplier',$this->nama_supplier)->first();
        // if($find){
        //     $this->error_nama_supplier = 'Nama Supplier sudah ada';
        //     return;
        // }
        // $cek_po = PurchaseOrder::where('id_supplier', $this->supplier_id)->first();

        // if(){
            
        // }

        // $user                   = new User();
        // $user->user_access_id   = 7; // Supplier
        // $user->name             = $this->nama_supplier;
        // $user->email            = $this->email;
        // $user->telepon          = $this->no_telp;
        // $user->password         = Hash::make('12345678');
		// // $user->username = $this->no_anggota;
        // $user->save();



        $this->reset(['nama_supplier','email','no_telp','alamat_supplier']);
        $this->insert = false;
    }
}
