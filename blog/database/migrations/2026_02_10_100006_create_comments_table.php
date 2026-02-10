<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('post_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('author');
            $table->string('email');
            $table->string('url')->nullable();
            $table->text('content');

            $table->enum('status', ['pending', 'approved'])
                ->default('pending')
                ->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
