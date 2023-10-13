<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('messages', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_send_id')->nullable();
      $table->foreign('user_send_id')->references('id')->on('users');
      $table->unsignedBigInteger('user_receive_id')->nullable();
      $table->foreign('user_receive_id')->references('id')->on('users');
      $table->string('message');
      $table->dateTime('date');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('messages');
  }
};
