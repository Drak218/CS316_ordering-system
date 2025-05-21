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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();

        // Foreign key to users table (staff_id)
        $table->unsignedBigInteger('staff_id'); // this will store the users.id of the staff

        // Other columns with their data types
        $table->string('customer_name');
        $table->string('address');
        $table->string('city');
        $table->integer('zip_code'); // or you can use string if zip has letters

        $table->boolean('tax_exempt'); // assuming yes/no
        $table->string('product_name');
        $table->decimal('price', 10, 2); // for money values, 10 digits total, 2 decimals
        $table->integer('quantity');
        $table->decimal('weight', 8, 2); // weight in kg or lbs
        
        $table->string('shipping_method');
        $table->decimal('sales_tax', 10, 2);
        $table->decimal('shipping_fee', 10, 2);
        $table->decimal('handling_fee', 10, 2);
        $table->decimal('total', 10, 2);

        $table->timestamps();

        // Set foreign key constraint
        $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
