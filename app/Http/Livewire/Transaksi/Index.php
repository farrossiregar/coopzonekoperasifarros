<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Product;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filter=[],$filter_created_start,$filter_created_end;
    public $penjualan_hari_ini=0,$transaksi_hari_ini=0,$penjualan_bulan_ini=0,$transaksi_bulan_ini=0;
    public $selected_item,$alasan;
    protected $listeners = ['void'=>'void'];
    public function render()
    {
        $data = Transaksi::where('is_temp',0)->orderBy('id','DESC');

        if($this->filter){
            foreach($this->filter as $field =>$value){
                if($value=="") continue;
                if($field=='no_transaksi'){
                    $data->where($field, "LIKE", "%{$value}%");
                }elseif($field=='pembayaran'){
                    if($value==1) 
                        $data->whereNotNull('payment_date');
                    else
                        $data->whereNull('payment_date');
                }else{
                    $data->where($field,$value);
                }
            }
        }

        if($this->filter_created_start and $this->filter_created_end){
            if($this->filter_created_start == $this->filter_created_end)
                $data->whereDate('created_at',$this->filter_created_start);
            else
                $data->whereBetween('created_at',[$this->filter_created_start,$this->filter_created_end]);
        }

        $total = clone $data;

        return view('livewire.transaksi.index')->with(['data'=>$data->paginate(500),'total'=>$total->sum('amount')]);
    }

    public function mount()
    {
        $this->penjualan_hari_ini = Transaksi::whereDate('created_at',date('Y-m-d'))->sum('amount');
        $this->transaksi_hari_ini = Transaksi::whereDate('created_at',date('Y-m-d'))->count();
        $this->penjualan_bulan_ini = Transaksi::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->sum('amount');
        $this->transaksi_bulan_ini = Transaksi::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->count();
    }

    public function void($id)
    {
        $this->selected_item = Transaksi::find($id);
    }

    public function voidTransaksi()
    {
        $this->validate([
            'alasan' => 'required'
        ]);

        $this->selected_item->status = 4; //void
        $this->selected_item->void_alasan = $this->alasan;
        $this->selected_item->void_date = date('Y-m-d');
        $this->selected_item->save();

        foreach($this->selected_item->items as $item){
            Product::find($item->product_id)->update(['qty'=>$item->product->qty + $item->qty]);
        }
        $this->emit('message-success',"Data transaksi #{$this->selected_item->no_transaksi} berhasil di void.");
        $this->emit('close-modal');
    }

    public function downloadExcel()
    {
        
    }
}
