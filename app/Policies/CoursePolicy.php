<?php

namespace App\Policies;

use App\Role;
use App\User;
use App\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    //Puede optar por un curso?
    public function opt_for_course(User $user, Course $course)
    {

        // Puede si no es un teacher ó si el Id del maestro es diferente al del curso
        return !$user->teacher || $user->teacher->id !== $course->teacher->id;
    }

    //Pude suscribirse a un curso?
    public function subscribe(User $user)
    {

        //Si puede, si no es un administrador y si no esta suscrito a un plan (Casshier)
        return $user->role_id !== Role::ADMIN && !$user->subscribed('main');
    }

    //Puede inscribirse al curso?
    public function inscribe(User $user, Course $course)
    {

        //Solo si NO esta inscrito en el curso
        return !$course->students->contains($user->student->id);
    }

    public function review(User $user, Course $course)
    {
        return !$course->reviews->contains('user_id', $user->id);
    }
}
