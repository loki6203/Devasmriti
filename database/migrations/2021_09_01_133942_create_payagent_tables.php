<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayagentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_details')){
            Schema::create('user_details', function (Blueprint $table){
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('first_name');
                $table->string('last_name')->nullable();
                $table->decimal('acc_balance', 10, 2)->default(0);
                $table->string('tpin')->nullable();
                $table->string('pan_number',15)->nullable();
                $table->string('adhar_number',15)->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->timestamp('mobile_verified_at')->nullable();
                $table->timestamp('pan_verified_at')->nullable();
                $table->timestamp('adhar_verified_at')->nullable();
                $table->text('pan_response')->nullable();
                $table->text('adhar_response')->nullable();
                $table->smallInteger('mobile_otp');
                $table->smallInteger('pan_attempts');
                $table->smallInteger('adhar_otp');
                $table->smallInteger('email_otp');
                $table->decimal('gateway_charge', 10, 2)->nullable();
                $table->decimal('referal_code_percentage', 10, 2)->nullable();
                $table->decimal('beneficiary_amount', 10, 2)->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('payment_gateways')){
            Schema::create('payment_gateways', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->enum('is_active', ['active', 'inactive'])->default('active');
                $table->decimal('gateway_charge', 10, 2)->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('common_gateway_cards')){
            Schema::create('common_gateway_cards', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->enum('is_active', ['active', 'inactive'])->default('active');
                $table->decimal('gateway_charge', 10, 2)->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('settings')){
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->text('address')->nullable();
                $table->text('emails')->nullable();
                $table->decimal('common_code_percentage', 10, 2)->nullable();
                $table->decimal('beneficiary_amount', 10, 2)->nullable();
                $table->string('site_name')->nullable();
                $table->string('site_email')->nullable();
                $table->string('site_logo')->nullable();
                $table->string('site_phone')->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('account_history')){
            Schema::create('account_history', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->decimal('amount', 10, 2)->nullable();
                $table->enum('cr_or_dr', ['credit', 'debit'])->nullable();
                $table->enum('action_type', ['referel', 'internal_transfer','deposit','prepaid_recharge','postpaid_recharge','dth_recharge','bbps','bill_pay','rent_pay'])->nullable();
                $table->string('description')->nullable();
                $table->integer('transaction_id');
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('internal_transfers')){
            Schema::create('internal_transfers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('from_user_id')->nullable(false);
                $table->foreign('from_user_id')->references('id')->on('users');
                $table->foreignId('to_user_id')->nullable(false);
                $table->foreign('to_user_id')->references('id')->on('users');
                $table->string('description')->nullable();
                $table->enum('payment_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->enum('acc_debited_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->string('transaction_id')->nullable();
                $table->string('invoice_id')->nullable();
                $table->text('payment_response')->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('account_deposits')){
            Schema::create('account_deposits', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('description')->nullable();
                $table->enum('payment_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->enum('acc_debited_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->string('transaction_id')->nullable();
                $table->string('invoice_id')->nullable();
                $table->text('payment_response')->nullable();
                $table->text('card_details')->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('recharge_history')){
            Schema::create('recharge_history', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->enum('recharge_type', ['pre_paid','post_paid','dth'])->nullable();
                $table->string('operator')->nullable();
                $table->string('mobile_number',15);
                $table->decimal('amount', 10, 2)->nullable();
                $table->string('description')->nullable();
                $table->enum('payment_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->enum('acc_debited_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->string('transaction_id')->nullable();
                $table->string('invoice_id')->nullable();
                $table->text('payment_response')->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('billers')){
            Schema::create('billers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('ifsc_code')->nullable();
                $table->string('name')->nullable();
                $table->string('api_response')->nullable();
                $table->enum('is_active', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('bill_pay')){
            Schema::create('bill_pay', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreignId('biller_id')->nullable(false);
                $table->foreign('biller_id')->references('id')->on('billers');
                $table->decimal('amount', 10, 2)->nullable();
                $table->string('description')->nullable();
                $table->enum('payment_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->enum('acc_debited_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->string('transaction_id')->nullable();
                $table->string('invoice_id')->nullable();
                $table->text('payment_response')->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('rent_pay')){
            Schema::create('rent_pay', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreignId('biller_id')->nullable(false);
                $table->foreign('biller_id')->references('id')->on('billers');
                $table->decimal('amount', 10, 2)->nullable();
                $table->string('description')->nullable();
                $table->enum('payment_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->enum('acc_debited_status', ['Pending','Processing','Success' , 'Failed'])->default('Pending');
                $table->string('transaction_id')->nullable();
                $table->string('invoice_id')->nullable();
                $table->text('payment_response')->nullable();
                $table->timestamps();
            });
         }
         if(!Schema::hasTable('notifications')){
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable(false);
                $table->foreign('user_id')->references('id')->on('users');
                
                $table->timestamps();
            });
         }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
        Schema::dropIfExists('payment_gateways');
        Schema::dropIfExists('common_gateway_cards');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('account_history');
        Schema::dropIfExists('internal_transfers');
        Schema::dropIfExists('account_deposits');
        Schema::dropIfExists('recharge_history');
        Schema::dropIfExists('billers');
        Schema::dropIfExists('bill_pay');
        Schema::dropIfExists('rent_pay');
        Schema::dropIfExists('notifications');
    }
}
