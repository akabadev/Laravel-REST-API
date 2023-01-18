<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportProcessingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_processing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained();
            $table->unsignedInteger("line");
            $table->mediumText("content");
            $table->boolean("has_error")->default(false);
            $table->json("errors")->nullable();
            $table->string("message")->nullable();
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
        Schema::dropIfExists('import_processing');
    }
}
