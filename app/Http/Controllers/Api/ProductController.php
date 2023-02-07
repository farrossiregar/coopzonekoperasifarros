<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function update(Request $r)
    {
        $validator = \Validator::make($r->all(), [
            'token'=>'required',
        ]);
        
        if($r->token != env('COOPZONE_TOKEN')) return response()->json(['status'=>'failed','message'=>'Token Invalid'], 200);

        if ($validator->fails()) {
            $msg = '';
            foreach ($validator->errors()->getMessages() as $key => $value) {
                $msg .= $value[0]."\n";
            }
            return response()->json(['status'=>'failed','message'=>$msg], 200);
        }
        if(isset($r->data['kode_produksi'])){
            $find = Product::where('kode_produksi',$r->data['kode_produksi'])->first();
            if(!$find){
                $find = new Product();
            }
            $find->kode_produksi = $r->data['kode_produksi'];
            $find->keterangan = $r->data['keterangan'];
            $find->qty = $r->data['qty'];
            $find->harga = $r->data['harga'];
            $find->harga_jual = $r->data['harga_jual'];
            $find->save();
        }else
            return response()->json(['status'=>'failed','message'=>'Kode Produksi Required'], 200);

        return response()->json(['status'=>'success'], 200);
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
            $items[$k]['id'] = $item->kode_produksi;
            $items[$k]['keterangan'] = $item->keterangan;
            $items[$k]['text'] = $item->kode_produksi .' / '. $item->keterangan;
        }

        return response()->json(['message'=>'success','items'=>$items,'total_count'=>count($items)], 200);
    }
}