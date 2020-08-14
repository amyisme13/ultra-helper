<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUltraUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ultra_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('moodle_id');
            $table->string('username')->unique();
            $table->string('email');
            $table->string('name');

            $table->string('function')->nullable();
            $table->string('division')->nullable();
            $table->string('position')->nullable();
            $table->string('area')->nullable();
            $table->string('sub_area')->nullable();
            $table->string('costcenter')->nullable();
            $table->string('top_username')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->boolean('suspended')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ultra_users');
    }
}
