<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
			$table->foreignId('code_id')->constrained()->cascadeOnDelete();;
			$table->foreignId('shop_id')->constrained()->cascadeOnDelete();;
			$table->string('name');
			$table->string('amount');
			$table->integer('max_usage_times')->default(0);
			$table->integer('used_times')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
