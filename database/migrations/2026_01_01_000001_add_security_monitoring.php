<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->integer('tab_switches')->default(0);
            $table->timestamp('last_this_activity_at')->nullable(); // Renamed to avoid confusion with internal Laravel updates
            $table->string('kick_reason')->nullable();
        });
    }

    public function down()
    {
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->dropColumn(['tab_switches', 'last_this_activity_at', 'kick_reason']);
        });
    }
};
