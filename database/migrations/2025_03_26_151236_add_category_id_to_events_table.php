<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the category_id column already exists
        if (!Schema::hasColumn('events', 'category_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            });
        }

        // Migrate the existing category data to category_id
        DB::transaction(function () {
            $categories = Category::all(); // Get all categories from the Category table

            foreach ($categories as $category) {
                $events = \App\Models\Event::where('category', $category->name)->get();

                foreach ($events as $event) {
                    // Map the event to the category_id
                    $event->category_id = $category->id;
                    $event->save();
                }
            }
        });

        // Drop the old category column after migration
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert changes in case of rollback
        Schema::table('events', function (Blueprint $table) {
            $table->string('category'); // Re-add the old category column
            $table->dropForeign(['category_id']); // Remove the foreign key
            $table->dropColumn('category_id'); // Drop the category_id column
        });
    }
};
