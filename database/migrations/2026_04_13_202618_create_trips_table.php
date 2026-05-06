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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('FromCity');
            $table->string('ToCity');
            $table->string('FromRegion');
            $table->string('ToRegion');
            $table->time('DepartureTime');
            $table->time('ArrivalTime');
            $table->date('DateTrip');
            $table->string('Price');
            $table->integer('BookedSeats');
            $table->integer('TotalSeats');
            $table->boolean("RepliedAdmin")->default(false)->nullable();
            $table->enum('status', ['pending', 'active', 'completed', 'approved','cancelled'])
                ->default('pending');
            $table->boolean("TripRepeat");
            $table->string('note')->default("Please be on time")->nullable();
            $table->foreignId('driver_id')->constrained()->onDelete('cascade');
            $table->string('transport')->default('bus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
