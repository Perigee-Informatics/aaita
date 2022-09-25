<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedSmallInteger('gender_id');
            $table->date('dob_ad');
            $table->string('dob_bs',10);
            $table->string('full_name',200);
            $table->string('photo_path',500)->nullable();
            $table->string('mailing_address',500)->nullable();
            $table->string('phone',200)->nullable();
            $table->string('email',500)->nullable();
            $table->unsignedSmallInteger('province_id')->nullable();
            $table->unsignedSmallInteger('district_id')->nullable();
            $table->unsignedSmallInteger('local_level_id')->nullable();
            $table->unsignedSmallInteger('ward')->nullable()->default(0);
            
            $table->boolean('is_other_country')->default(false);
            
            $table->unsignedSmallInteger('current_province_id')->nullable()->default(NULL);
            $table->unsignedSmallInteger('current_district_id')->nullable()->default(NULL);
            $table->unsignedSmallInteger('current_local_level_id')->nullable()->default(NULL);
            $table->unsignedSmallInteger('current_ward')->nullable()->default(0);
            
            $table->unsignedSmallInteger('current_country_id')->nullable();
            $table->string('city_of_residence',200)->nullable();

            $table->json('current_organization');
            $table->json('highest_degree');
            $table->json('ait_study_details');
     
            $table->json('expertise');
            $table->json('affiliation')->nullable();
           
            $table->string('link_to_google_scholar',1000)->nullable();
            $table->string('document_path',500)->nullable();
            $table->string('bio',500)->nullable();

            $table->unsignedSmallInteger('status')->default(1);

            $table->foreign('gender_id','fk_members_gender_id')->references('id')->on('mst_gender');
            $table->foreign('current_country_id','fk_members_current_country_id')->references('id')->on('mst_country');

            $table->foreign('province_id','fk_members_province_id')->references('id')->on('mst_fed_province');
            $table->foreign('district_id','fk_members_district_id')->references('id')->on('mst_fed_district');
            $table->foreign('local_level_id','fk_members_local_level_id')->references('id')->on('mst_fed_local_level');

            $table->foreign('current_province_id','fk_members_current_province_id')->references('id')->on('mst_fed_province');
            $table->foreign('current_district_id','fk_members_current_district_id')->references('id')->on('mst_fed_district');
            $table->foreign('current_local_level_id','fk_members_current_local_level_id')->references('id')->on('mst_fed_local_level');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
