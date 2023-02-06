<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMember;

class AjaxController extends Controller
{
    protected $respon;

    public function getMember(Request $request)
    {
        $params = [];
        if($request->ajax())
        {
            $user = \Auth::user();
            $data =  UserMember::where('name', 'LIKE', "%". $request->name . "%")->orWhere('Id_Ktp', 'LIKE', '%'. $request->name .'%')->get();

            foreach($data as $k => $item)
            {
                if($k >= 10) continue;

                $params[$k]['id'] = $item->id;
                $params[$k]['value'] = $item->Id_Ktp .' - '. $item->name;
            }
        }
        return response()->json($params);
    }

    public function data()
    {   
        $keyword = isset($_GET['search']) ? $_GET['search'] : '';

        $data = Product::orderBy('keterangan','ASC');

        if($keyword) $data->where(function($table) use($keyword){
                            $table->where('kode_produksi','LIKE',"%{$keyword}%")->orWhere('keterangan','LIKE',"%{$keyword}%");
                        });
        $items = [];
        foreach($data->paginate(10) as $k => $item){
            $items[$k]['id'] = $item->id;
            $items[$k]['keterangan'] = $item->nama;
            $items[$k]['text'] = $item->barcode .' / '. $item->keterangan;
        }

        return response()->json(['message'=>'success','items'=>$items,'total_count'=>count($items)], 200);
    }
}
