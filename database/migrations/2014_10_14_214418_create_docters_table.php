<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docters', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('address');
            $table->foreignUuid('subdistrict_id')->constrained('subdistricts', 'id');
            $table->string('description')->nullable(true);
            $table->string('phone')->nullable()->unique();
            $table->string('photo')->default(null)->nullable();
            $table->foreignUuid('category_docter_id')->constrained('category_docters', 'id');
            $table->string('password');
            $table->boolean('status_opration')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('docters');
    }
}
