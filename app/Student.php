<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Student
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Course[] $courses
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student query()
 * @mixin \Eloquent
 */
class Student extends Model
{

    protected $fillable = [
        'user_id', 'title',
    ];

    protected $appends = ['courses_formatted']; //Se retorna cuando se usa el metodo GET (Getters)

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'role_id', 'name', 'email');
    }

    //GETTERS
    public function getCoursesFormattedAttribute()
    {
        return $this->courses->pluck('name')->implode('<br>');
    }
}
