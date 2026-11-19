
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->dateTime('purchase_date');
            $table->decimal('price', 10, 2);
            $table->string('ticket_type', 50);

            $table->foreignId('visitor_id')
                ->constrained('visitors')
                ->cascadeOnDelete();

            $table->foreignId('exhibition_id')
                ->constrained('exhibitions')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
