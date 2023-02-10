<?php

namespace App\Http\Livewire\UserMember;

use Livewire\Component;

class SettingSimpanan extends Component
{
    public $bunga_pertahun_simpanan_sukarela;
    public function render()
    {
        return view('livewire.user-member.setting-simpanan');
    }

    public function mount()
    {
        $this->bunga_pertahun_simpanan_sukarela = get_setting('bunga_pertahun_simpanan_sukarela');
    }

    public function save()
    {
        $this->validate([
            'bunga_pertahun_simpanan_sukarela' => 'required'
        ]);

        update_setting('bunga_pertahun_simpanan_sukarela',$this->bunga_pertahun_simpanan_sukarela);
        
        $this->emit('close-modals');
    }
}
