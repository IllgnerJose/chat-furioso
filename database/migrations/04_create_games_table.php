<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GameStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_1_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('team_2_id')->constrained('teams')->onDelete('cascade');
            $table->integer('team_1_score')->default(0);
            $table->integer("team_2_score")->default(0);
            $table->string("status")->default(GameStatus::Scheduled->value);
            $table->integer("rounds")->default(0);
            $table->dateTime('game_date');
            $table->dateTime('game_start')->nullable();
            $table->dateTime('game_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
