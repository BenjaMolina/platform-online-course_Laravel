<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Course
 *
 * @property-read \App\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Goal[] $goals
 * @property-read \App\Level $level
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Requirement[] $requirements
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 * @property-read \App\Teacher $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course query()
 * @mixin \Eloquent
 */
class Course extends Model
{
    const PUBLISHED = 1;
    const PENDING = 2; 
    const REJECT = 3;


    //Ruta para obtener la imagen del curso
    public function pathAttachment() {
        return "images/courses/". $this->picture;
    }

    public function category(){
        return $this->belongsTo(Category::class)->select('id','name');
    }

    public function goals(){
        return $this->hasMany(Goal::class)->select('id','course_id','goal');
    }

    public function level(){
        return $this->belongsTo(Level::class)->select('id','name');
    }

    public function reviews(){
        return $this->hasMany(Review::class)->select('id','user_id','course_id','raiting','comment','created_at');
    }

    public function requirements(){
        return $this->hasMany(Requirement::class)->select('id','coruse_id','requirement');
    }

    public function students(){
        return $this->belongsToMany(Student::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }


    /*GETTERS */
    //Obtiene el promedio del raiting de un curso, que se encuentra en la tabla reviews
    public function getRaitingAttribute(){
        return $this->reviews->avg('raiting');
    }
}
