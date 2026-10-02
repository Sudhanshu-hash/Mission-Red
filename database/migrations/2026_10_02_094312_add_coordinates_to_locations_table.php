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
        Schema::table('locations', function (Blueprint $table) {
            $table->geography('coordinates', subtype: 'POINT', srid: 4326)
                ->nullable()
                ->after('longitude');
        });

        DB::statement('
            CREATE INDEX locations_coordinates_gist_index
            ON locations
            USING GIST (coordinates)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('
            DROP INDEX IF EXISTS locations_coordinates_gist_index
        ');

        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('coordinates');
        });
    }
};