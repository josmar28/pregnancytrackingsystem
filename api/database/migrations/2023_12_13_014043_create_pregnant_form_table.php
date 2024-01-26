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
        Schema::create('pregnant_form', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id',50)->unique();
            $table->string('code',50);
            $table->integer('referring_facility');
            $table->integer('referred_by');
            $table->string('record_no');
            $table->dateTime('referred_date');
            $table->integer('referred_to');
            $table->dateTime('arrival_date');
            $table->string('health_worker');
            $table->integer('patient_woman_id');
            $table->string('educ_attainment');
            $table->string('family_income');
            $table->string('religion');
            $table->string('ethnicity');
            $table->string('sibling_rank');
            $table->string('out_of');
            $table->integer('gravidity');
            $table->integer('parity');
            $table->integer('ftpal');
            $table->integer('bmi');
            $table->integer('fundic_height');
            $table->integer('hr');
            $table->integer('rr');
            $table->dateTime('lmp');
            $table->dateTime('edc_edd');
            $table->integer('height');
            $table->integer('weight');
            $table->text('bp');
            $table->integer('temp');
            $table->dateTime('td1');
            $table->dateTime('td2');
            $table->dateTime('td3');
            $table->dateTime('td4');
            $table->dateTime('td5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnant_form');
    }
};
