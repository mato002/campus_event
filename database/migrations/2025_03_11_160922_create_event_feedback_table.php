<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('event_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');  // Foreign key to events table
            $table->foreignId('regular_user_id')->constrained('regular_users')->onDelete('cascade'); // Foreign key to regular_users table
            $table->integer('rating'); // Rating (e.g., 1-5)
            $table->text('comment')->nullable(); // Feedback comment
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_feedback');
    }
}
