<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeLogRequestChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_log_request_changes', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->uuid('organization_id');
            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations');
            $table->uuid('time_sheet_id');
            $table->foreign('time_sheet_id')
                ->references('id')
                ->on('time_sheets');
            $table->date('date');
            $table->text('clock_in');
            $table->text('clock_out');
            $table->boolean('categories');
            $table->float('total_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_log_request_changes');
    }
}