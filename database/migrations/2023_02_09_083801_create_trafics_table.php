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
        Schema::create('trafics', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->enum('type', ['parent', 'child']);
            $table->uuid('business_uuid')->nullable();
            $table->string('url');
            $table->text('useragent');
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
        Schema::dropIfExists('trafics');
    }
};
