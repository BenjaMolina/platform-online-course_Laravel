<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use SoftDeletes; //SoftDelete

    const PUBLISHED = 1;
    const PENDING = 2;
    const REJECT = 3;


    //En cualquier consulta obtendra el numero de reviews y estudiantes
    protected $withCount = ['reviews', 'students'];

    //Ruta para obtener la imagen del curso
    public function pathAttachment()
    {
        return url("images/courses/" . $this->picture);
    }

    //Cambiamos el atributo con el que se manejara la inyeccion Implicita
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id', 'name');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class)->select('id', 'course_id', 'goal');
    }

    public function level()
    {
        return $this->belongsTo(Level::class)->select('id', 'name');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->select('id', 'user_id', 'course_id', 'raiting', 'comment', 'created_at');
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class)->select('id', 'coruse_id', 'requirement');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


    /*GETTERS (ACCESOR)*/
    //Obtiene el promedio del raiting de un curso, que se encuentra en la tabla reviews
    public function getRaitingAttribute()
    {
        return $this->reviews->avg('raiting');
    }


    //Obtenemos Cursos relacionados de acuerdo a un curso seleccionado
    public function relatedCourses()
    {
        return Course::with('reviews')
            ->whereCategoryId($this->category->id) /*Ver newQuery() laravel - Es una opcion mas corta de hacer un 'where', es igual a ->where('category_id, this->category->id)  */
            ->where('id', '!=', $this->id)
            ->latest()
            ->limit(6)
            ->get();
    }
}
