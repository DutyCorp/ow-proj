<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Office', function (Blueprint $table) {
            $table->char('OfficeID', 5);
            $table->primary('OfficeID');
            $table->string('Region');
            $table->string('Phone_Office');
            $table->string('Address');
            $table->string('Fax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Office');
    }
}
