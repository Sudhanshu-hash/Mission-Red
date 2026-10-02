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
        Schema::create('blood_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('requester_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('blood_group_id')
                ->constrained('blood_groups')
                ->restrictOnDelete();

            $table->unsignedSmallInteger('required_quantity');
            $table->unsignedSmallInteger('fulfilled_quantity')->default(0);

            $table->date('required_date');

            $table->string('urgency', 20);

            $table->string('region');
            $table->string('locality');

            $table->string('status', 20)->default('active');

            $table->timestamp('closed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};