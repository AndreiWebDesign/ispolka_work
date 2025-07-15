<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('passports', function (Blueprint $table) {
            $table->id();

            // Информация об участниках
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('customer');                       // Заказчик
            $table->string('customer_responsible')->nullable(); // Ответственное лицо заказчика (опционально)
            $table->string('contractor');                     // Подрядчик
            $table->string('contractor_responsible');         // Ответственное лицо подрядчика
            $table->string('tech_supervisor');                // Технадзор
            $table->string('tech_supervisor_responsible');    // Ответственное лицо технадзора
            $table->string('author_supervisor');              // Авторский надзор
            $table->string('author_supervisor_responsible');  // Ответственное лицо авторского надзора
            $table->string('project_developer');              // Разработчик проекта

            // Расположение
            $table->string('city')->nullable();
            $table->string('locality')->nullable();

            // Проектно-сметная документация
            $table->string('psd_number');                     // Номер ПСД

            // Название объекта (опционально)
            $table->string('object_name')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passports');
    }
};
