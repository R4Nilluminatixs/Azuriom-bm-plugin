<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE = 'battlemetrics_bans';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->bigInteger('battlemetrics_user_id')->index()->nullable();
            $table->bigInteger('organization_id')->index();
            $table->bigInteger('battlemetrics_id')->unique();
            $table->string('steam_id')->nullable();
            $table->timestamp('timestamp');
            $table->string('reason');
            $table->mediumText('note')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->json('identifiers');
            $table->boolean('organization_wide');
            $table->boolean('auto_add_enabled');
            $table->boolean('native_enabled')->default(false);
            $table->timestamp('last_sync')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->noActionOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
