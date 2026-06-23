<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $defaults = [
            ['key' => 'base_mode', 'value' => 'light'],
            ['key' => 'primary_hue', 'value' => '#635bff'], // Default MatDash Blue
            ['key' => 'base_container_bg', 'value' => '#f9fafb'],
            ['key' => 'base_text_color', 'value' => '#0b0f19'],
            ['key' => 'header_bg_color', 'value' => '#ffffff'],
            ['key' => 'sidebar_bg_color', 'value' => '#ffffff'],
            ['key' => 'heading_color', 'value' => '#111827'],
            ['key' => 'card_bg_color', 'value' => '#ffffff'],
        ];

        foreach ($defaults as $default) {
            DB::table('settings')->updateOrInsert(['key' => $default['key']], [
                'value' => $default['value'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
