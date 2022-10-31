<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['مستقل', 'upwork', 'freelancer', 'خمسات', 'other'])->default('other');
            $table->string('other')->nullable();
            $table->string('description');
            $table->float('income');
            $table->foreignId('group_id')->constrained('groups')->cascadeOnDelete();
            $table->foreignId('trainee_id')->constrained('trainees')->cascadeOnDelete();
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
        Schema::dropIfExists('achievements');
    }
};