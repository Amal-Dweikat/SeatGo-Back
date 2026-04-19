<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('items', function (Blueprint $table) {
        $table->string('from_city')->nullable();
        $table->string('to_city')->nullable();
        if (!Schema::hasColumn('items', 'time')) {
            $table->string('time')->nullable();
        }
        if (!Schema::hasColumn('items', 'driver_name')) {
            $table->string('driver_name')->nullable();
        }
        if (!Schema::hasColumn('items', 'driver_image')) {
            $table->string('driver_image')->nullable();
        }
    });
}

public function down()
{
    Schema::table('items', function (Blueprint $table) {
        $table->dropColumn([
            'from_city',
            'to_city',
            'time',
            'driver_name',
            'driver_image'
        ]);
    });
}
};