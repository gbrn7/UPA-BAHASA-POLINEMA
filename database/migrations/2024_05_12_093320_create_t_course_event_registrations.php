<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_course_event_registrations', function (Blueprint $table) {
            $table->id('course_event__registrations_id');
            $table->unsignedBigInteger('course_event_schedule_id')->index();
            $table->string('name');
            $table->string('email');
            $table->string('phone_num');
            $table->string('address');
            $table->string('goal')->nullable();
            $table->text('experience')->nullable();
            $table->string('ktp_or_passport_img');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(('course_event_schedule_id'))->references('course_event_schedule_id')->on('r_course_event_schedule')->cascadeOnUpdate();
            $table->foreign(('created_by'))->references('user_id')->on('d_user');
            $table->foreign(('updated_by'))->references('user_id')->on('d_user');
            $table->foreign(('deleted_by'))->references('user_id')->on('d_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_course_event__registrations');
    }
};
