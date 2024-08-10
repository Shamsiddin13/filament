<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('ID_number', 10)->primary(); // Primary key
            $table->dateTime('createdAt');
            $table->string('displayProductName', 255);
            $table->string('article', 50);
            $table->dateTime('statusUpdatedAt')->nullable();
            $table->decimal('summ', 9, 0);
            $table->decimal('totalSumm', 9, 0);
            $table->decimal('prepaySum', 9, 0);
            $table->integer('quantity')->default(0);
            $table->decimal('purchaseSumm', 9, 0);
            $table->string('store', 50);
            $table->string('source', 50)->default('No source');
            $table->string('medium', 50)->default('No medium');
            $table->string('campaign', 25)->default('No campaign');
            $table->string('status', 50)->nullable();
            $table->string('manager', 20)->default('Tanlanmagan');
            $table->decimal('costShip', 11, 0)->default(0);
            $table->decimal('netCostShip', 11, 0)->default(0);
            $table->decimal('target', 10, 2)->nullable();
            
            $table->timestamps(); // If you want Laravel to manage created_at and updated_at automatically
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
}
