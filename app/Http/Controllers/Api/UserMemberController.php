<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserMember;
use Illuminate\Http\Request;

class UserMemberController extends Controller
{
    public function data()
    {   
        $keyword = isset($_GET['search']) ? $_GET['search'] : '';

        $data = UserMember::orderBy('keterangan','ASC');

        if($keyword) $data->where(function($table) use($keyword){
                            $table->where('name','LIKE',"%{$keyword}%")
                                ->orWhere('no_anggota_platinum','LIKE',"%{$keyword}%");
                        });
        $items = [];
        foreach($data->paginate(10) as $k => $item){
            $items[$k]['id'] = $item->no_anggota_platinum;
            $items[$k]['keterangan'] = $item->name;
            $items[$k]['text'] = $item->no_anggota_platinum .' / '. $item->name;
        }

        return response()->json(['message'=>'success','items'=>$items,'total_count'=>count($items)], 200);
    }
}