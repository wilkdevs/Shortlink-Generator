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
        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Foreign key to links table
            $table->uuid('link_id');
            $table->foreign('link_id')
                  ->references('id')
                  ->on('links')
                  ->onDelete('cascade');

            $table->string('payload')->nullable();
            $table->string('ip', 45)->nullable(); // supports IPv4/IPv6
            $table->string('country', 100)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
