<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_details', function (Blueprint $table) {
            $table->id();

            $table->string('reporting_person');
            $table->string('mobile_num',50);
            $table->string('email',200);
            $table->text('subject');
            $table->text('message');
            $table->unsignedSmallInteger('sent_to_member_id')->nullable();

            $table->timestamps();


            $table->foreign('sent_to_member_id','fk_email_details_sent_to_member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_details', function (Blueprint $table) {
            //
        });
    }
}
