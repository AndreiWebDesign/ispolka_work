<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hidden_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('passport_id')->constrained()->onDelete('cascade');
            $table->string('act_number');
            $table->string('city')->nullable();
            $table->date('act_date')->nullable();
            $table->string('object_name')->nullable();
            $table->string('contractor_representative')->nullable();
            $table->string('tech_supervisor_representative')->nullable();
            $table->string('author_supervisor_representative')->nullable();
            $table->text('additional_participants')->nullable();
            $table->string('work_executor')->nullable();
            $table->text('hidden_works')->nullable();
            $table->text('psd_info')->nullable();
            $table->text('materials')->nullable();
            $table->text('compliance_evidence')->nullable();
            $table->text('deviations')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('commission_decision')->nullable();
            $table->string('next_works')->nullable();
            $table->string('contractor_sign_name')->nullable();
            $table->string('contractor_sign')->nullable();
            $table->string('tech_supervisor_sign_name')->nullable();
            $table->string('tech_supervisor_sign')->nullable();
            $table->string('author_supervisor_sign_name')->nullable();
            $table->string('author_supervisor_sign')->nullable();
            $table->text('additional_signs')->nullable();
            $table->timestamps();
        });
    }
};
