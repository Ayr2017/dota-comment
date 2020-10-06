<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComments4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_4', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->default(null);
            $table->foreignId('parent_id')->constrained('comments_3');
            $table->text('text');
            $table->integer('rating')->default(0);
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('comments_4');
    }
}
