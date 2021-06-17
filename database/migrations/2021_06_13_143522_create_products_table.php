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
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->float('price');
            $table->float('special_price')->nullable();
            $table->string('special_price_type')->nullable();
            $table->date('special_price_start')->nullable();
            $table->date('special_price_end')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('track_stock')->default(1);
            $table->tinyInteger('in_stock')->default(0);
            $table->integer('qty')->default(1);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('is_new')->default(0);
            $table->date('new_from')->nullable();
            $table->date('new_to')->nullable();
            $table->boolean('is_orderable')->default(1);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
