<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 10)->unique();
            $table->string('name', 20)->unique();
            $table->string('slug')->unique();
            $table->string('description', 255);
            $table->unsignedInteger('stock');
            $table->unsignedDecimal('price', 10)->default(0);
            $table->string('image', 255)->default('default.png');
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists('products');
    }
}
