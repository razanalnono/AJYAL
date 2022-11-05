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
        Schema::table('trainees', function (Blueprint $table) {
            $table->float('carriage_price')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['ملتحق', 'منتهي'])->default('ملتحق');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainees', function (Blueprint $table) {
            $table->dropColumn('carriage_price');
            $table->dropColumn('address');
            $table->dropColumn('status');
        });
    }
};
