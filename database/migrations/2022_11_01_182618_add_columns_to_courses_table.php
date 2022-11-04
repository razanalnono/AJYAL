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
        Schema::table('courses', function (Blueprint $table) {
            $table->text("description")->nullable();
            $table->integer('hour_count')->default(0);
            $table->enum('status', ['لاغي', 'مكتمل', 'قيد التنفيذ'])->default('قيد التنفيذ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('hour_count');
            $table->dropColumn('status');
        });
    }
};
