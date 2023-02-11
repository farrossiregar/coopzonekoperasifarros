<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->id();
            $table->char('nama_supplier', 100)->nullable();
            $table->char('alamat_supplier', 250)->nullable();
            $table->char('no_telp', 20)->nullable();
            $table->char('email', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('supplier_product', function (Blueprint $table) {
            $table->id();
            $table->char('id_supplier', 100)->nullable();
            $table->char('barcode', 250)->nullable();
            $table->char('nama_product', 250)->nullable();
            $table->char('desc_product', 250)->nullable();
            $table->char('price', 100)->nullable();
            $table->char('qty', 100)->nullable();
            $table->char('disc', 100)->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->char('no_po', 30)->nullable();
            $table->char('biaya_pengiriman', 100)->nullable();
            $table->char('total_pembayaran', 100)->nullable();
            $table->char('sisa_pembayaran', 100)->nullable();
            $table->char('id_supplier', 100)->nullable();
            $table->char('nama_supplier', 100)->nullable();
            $table->char('alamat_penagihan', 250)->nullable();
            $table->char('status', 20)->nullable();
            $table->char('tanggal_jatuh_tempo', 20)->nullable();
            $table->char('tanggal_pembayaran', 20)->nullable();
            $table->timestamps();
        });

        Schema::create('purchase_order_detail', function (Blueprint $table) {
            $table->id();
            $table->char('id_po', 30)->nullable();
            $table->char('item', 100)->nullable();
            $table->char('price', 100)->nullable();
            $table->char('qty', 100)->nullable();
            $table->char('disc', 100)->nullable();
            $table->char('total_price', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier');
    }
}
