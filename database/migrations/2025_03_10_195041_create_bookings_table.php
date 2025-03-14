<?php

use Faker\Provider\Uuid;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('travel_id');
            $table->string('user_email');
            $table->integer('seats');
            $table->decimal('amount');
            $table->enum('status', ['pending', 'confirmed'])->default('pending');
            $table->timestamp('expires_at');
            $table->uuid('session_token')->default(Uuid::uuid())->index();
            $table->timestamps();

            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
