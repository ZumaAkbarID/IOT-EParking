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
        Schema::create('business_submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('submiter_name');
            $table->string('submiter_phone_number');
            $table->string('bussines_name');
            $table->text('bussines_description');
            $table->text('bussines_address');
            $table->enum('status', ['approved', 'review', 'rejected'])->default('review');
            $table->text('reject_reason')->nullable();
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
        Schema::dropIfExists('business_submissions');
    }
};