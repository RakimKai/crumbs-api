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
        Schema::table('groups', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('description')->nullable();
            $table->integer('members_count')->default(1);
        });
    }
                    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
