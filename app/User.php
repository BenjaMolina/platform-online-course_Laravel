<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Role $role
 * @property-read \App\UserSocialAccount $socialAccount
 * @property-read \App\Student $student
 * @property-read \App\Teacher $teacher
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{   
    //Billable para laravel cashier
    use Notifiable, Billable;

    protected static function boot(){
        parent::boot();
        
        /*----Eventos----*/

        //Se ejecuta cuando SE ESTA CREANDO EL USUARIO el usuario
        static::creating(function(User $user){
            //Si no se esta creando un usuario desde la terminal (seeders)
            if(!\App::runningInConsole()){
                $user->slug = str_slug($user->name. " ". $user->last_name, "-");
            }
        });


        /*----Eventos----*/
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    
    public static function navigation() {
        return auth()->check() ? auth()->user()->role->name : 'guest';
    }


    /* Relaciones */
    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function student(){
        return $this->hasOne(Student::class);
    }

    public function teacher(){
        return $this->hasOne(Teacher::class);
    }

    public function socialAccount(){
        return $this->hasOne(UserSocialAccount::class);
    }
}
