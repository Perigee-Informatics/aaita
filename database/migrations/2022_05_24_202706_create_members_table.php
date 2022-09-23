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
            $table->string('nrn_number')->nullable();
            $table->string('first_name',200);
            $table->string('middle_name',200)->nullable();
            $table->string('last_name',200);
            $table->string('photo_path',500)->nullable();
            $table->boolean('is_other_country')->default(false);
            $table->unsignedSmallInteger('country_id')->nullable();
            $table->unsignedSmallInteger('province_id')->nullable();
            $table->unsignedSmallInteger('district_id')->nullable();

            $table->boolean('channel_wsfn')->default(false);
            $table->boolean('channel_wiw')->default(false);
            $table->boolean('channel_foreign')->default(false);

            $table->string('membership_type')->nullable();
            $table->unsignedSmallInteger('international_publication')->default(0);
            $table->unsignedSmallInteger('national_publication')->default(0);

            $table->json('current_organization');
            $table->json('past_organization');
            $table->json('doctorate_degree');
            $table->json('masters_degree');
            $table->json('bachelors_degree');
            $table->json('awards');
            $table->json('expertise');
            $table->json('affiliation');
            $table->string('mailing_address',500)->nullable();
            $table->string('phone',200)->nullable();
            $table->string('email',500)->nullable();
            $table->string('link_to_google_scholar',1000)->nullable();

            $table->foreign('gender_id','fk_members_gender_id')->references('id')->on('mst_gender');
            $table->foreign('country_id','fk_members_country_id')->references('id')->on('mst_country');
            $table->foreign('province_id','fk_members_province_id')->references('id')->on('mst_fed_province');
            $table->foreign('district_id','fk_members_district_id')->references('id')->on('mst_fed_district');

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
