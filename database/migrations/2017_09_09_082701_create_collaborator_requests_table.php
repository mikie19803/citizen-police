<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaboratorRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborator_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inviteFrom')->unsigned();
            $table->integer('inviteTo')->unsigned();
            $table->integer('report_id')->unsigned();

            $table->timestamps();
            $table->foreign('inviteFrom')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('inviteTo')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collaborator_requests');
    }
}
