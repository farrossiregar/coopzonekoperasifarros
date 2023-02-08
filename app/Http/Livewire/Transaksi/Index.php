<?php

namespace App\Http\Livewire\Transaksi;

use Livewire\Component;
use App\Models\Transaksi;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filter=[];
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

        return view('livewire.transaksi.index')->with(['data'=>$data->paginate(500)]);
    }
}
