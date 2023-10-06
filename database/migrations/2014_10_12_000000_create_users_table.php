<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('images')){
            Schema::create('images', function (Blueprint $table){
                $table->id();
                $table->string('name');
                $table->string('domain');
                $table->longText('url');
                $table->enum('image_type',['Seva_Banner','Seva_Background','Seva_Featured','Event_Banner','Event_Background','Event_Featured','Updates','Temple','SevaType','Coupon','Family','User','Testimonial']);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table){
                $table->id();
                $table->string('fname')->nullable();
                $table->string('lname')->nullable();
                $table->string('email')->nullable();
                $table->string('mobile_number',15)->unique();
                $table->string('password')->nullable();
                $table->foreignId('profile_pic_id')->nullable();
                $table->foreign('profile_pic_id')->references('id')->on('images')->onDelete('cascade');
                $table->date('dob')->nullable();
                $table->text('about_me')->nullable();
                $table->integer('otp')->nullable();
                $table->enum('user_type', ['user','superadmin'])->default('user');
                $table->boolean('is_active')->default(1);
                $table->rememberToken();
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('countries')){
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->boolean('is_active')->default(1);
                $table->timestamps();
            });
        }
        if(!Schema::hasTable('states')){
            Schema::create('states', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('country_id');
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('cities')){
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('state_id');
                $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('settings')){
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->text('address')->nullable();
                $table->decimal('common_reward_percentage', 10, 2)->nullable();
                $table->decimal('rewards_minium_cart_amount', 10, 2)->nullable();
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('relations')){
            Schema::create('relations', function (Blueprint $table){
                $table->id();
                $table->string('name');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('rasi')){
            Schema::create('rasi', function (Blueprint $table){
                $table->id();
                $table->string('name');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('temples')){
            Schema::create('temples', function (Blueprint $table){
                $table->id();
                $table->foreignId('featured_image_id');
                $table->foreign('featured_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->string('name');
                $table->string('code');
                $table->longText('about');
                $table->foreignId('country_id');
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->foreignId('state_id');
                $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
                $table->foreignId('city_id');
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
                $table->smallInteger('pincode')->nullable();
                $table->longText('address');
                $table->smallInteger('latitude')->nullable();
                $table->smallInteger('longitude')->nullable();
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('seva_types')){
            Schema::create('seva_types', function (Blueprint $table){
                $table->id();
                $table->foreignId('featured_image_id');
                $table->foreign('featured_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->string('name');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(!Schema::hasTable('sevas')){
            Schema::create('sevas', function (Blueprint $table){
                $table->id();
                $table->longText('title');
                $table->string('sku_code');
                $table->string('event');
                $table->string('location');
                $table->foreignId('banner_image_id');
                $table->foreign('banner_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->foreignId('background_image_id')->nullable();
                $table->foreign('background_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->foreignId('feature_image_id');
                $table->foreign('feature_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->foreignId('temple_id');
                $table->foreign('temple_id')->references('id')->on('temples')->onDelete('cascade');
                $table->foreignId('seva_type_id');
                $table->foreign('seva_type_id')->references('id')->on('seva_types')->onDelete('cascade');
                $table->date('start_date');
                $table->date('expairy_date');
                $table->boolean('is_expaired')->default(0);
                $table->string('expairy_label')->nullable();
                $table->integer('reward_points')->default(0);
                $table->longText('description');
                $table->longText('additional_information');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();               
            });
        }
        if(!Schema::hasTable('seva_updates')){
            Schema::create('seva_updates', function (Blueprint $table){
                $table->id();
                $table->foreignId('seva_id');
                $table->foreign('seva_id')->references('id')->on('sevas')->onDelete('cascade');
                $table->longText('title');
                $table->foreignId('file_id');
                $table->foreign('file_id')->references('id')->on('images')->onDelete('cascade');
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();              
            });
        }
        if(!Schema::hasTable('seva_faqs')){
            Schema::create('seva_faqs', function (Blueprint $table){
                $table->id();
                $table->foreignId('seva_id');
                $table->foreign('seva_id')->references('id')->on('sevas')->onDelete('cascade');
                $table->longText('title');
                $table->longText('sub_title');
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();              
            });
        }
        if(!Schema::hasTable('seva_prices')){
            Schema::create('seva_prices', function (Blueprint $table){
                $table->id();
                $table->foreignId('seva_id');
                $table->foreign('seva_id')->references('id')->on('sevas')->onDelete('cascade');
                $table->longText('title');
                $table->float('base_price', 10, 2)->default(0.00);
                $table->float('selling_price', 10, 2)->default(0.00);
                $table->boolean('is_rewards_available')->default(0);
                $table->boolean('is_prasadam_available')->default(0);
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes(); 
            });
        }
        if(!Schema::hasTable('events')){
            Schema::create('events', function (Blueprint $table){
                $table->id();
                $table->longText('title');
                $table->string('sku_code');
                $table->string('event');
                $table->string('location');
                $table->foreignId('banner_image_id');
                $table->foreign('banner_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->foreignId('background_image_id')->nullable();
                $table->foreign('background_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->foreignId('feature_image_id');
                $table->foreign('feature_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->date('start_date');
                $table->dateTime('expairy_date_time');
                $table->boolean('is_expaired')->default(0);
                $table->string('expairy_label')->nullable();
                $table->integer('reward_points')->default(0);
                $table->longText('description');
                $table->longText('additional_information');
                $table->boolean('is_active')->default(1);
                $table->timestamps();     
                $table->softDeletes();           
            });
        }
        if(!Schema::hasTable('event_sevas')){
            Schema::create('event_sevas', function (Blueprint $table){
                $table->id();
                $table->foreignId('seva_id');
                $table->foreign('seva_id')->references('id')->on('sevas')->onDelete('cascade');
                $table->foreignId('event_id');
                $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes(); 
            });
        }
        if(!Schema::hasTable('event_updates')){
            Schema::create('event_updates', function (Blueprint $table){
                $table->id();
                $table->foreignId('event_id');
                $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
                $table->longText('title');
                $table->foreignId('file_id');
                $table->foreign('file_id')->references('id')->on('images')->onDelete('cascade');
                $table->boolean('is_active')->default(1);
                $table->timestamps(); 
                $table->softDeletes();               
            });
        }
        if(!Schema::hasTable('event_faqs')){
            Schema::create('event_faqs', function (Blueprint $table){
                $table->id();
                $table->foreignId('event_id');
                $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
                $table->longText('title');
                $table->longText('sub_title');
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();              
            });
        }
        if(!Schema::hasTable('user_family_details')){
            Schema::create('user_family_details', function (Blueprint $table){
                $table->id();
                $table->foreignId('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->enum('family_type',['kartha','ancestors','kartha_ancestors',''])->nullable();
                $table->string('full_name');
                $table->date('dob');
                $table->foreignId('relation_id');
                $table->foreign('relation_id')->references('id')->on('relations')->onDelete('cascade');
                $table->foreignId('rasi_id');
                $table->foreign('rasi_id')->references('id')->on('rasi')->onDelete('cascade');
                $table->string('gothram');
                $table->string('nakshatram');
                $table->longText('description');
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();               
            });
        }
        if(!Schema::hasTable('user_addresses')){
            Schema::create('user_addresses', function (Blueprint $table){
                $table->id();
                $table->foreignId('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->string('fname');
                $table->string('lname');
                $table->string('email')->nullable();
                $table->string('phone_no');
                $table->string('whatsup_no');
                $table->foreignId('country_id');
                $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
                $table->foreignId('state_id');
                $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
                $table->foreignId('city_id');
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
                $table->longText('address_1');
                $table->longText('address_2');
                $table->smallInteger('pincode');
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();            
            });
        }
        if(!Schema::hasTable('seva_coupons')){
            Schema::create('seva_coupons', function (Blueprint $table){
                $table->id();
                $table->string('title');
                $table->string('code');
                $table->enum('coupon_type', ['Fixed','Percentage'])->default('Fixed');
                $table->foreignId('coupon_image_id');
                $table->foreign('coupon_image_id')->references('id')->on('images')->onDelete('cascade');
                $table->boolean('is_for_new_user_only')->default(0);
                $table->integer('per_user_limit_count')->default(1);
                $table->integer('max_users_count')->default(1);
                $table->json('users')->nullable();
                $table->json('sevas')->nullable();
                $table->date('start_date');
                $table->date('end_date');
                $table->string('description');
                $table->boolean('is_active')->default(1);
                $table->timestamps();   
                $table->softDeletes();         
            });
        }
        if(!Schema::hasTable('orders')){
            Schema::create('orders', function (Blueprint $table){
                $table->id();
                $table->foreignId('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreignId('shipping_user_address_id');
                $table->foreign('shipping_user_address_id')->references('id')->on('user_addresses')->onDelete('cascade');
                $table->json('shipping_address')->nullable();
                $table->foreignId('billing_user_address_id');
                $table->foreign('billing_user_address_id')->references('id')->on('user_addresses')->onDelete('cascade');
                $table->json('billing_address')->nullable();
                $table->enum('booking_type', ['Online','Offline'])->default('Online');
                $table->enum('payment_status', ['Pending','Processing','Failed','Success'])->default('Pending');
                $table->string('reference_id')->unique();
                $table->string('invoice_id')->unique();
                $table->string('transaction_id')->nullable()->unique();
                $table->float('org_price', 10, 2);
                $table->float('reward_points', 10, 2);
                $table->foreignId('seva_coupon_id')->nullable();
                $table->foreign('seva_coupon_id')->references('id')->on('seva_coupons')->onDelete('cascade');
                $table->float('coupon_amount', 10, 2)->default(0.00);
                $table->json('coupon_information')->nullable();
                $table->float('final_paid_amount', 10, 2);
                $table->json('transaction_response')->nullable();
                $table->timestamps();     
                $table->softDeletes();         
            });
        }
        if(!Schema::hasTable('order_sevas')){
            Schema::create('order_sevas', function (Blueprint $table){
                $table->id();
                $table->foreignId('order_id');
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->foreignId('seva_price_id');
                $table->foreign('seva_price_id')->references('id')->on('seva_prices')->onDelete('cascade');
                $table->integer('qty');
                $table->float('base_price', 10, 2)->default(0.00);
                $table->float('selling_price', 10, 2)->default(0.00);
                $table->json('seva_price_information')->nullable();
                $table->timestamps();
                $table->softDeletes();             
            });
        }
        if(!Schema::hasTable('user_rewards')){
            Schema::create('user_rewards', function (Blueprint $table){
                $table->id();
                $table->foreignId('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->boolean('is_credited')->default(1);
                $table->integer('points');
                $table->foreignId('order_id');
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();           
            });
        }
        if(!Schema::hasTable('anouncements')){
            Schema::create('anouncements', function (Blueprint $table){
                $table->id();
                $table->foreignId('seva_id');
                $table->foreign('seva_id')->references('id')->on('sevas')->onDelete('cascade');
                $table->longText('title');
                $table->boolean('is_active')->default(1);
                $table->timestamps();
                $table->softDeletes();            
            });
        }
        if(!Schema::hasTable('user_cart')){
            Schema::create('user_cart', function (Blueprint $table){
                $table->id();
                $table->string('reference_id');
                $table->foreignId('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreignId('seva_id');
                $table->foreign('seva_id')->references('id')->on('sevas')->onDelete('cascade');
                $table->foreignId('seva_price_id');
                $table->foreign('seva_price_id')->references('id')->on('seva_prices')->onDelete('cascade');
                $table->integer('qty');
                $table->float('base_price', 10, 2)->default(0.00);
                $table->float('selling_price', 10, 2)->default(0.00);
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();            
            });
        }
        if(!Schema::hasTable('faqs')){
            Schema::create('faqs', function (Blueprint $table){
                $table->id();
                $table->longText('title');
                $table->longText('sub_title');
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();         
            });
        }
        if(!Schema::hasTable('testimonials')){
            Schema::create('testimonials', function (Blueprint $table){
                $table->id();
                $table->string('name');
                $table->string('profession');
                $table->foreignId('profile_pic_id')->nullable();
                $table->foreign('profile_pic_id')->references('id')->on('images')->onDelete('cascade');
                $table->longText('description');
                $table->boolean('is_active')->default(1);
                $table->timestamps();  
                $table->softDeletes();    
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('states');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('relations');
        Schema::dropIfExists('rasi');
        Schema::dropIfExists('images');
        Schema::dropIfExists('temples');
        Schema::dropIfExists('seva_types');
        Schema::dropIfExists('sevas');
        Schema::dropIfExists('seva_faqs');
        Schema::dropIfExists('seva_updates');
        Schema::dropIfExists('seva_prices');
        Schema::dropIfExists('events');
        Schema::dropIfExists('user_family_details');
        Schema::dropIfExists('user_addresses');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_sevas');
        Schema::dropIfExists('user_rewards');
        Schema::dropIfExists('user_cart');
        Schema::dropIfExists('seva_coupons');
        Schema::dropIfExists('anouncements');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
    }
}
