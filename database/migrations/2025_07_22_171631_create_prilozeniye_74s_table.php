<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prilozeniye_74s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('passport_id');
            $table->string('number_act');
            $table->string('city');
            $table->integer('day');
            $table->string('month');
            $table->integer('year');
            $table->string('an')->nullable();
            $table->string('tnz')->nullable();
            $table->string('po')->nullable();
            $table->string('subpo')->nullable();
            $table->string('exploat')->nullable();
            $table->string('exploat_fio')->nullable();
            $table->string('object_name');
            $table->string('docs')->nullable();
            $table->timestamps();

            $table->foreign('passport_id')->references('id')->on('passports')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('prilozeniye_74');
    }
};
