<?php

namespace App\Domains\Users\Database\Migrations;

use App\Support\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserProfileTable extends Migration
{
    public function up()
    {
        $this->schema->create('user_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('birth_date')->nullable();
            $table->string('cpf')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        $this->schema->dropIfExists('user_profile');
    }
}
