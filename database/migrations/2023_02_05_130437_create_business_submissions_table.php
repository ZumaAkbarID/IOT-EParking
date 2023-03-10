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
            $table->string('business_name');
            $table->string('business_thumbnail');
            $table->text('business_description');
            $table->text('business_address');
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