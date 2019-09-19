<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AttendanceData', function (Blueprint $table) {
            $table->increments('AttendanceID');
            $table->string('First_Name');
            $table->string('Last_Name');
            $table->date('Date');
            $table->time('TimeIn');
            $table->time('TimeOut');
            $table->time('TimeTotal');
            $table->string('ExceptionType');
            $table->string('Notes');
            $table->char('EmployeeID', 5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('AttendanceData');
    }
}
