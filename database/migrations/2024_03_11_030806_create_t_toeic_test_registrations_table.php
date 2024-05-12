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
        Schema::create('t_toeic_test_registrations', function (Blueprint $table) {
            $table->id('toeic_test_registrations_id');
            $table->unsignedBigInteger('toeic_test_events_id')->index();
            $table->string('name');
            $table->string('nim');
            $table->string('nik');
            $table->string('departement');
            $table->string('program_study');
            $table->string('semester');
            $table->string('email');
            $table->string('phone_num');
            $table->string('ktp_img');
            $table->string('ktm_img');
            $table->string('surat_pernyataan_iisma');
            $table->string('pasFoto_img');
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign(('toeic_test_events_id'))->references('toeic_test_events_id')->on('r_toeic_test_events')->cascadeOnUpdate();
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
        Schema::dropIfExists('t_registrations');
    }
};
