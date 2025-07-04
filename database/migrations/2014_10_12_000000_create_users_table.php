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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('role', 100);
            $table->foreignId('role_id')->constrained('roles')->onDelete('set null'); // Add foreign key for roles
            $table->string('email')->unique();
            $table->integer('status')->nullable();
            $table->string('name')->nullable();
            $table->text('skills')->nullable();
            $table->text('social_links')->nullable();
            $table->text('about')->nullable();
            $table->string('photo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
