<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_invitations', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
            $table->foreignId('passport_id')->after('user_id')->constrained('passports')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('project_invitations', function (Blueprint $table) {
            $table->dropForeign(['passport_id']);
            $table->dropColumn('passport_id');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
        });
    }
};
