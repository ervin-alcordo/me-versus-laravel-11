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
        Schema::create('system_wide_parts', function (Blueprint $table) {
            $table->id();
            $table->string('active')->default('Y');
            $table->string('model_number');
            $table->decimal('list_price', 8, 2);
            
            $table->unsignedBigInteger('part_type_id'); 
            $table->unsignedBigInteger('manufacturer_id'); 
            
            $table->foreign('part_type_id')
                ->references('id')->on('part_type')
                ->onDelete('cascade');

            $table->foreign('manufacturer_id')
                ->references('id')->on('manufacturer')
                ->onDelete('cascade');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_wide_parts');
    }
};
