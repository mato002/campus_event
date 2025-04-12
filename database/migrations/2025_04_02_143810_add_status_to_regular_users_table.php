<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('regular_users', function (Blueprint $table) {
            $table->boolean('status')->default(0); // 0 = Inactive, 1 = Active
        });
    }

    public function down()
    {
        Schema::table('regular_users', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
