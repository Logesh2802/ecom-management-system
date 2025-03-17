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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('product_id');
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('quantity');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->boolean('status')->default(0);
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
