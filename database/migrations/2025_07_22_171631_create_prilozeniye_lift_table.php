<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prilozeniye_gotovn_lifts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('passport_id');
            $table->string('number_acts');
            $table->integer('day');
            $table->string('month');
            $table->integer('year');
            $table->string('stroika_address');
            $table->string('lift');
            $table->string('number_lift');
            $table->string('tnp');
            $table->string('tnp_dolzj')->nullable();
            $table->string('an')->nullable();
            $table->string('an_dolzh')->nullable();
            $table->string('mo')->nullable();
            $table->string('mo_dolzh')->nullable();
            $table->string('otdel_raboty')->nullable();
            $table->string('lift_number')->nullable();
            $table->timestamps();

            $table->foreign('passport_id')->references('id')->on('passports')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('prilozeniye_gotovn_lift');
    }
};
