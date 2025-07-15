<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
Schema::create('acts', function (Blueprint $table) {
$table->id();
$table->foreignId('passport_id')->constrained('passports')->onDelete('cascade');
$table->string('act_number');
$table->date('act_date');
$table->string('type')->nullable();
// Добавьте остальные нужные поля
$table->timestamps();
});
}

public function down(): void
{
Schema::dropIfExists('acts');
}
};
