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
        Schema::table('expenses', function (Blueprint $table) {
            // Only drop if the column exists to avoid errors on some installs
            if (Schema::hasColumn('expenses', 'title')) {
                $table->dropColumn('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Restore the column as nullable string to match previous usage
            if (! Schema::hasColumn('expenses', 'title')) {
                $table->string('title')->nullable();
            }
        });
    }
};
