<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('participant_number')->unique();
            $table->string('event');
            $table->string('proof_file')->nullable();
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected', 'generated', 'sent'])->default('pending');
            $table->string('certificate_number')->nullable()->unique();
            $table->string('pdf_path')->nullable();
            $table->string('qr_code')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};
