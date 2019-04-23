<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_settings', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('organization_id')->unique();
            $table->foreign('organization_id')
                ->references('id')
                ->on('organizations');
            $table->uuid('pay_period_type_id');
            $table->foreign('pay_period_type_id')
                ->references('id')
                ->on('pay_period_types');
            $table->uuid('time_calculator_type_id');
            $table->foreign('time_calculator_type_id')
                ->references('id')
                ->on('time_calculator_types');
            $table->boolean('categories')->default(0);
            $table->primary(['id', 'organization_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_settings');
    }
}
