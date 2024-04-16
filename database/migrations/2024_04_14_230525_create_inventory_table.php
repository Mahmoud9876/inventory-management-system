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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->uuid();
            $table->string('code')->unique();
            $table->integer('quantity');
            $table->string('category')->nullable();
            $table->float('selling_price');
            $table->integer('stock_phy')->default(0);
            $table->string('slug');
            $table->decimal('tax', 8, 2);
            $table->enum('tax_type', ['inclusive', 'exclusive']);
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('inventory');
    }
};
