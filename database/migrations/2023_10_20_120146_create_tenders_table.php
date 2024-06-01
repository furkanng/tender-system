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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->integer("company_id")->nullable();
            $table->string("tender_no")->nullable();
            $table->string("name")->nullable();
            $table->string("brand")->nullable();
            $table->string("model")->nullable();
            $table->string("year")->nullable();
            $table->string("color")->nullable();
            $table->string("km")->nullable();
            $table->string("plate")->nullable();
            $table->string("fuel_type")->nullable();
            $table->string("roll")->nullable()->comment("silindir");
            $table->string("tsrsb")->nullable();
            $table->string("gear")->nullable();
            $table->string("sase_no")->nullable();
            $table->string("car_type")->nullable();
            $table->text("damages")->nullable();
            $table->json("images")->nullable();
            $table->string("service_name")->nullable();
            $table->string("address")->nullable();
            $table->string("service_phone")->nullable();
            $table->string("service_type")->nullable()->comment("anlaşmalı veya anlaşmasız");
            $table->string("city")->nullable();
            $table->string("district")->nullable();
            $table->string("closed_date")->nullable()->comment("ihale bitiş tarihi");
            $table->string("tender_doc")->nullable()->comment("çekme belgeli vb");
            $table->string("tender_type")->nullable()->comment("açık ihale veya kapalı ihale");
            $table->boolean("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
