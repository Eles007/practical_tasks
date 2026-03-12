<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false)->after('is_published');
            $table->index(['is_approved', 'is_published', 'published_at']);
        });

        DB::table('posts')->update(['is_approved' => true]);
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['is_approved', 'is_published', 'published_at']);
            $table->dropColumn('is_approved');
        });
    }
};

