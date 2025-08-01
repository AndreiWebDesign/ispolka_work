<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prilozeniye_gotovn_podmosteis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('passport_id');
            $table->string('number_act');
            $table->integer('day');
            $table->string('month');
            $table->integer('year');
            $table->string('stroika_address');
            $table->string('lift_type');
            $table->string('lift_number');
            $table->string('prim_1')->nullable();
            $table->string('prim_2')->nullable();

            $table->string('sdat_fio');
            $table->string('sdat_dolzh');
            $table->string('sdat_sign')->nullable();
            $table->string('sdat_decipher')->nullable();
            $table->string('sdat_date')->nullable();

            $table->string('prinyal_an_fio')->nullable();
            $table->string('prinyal_an_dolzh')->nullable();
            $table->string('prinyal_an_sign')->nullable();
            $table->string('prinyal_an_decipher')->nullable();
            $table->string('prinyal_an_date')->nullable();

            $table->string('prinyal_mont_fio')->nullable();
            $table->string('prinyal_mont_dolzh')->nullable();
            $table->string('prinyal_mont_sign')->nullable();
            $table->string('prinyal_mont_decipher')->nullable();
            $table->string('prinyal_mont_date')->nullable();

            $table->timestamps();
            $table->foreign('passport_id')->references('id')->on('passports')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('prilozeniye_gotovn_podmostei');
    }
};
