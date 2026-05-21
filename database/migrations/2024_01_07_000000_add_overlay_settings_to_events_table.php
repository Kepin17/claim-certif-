<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->decimal('overlay_name_top', 5, 2)->default(40)->after('certificate_template');
            $table->decimal('overlay_name_left', 5, 2)->default(50)->after('overlay_name_top');
            $table->integer('overlay_name_size')->default(26)->after('overlay_name_left');
            $table->string('overlay_name_color', 20)->default('#1a2e6e')->after('overlay_name_size');
            $table->decimal('overlay_role_top', 5, 2)->default(52)->after('overlay_name_color');
            $table->decimal('overlay_role_left', 5, 2)->default(50)->after('overlay_role_top');
            $table->integer('overlay_role_size')->default(20)->after('overlay_role_left');
            $table->string('overlay_role_text', 100)->default('Peserta')->after('overlay_role_size');
            $table->string('overlay_role_color', 20)->default('#1a2e6e')->after('overlay_role_text');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'overlay_name_top', 'overlay_name_left', 'overlay_name_size', 'overlay_name_color',
                'overlay_role_top', 'overlay_role_left', 'overlay_role_size', 'overlay_role_text', 'overlay_role_color',
            ]);
        });
    }
};
