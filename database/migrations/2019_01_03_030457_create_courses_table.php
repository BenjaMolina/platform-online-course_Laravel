<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Course;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('level_id');

            $table->string('name');
            $table->text('description');
            $table->string('column');
            $table->string('picture')->nullable();
            $table->enum('status',[
                Course::PUBLISHED,Course::PENDING,Course::REJECT
            ])->default(Course::PENDING);
            $table->boolean('previous_approved')->default(false);
            $table->boolean('previous_rejected')->default(false);

            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('level_id')->references('id')->on('levels');

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
        Schema::dropIfExists('courses');
    }
}
