<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporting', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('paket_id')->unsigned();
            $table->string('perusahaan');
            $table->enum('status',['Terumumkan','Proses Kontrak','Status','Selesai'])->default('Terumumkan');
            $table->decimal('nilai_kontrak', $precision = 10, $scale = 2);
            $table->text('keterangan');
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
        Schema::dropIfExists('reporting');
    }
};
