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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique();  // Setting name (e.g., 'site_name')
        $table->string('value');  // Setting value (e.g., 'Campus Events')
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('settings');
}

};
