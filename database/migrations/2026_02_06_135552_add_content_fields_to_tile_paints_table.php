<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tile_paints', function (Blueprint $table) {
            $table->json('images')->nullable()->after('paint_order');
            $table->text('inspiration_video')->nullable()->after('images');
            $table->text('brief_implementation')->nullable()->after('inspiration_video');
            $table->text('where_to_buy')->nullable()->after('brief_implementation');
            $table->text('expert_help')->nullable()->after('where_to_buy');
            $table->text('important_info')->nullable()->after('expert_help');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tile_paints', function (Blueprint $table) {
            $table->dropColumn([
                'images',
                'inspiration_video',
                'brief_implementation',
                'where_to_buy',
                'expert_help',
                'important_info',
            ]);
        });
    }
};
