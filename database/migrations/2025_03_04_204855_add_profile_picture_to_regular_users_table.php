
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('regular_users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('email'); // Add profile_picture column
        });
    }

    public function down()
    {
        Schema::table('regular_users', function (Blueprint $table) {
            $table->dropColumn('profile_picture'); // Remove the column if migration is rolled back
        });
    }
};
