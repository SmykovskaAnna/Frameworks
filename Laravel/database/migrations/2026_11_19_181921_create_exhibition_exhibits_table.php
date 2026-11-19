
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exhibition_exhibits', function (Blueprint $table) {
            $table->id();
            $table->integer('display_order');

            $table->foreignId('exhibition_id')
                ->constrained('exhibitions')
                ->cascadeOnDelete();

            $table->foreignId('exhibit_id')
                ->constrained('exhibits')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibition_exhibits');
    }
};
