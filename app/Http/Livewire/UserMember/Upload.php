<?php

namespace App\Http\Livewire\UserMember;

use Livewire\Component;
use App\Models\UserMember;
use Livewire\WithFileUploads;

class Upload extends Component
{
    use WithFileUploads;
    public $file;
    public function render()
    {
        return view('livewire.user-member.upload');
    }

    public function save()
    {
        ini_set('memory_limit', '-1');
        $this->validate([
            'file'=>'required|mimes:xls,xlsx|max:51200' // 50MB maksimal
        ]);
        
        $path = $this->file->getRealPath();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $data = $reader->load($path);
        $sheetData = $data->getActiveSheet()->toArray(null, true, false, true);

        if(count($sheetData) > 0){
            $countLimit = 1;
            foreach($sheetData as $key => $i){
                if($key<=0 || $i['A']=="") continue; // skip header
            
                $no_anggota = $i['C'];
                $limit = $i['E'];
                $member = UserMember::where('no_anggota_platinum',$no_anggota)->first();
                if($member){
                    $member->plafond = $limit;
                    $member->plafond_digunakan = 0;
                    $member->save();
                }
            }
        }

        session()->flash('message-success',__('Data berhasil di upload'));

        return redirect()->route('user-member.index');
    }
}