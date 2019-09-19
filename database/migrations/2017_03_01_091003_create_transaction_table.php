<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Transaction', function (Blueprint $table) {
            $table->char('TransactionID', 5);
            $table->primary('TransactionID');
            $table->string('Transaction_Name_Insert');
            $table->string('Transaction_Name_Update');
            $table->datetime('Transaction_Time_Insert');
            $table->datetime('Transaction_Time_Update');
            $table->int('Transaction_Status', 1);
            $table->char('EmployeeID', 5);
            //$table->foreign('EmployeeID')->references('UserID')->on('User');
            $table->char('MenuID', 5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Transaction');
    }
}
