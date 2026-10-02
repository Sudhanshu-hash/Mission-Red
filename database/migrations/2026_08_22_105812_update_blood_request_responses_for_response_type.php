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
        Schema::table('blood_request_responses', function (Blueprint $table) {
            $table->renameColumn('donor_id', 'user_id');

            $table->string('response_type', 20)
                ->after('user_id');

            $table->unsignedSmallInteger('quantity')
                ->nullable()
                ->change();
        });

        Schema::table('blood_request_responses', function (Blueprint $table) {
            $table->dropUnique([
                'blood_request_id',
                'donor_id',
            ]);

            $table->unique([
                'blood_request_id',
                'user_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_request_responses', function (Blueprint $table) {
            $table->dropUnique([
                'blood_request_id',
                'user_id',
            ]);
        });

        Schema::table('blood_request_responses', function (Blueprint $table) {
            $table->renameColumn('user_id', 'donor_id');

            $table->dropColumn('response_type');

            $table->unsignedSmallInteger('quantity')
                ->nullable(false)
                ->change();
        });

        Schema::table('blood_request_responses', function (Blueprint $table) {
            $table->unique([
                'blood_request_id',
                'donor_id',
            ]);
        });
    }
};