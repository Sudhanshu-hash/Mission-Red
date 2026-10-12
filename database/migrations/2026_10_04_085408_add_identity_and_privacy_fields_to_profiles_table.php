<?php

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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('profile_image_path')
                ->nullable()
                ->after('phone');

            $table->timestamp('phone_verified_at')
                ->nullable()
                ->after('profile_image_path');

            $table->boolean('email_private')
                ->default(true)
                ->after('phone_verified_at');

            $table->boolean('phone_private')
                ->default(true)
                ->after('email_private');

            $table->timestamp('last_seen_at')
                ->nullable()
                ->after('phone_private');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn([
                'profile_image_path',
                'phone_verified_at',
                'email_private',
                'phone_private',
                'last_seen_at',
            ]);
        });
    }
};