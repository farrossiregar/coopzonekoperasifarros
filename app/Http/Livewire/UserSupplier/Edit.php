<?php

namespace App\Http\Livewire\UserSupplier;

use App\Models\UserAccess;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\UserMember;

class Edit extends Component
{
    use WithFileUploads;
    public $data;
    
    public function render()
    {
        return view('livewire.user-supplier.edit')
                        ->with([
                            'access' => UserAccess::all(),
                            'data' => $this->data
                        ]);
    }

    public function mount($id)
    {
        $this->data = UserMember::find($id);
    }
}
