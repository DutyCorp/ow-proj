<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User', function (Blueprint $table) {
            $table->string('Username');
            $table->primary('Username');
            $table->char('EmployeeID', 5);
            $table->primary('EmployeeID');
            $table->char('OfficeID', 5);
            //$table->foreign('OfficeID')->references('OfficeID')->on('Office');
            $table->char('RoleID', 5);
            //$table->foreign('RoleID')->references('RoleID')->on('Role');
            $table->string('Password');
            $table->string('Position');
            $table->string('Email');
            $table->string('SkypeID');
            $table->string('MobilePhone');
            $table->string('KTP');
            $table->string('CV');
            $table->string('Passport');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('User');
    }
}
