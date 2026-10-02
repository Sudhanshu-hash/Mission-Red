<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blood_request_responses', function (Blueprint $table) {
            $table->unique(
                ['blood_request_id', 'user_id'],
                'blood_request_responses_request_user_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('blood_request_responses', function (Blueprint $table) {
            $table->dropUnique(
                'blood_request_responses_request_user_unique'
            );
        });
    }
};