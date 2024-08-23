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
        Schema::create('verified_phones', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('otp')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->integer('sent_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verified_phones');
    }
};
