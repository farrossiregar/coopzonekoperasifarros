<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class SyncProductByExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:product-excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');

        $inputFileName = './public/sto.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, false, true);

        $arr = [];
        $key=0;
        $num=0;
        foreach($sheetData as $k =>$item){
            $num++;
            if($num<=1) continue;
            
            preg_match('/\\s+(.*)\s+/', $item['D'], $name);
            if(!isset($name[1])) continue;

            $name = trim($name[1]);
            // $price = number_format($item['E'], 2, '.', '');

            $price = replace_idr($item['E']);
            $item_code = $item['C'];
            
            $product = Product::where('item_code',$item_code)->first();
            
            if(!$product){
                $this->info("{$k}. SKIP :{$item_code} - ".$name);
                continue;
            }

            $product->harga = $price;
            $product->harga_jual = $price;
            $product->save(); continue;

            echo $k .'.'. $item_code."/".$name ."\n";
        }
    }
}
