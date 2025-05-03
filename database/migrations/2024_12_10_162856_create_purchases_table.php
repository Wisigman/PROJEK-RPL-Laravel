<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to User
            $table->string('product_name')->nullable(); // Menambahkan kolom product_name
            $table->decimal('price', 10, 2)->nullable(); // Mengubah kolom price menjadi decimal
            $table->integer('total_amount'); // Mengubah total_amount menjadi integer
            $table->enum('status', ['pending', 'completed', 'cancelled']); // Purchase status
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('purchases');
    }    
};
