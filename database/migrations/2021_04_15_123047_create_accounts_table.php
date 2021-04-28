<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('account_type')->nullable();
            $table->string('account_name')->nullable();
            $table->integer('account_balance')->default(0);
            $table->string('account_status')->default('not active');
            $table->integer('transaction_pin')->nullable();
            $table->string('bank_name')->nullable();
            $table->integer('bank_code')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
