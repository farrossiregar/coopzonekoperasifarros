<?php

namespace App\Http\Livewire\ProductSupplier;

use Livewire\Component;
use App\Models\SupplierProduct;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keyword;
    public function render()
    {
        $data = SupplierProduct::orderBy('id','DESC');

        // if($this->keyword){
        //     $data->where('keterangan','LIKE',"%{$this->keyword}%")
        //         ->orWhere('kode_produksi','LIKE',"%{$this->keyword}%");
        // }

        return view('livewire.product-supplier.index')->with(['data'=>$data->paginate(200)]);
    }
}
