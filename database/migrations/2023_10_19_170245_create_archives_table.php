<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->integer("company_id")->nullable();
            $table->string("tender_no")->nullable();
            $table->string("plate")->nullable();
            $table->string("car")->nullable();
            $table->string("year")->nullable();
            $table->string("city")->nullable();
            $table->string("date")->nullable();
            $table->string("order")->nullable();
            $table->string("my_bid")->nullable();
            $table->string("bid_name")->nullable();
            $table->string("bid_phone")->nullable();
            $table->string("bid_win")->nullable();
            $table->string("status")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
