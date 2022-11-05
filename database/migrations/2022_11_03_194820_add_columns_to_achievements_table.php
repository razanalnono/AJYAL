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
        Schema::table('achievements', function (Blueprint $table) {
            $table->foreignId('platform_id')->constrained('platforms')->onDelete('cascade');
            $table->string('job_title');
            $table->text('job_description')->nullable();
            $table->string('attachment')->nullable();
            $table->string('job_link')->nullable();
            $table->float('salary');
            $table->enum('status', ['مكتمل', 'قيد التنفيذ'])->default('قيد التنفيذ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn('job_title');
            $table->dropColumn('job_description');
            $table->dropColumn('attachment');
            $table->dropColumn('job_link');
            $table->dropColumn('salary');
            $table->dropColumn('status');
        });
    }
};
