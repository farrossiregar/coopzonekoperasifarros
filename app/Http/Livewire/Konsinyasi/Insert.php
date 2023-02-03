<?php

namespace App\Http\Livewire\Konsinyasi;

use Livewire\Component;

class Insert extends Component
{
    public $kode_produksi;
    public function render()
    {
        return view('livewire.konsinyasi.insert');
    }
}
