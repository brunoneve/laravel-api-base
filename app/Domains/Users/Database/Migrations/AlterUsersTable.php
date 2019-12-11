<?php

namespace App\Domains\Users\Database\Migrations;

use App\Support\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class AlterUsersTable extends Migration
{
    public function up()
    {
        $this->schema->table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('remember_token');
            $table->string('cpf')->nullable()->after('birth_date');
            $table->string('phone')->nullable()->after('cpf');
            $table->string('avatar')->nullable()->after('phone');
        });
    }

    public function down()
    {
        $this->schema->table('users', function (Blueprint $table) {
            //
        });
    }
}
