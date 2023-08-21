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
        Schema::create('emails', function (Blueprint $table) {
            $table->id('email_id');
            $table->unsignedBigInteger('reciver_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('cc_id')->nullable();
            $table->unsignedBigInteger('bcc_id')->nullable();
            $table->string('subject');
            $table->text('body');
            $table->timestamps();
            $table->foreign('reciver_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('sender_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
