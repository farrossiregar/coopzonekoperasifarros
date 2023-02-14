<?php

namespace App\Http\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\TransaksiItem;

class Detail extends Component
{
    public $data,$penjualan,$pembelian,$is_ppn,$harga,$harga_jual,$diskon,$ppn=0,$harga_produksi=0,$margin=0;
    protected $listeners = ['reload-page'=>'$refresh'];
    public function render()
    {
        return view('livewire.product.detail');
    }

    public function mount(Product $data)
    {
        $this->data = $data;
        $this->penjualan = TransaksiItem::where('product_id',$data->id)->get();
        if($this->data->ppn==0) {
            $this->data->ppn = @$this->data->harga_jual * 0.11;
            $this->data->save();
        }
        $this->pembelian = ProductStock::where('product_id',$this->data->id)->get();
        $this->is_ppn = $this->data->is_ppn;
        $this->harga = $this->data->harga;
        $this->harga_jual = $this->data->harga_jual;
        $this->diskon = $this->data->diskon;

        if($this->is_ppn==1 and $this->harga){
            $this->ppn = $this->harga * 0.11;
        }
        // Harga Produksi
        if($this->harga>0) $this->harga_produksi = $this->harga + $this->ppn;
        // Margin
        if($this->harga_jual>0 && $this->harga_produksi>0) $this->margin = $this->harga_jual  - $this->harga_produksi; 
        if($this->diskon>0 and $this->margin>0) $this->margin = $this->margin - $this->diskon;
    }

    public function updated($propertyName)
    {
        if($this->is_ppn==1 and $this->harga){
            $this->ppn = $this->harga * 0.11;
        }else{
            $this->ppn = 0;
        }
        // Harga Produksi
        if($this->harga>0) $this->harga_produksi = $this->harga + $this->ppn;
        // Margin
        if($this->harga_jual>0 && $this->harga_produksi>0) $this->margin = $this->harga_jual  - $this->harga_produksi; 
        if($this->diskon>0 and $this->margin>0) $this->margin = $this->margin - $this->diskon;
    }

    public function update()
    {
        $this->validate([
            'harga_jual' => 'required'
        ]);

        $this->data->ppn = $this->ppn;
        $this->data->harga_jual = $this->harga_jual;
        $this->data->harga = $this->harga;
        $this->data->margin = $this->margin;
        $this->data->diskon = $this->diskon;
        $this->data->save();

        $this->emit('message-success','Data berhasil disimpan.');
    }
}