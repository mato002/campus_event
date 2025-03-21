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
        Schema::table('regular_users', function (Blueprint $table) {
            $table->string('verification_code')->nullable();
            $table->boolean('is_verified')->default(false);
        });
                    //
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regular_users', function (Blueprint $table) {
            //
        });
    }
};
