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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->nullable();
            $table->integer("tender_id")->nullable();
            $table->integer("company_id")->nullable();
            $table->integer("bid_price")->nullable();
            $table->integer("transfer_status")->nullable();
            $table->string("cover_image")->nullable();
            $table->string("tsrsb")->nullable();
            $table->string("subject")->nullable();
            $table->string("plate")->nullable();
            $table->text("address")->nullable();
            $table->string("tender_closed_date")->nullable();
            $table->integer("tender_company_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
