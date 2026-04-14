<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            
            $table->id();
            $table->string('from');
            $table->string('to');
            $table->string('time');
            $table->string('driver_name');
            $table->string('driver_image')->nullable();
            $table->integer('price');
            $table->integer('passengers');
            $table->timestamps();
            $table->string('transport');
           
        });
    }
public function down()
{
    Schema::table('items', function (Blueprint $table) {
        $table->dropColumn([
            'from',
            'to',
            'time',
            'driver_name',
            'driver_image'
        ]);
    });
}
};