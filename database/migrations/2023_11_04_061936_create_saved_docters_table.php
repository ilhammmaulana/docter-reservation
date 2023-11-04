<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedDoctersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_docters', function (Blueprint $table) {
            $table->foreignUuid('docter_id')->constrained('docters')->onDelete('cascade');
            $table->foreignUuid('created_by')->constrained('users')->onDelete('cascade');
            $table->unique(['created_by', 'docter_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_docters');
    }
}
