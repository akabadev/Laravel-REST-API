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
            $table->id();

            $table->string('reference')->unique();
            $table->string('tracking_number')->unique();

            $table->string('type');
            $table->string('status');

            $table->dateTime('validated_at')->nullable();
            $table->dateTime('generated_at')->nullable();
            $table->dateTime('transmitted_at')->nullable();
            $table->dateTime('produced_at')->nullable();
            $table->dateTime('shipped_at')->nullable();

            $table->boolean('active')->default(true);

            $table->foreignId('customer_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();

            $table->softDeletes();

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
        Schema::dropIfExists('orders');
    }
}
