<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->foreignId('certificate_type_id')->nullable()->after('event_id')
                  ->constrained('certificate_types')->nullOnDelete();
            $table->string('certificate_type_name')->nullable()->after('certificate_type_id');
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['certificate_type_id']);
            $table->dropColumn(['certificate_type_id', 'certificate_type_name']);
        });
    }
};
