<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('account_id');
            $table->string('beneficiary');
            $table->string('beneficiary_name');
            $table->string('transaction_type');
            $table->integer('amount');
            $table->string('status_from_user');
            $table->integer('transaction_id');
            $table->string('reference_no');
            $table->string('status_from_transaction');
            $table->string('status');
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
        Schema::dropIfExists('transactions');
    }
}
