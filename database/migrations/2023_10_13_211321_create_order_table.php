<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('user_id')->nullable();
      $table->foreign('user_id')->references('id')->on('users');
      $table->dateTime('date');
      $table->unsignedBigInteger('address_id')->nullable();
      $table->foreign('address_id')->references('id')->on('addresses');
      $table->string('status');
      $table->decimal('subtotal');
      $table->decimal('tax');
      $table->decimal('total');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('orders');
  }
};
