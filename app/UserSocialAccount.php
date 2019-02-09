<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserSocialAccount
 *
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSocialAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSocialAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSocialAccount query()
 * @mixin \Eloquent
 */
class UserSocialAccount extends Model
{
    

    public function user(){
        return $this->belongsTo(User::class);
    }
}
