<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('participant_number');
        });
    }

    public function down()
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('participant_number')->after('email');
        });
    }
};
