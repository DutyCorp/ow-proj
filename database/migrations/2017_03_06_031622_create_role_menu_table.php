<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Role_Menu', function (Blueprint $table) {
            $table->char('Role_Menu_ID', 5);
            $table->primary('Role_Menu_ID');
            $table->char('RoleID', 5);
            //$table->foreign('RoleID')->references('RoleID')->on('Role');
            $table->char('MenuID', 5);
            //$table->foreign('OfficeID')->references('OfficeID')->on('Office');
            $table->int('isActive', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
