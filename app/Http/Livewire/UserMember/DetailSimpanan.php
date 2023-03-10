<?php

namespace App\Http\Livewire\UserMember;

use Livewire\Component;
use App\Models\JenisSimpanan;
use App\Models\Simpanan;
use App\Models\UserMember;

class DetailSimpanan extends Component
{
    public $jenis_simpanan,$member,$filter=[];
    protected $listeners = ['reload'=>'$refresh'];
    
    public function render()
    {
        $data = Simpanan::where(['user_member_id'=>$this->member->id])->with('jenis_simpanan')->orderBy('id',"DESC");

        foreach($this->filter as $field => $value){
            $data->where($field,$value);
        }

        $total_amount = clone $data;

        return view('livewire.user-member.detail-simpanan')->with(['data'=>$data->paginate(100),'total_amount'=>$total_amount->sum('amount')]);
    }

    public function mount(UserMember $data)
    {
        $this->member = $data;
        $this->jenis_simpanan = JenisSimpanan::get();
    }
}