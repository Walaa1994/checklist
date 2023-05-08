<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('checklist_id');
            $table->index('checklist_id');
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
            $table->string('name')->nullable(false);
            $table->text('description')->nullable();
            $table->boolean('status')->nullable(false);
            $table->date('start_date')->nullable(false);
            $table->dateTime('end_date')->nullable();
            $table->date('estimate_date')->nullable(false);
            $table->bigInteger('created_by')->nullable(false);
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('tasks');
    }
}
