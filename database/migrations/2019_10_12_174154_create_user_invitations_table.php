<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_invitations', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('program_id');
            $table->foreign('program_id')
            ->references('id')
            ->on('programs');
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')
                    ->references('id')
                    ->on('roles');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('token')->unique();
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
        Schema::dropIfExists('user_invitations');
    }
}

