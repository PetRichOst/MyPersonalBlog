<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class User extends Authenticatable
{
    use Notifiable;

    const IS_ADMIN = 1;
    const IS_USER = 0;
    const IS_BANNED = 1;
    const IS_UNBANNED = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new static();

        $user->fill($fields);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if ($image == null) {
            return;
        }

        $this->removeAvatar();

        $fileName = str_random(10).'.'.$image->extension();
        Image::make($image->getRealPath())
            ->resize(100, 100)
            ->save('uploads/usersAvatar/'.$fileName);
        $this->avatar = $fileName;
        $this->save();
    }

    public function getAvatar()
    {
        if ($this->avatar == null) {
            return '/img/no-avatar.jpg';
        }

        return '/uploads/usersAvatar/'.$this->avatar;
    }

    public function makeAdmin()
    {
        $this->is_admin = self::IS_ADMIN;
    }

    public function makeNormal()
    {
        $this->is_admin = self::IS_USER;
    }

    public function toggleAdmin($value)
    {
        if ($value == null) {
            return $this->makeNormal();
        }

        return $this->makeAdmin();
    }

    public function makeStatusBan()
    {
        $this->is_admin = self::IS_BANNED;
    }

    public function makeStatusUnban()
    {
        $this->is_admin = self::IS_UNBANNED;
    }

    /**
     * @param $value
     */
    public function toggleBan($value)
    {
        if ($value == null) {
            return $this->makeStatusUnban();
        }

        return $this->makeStatusBan();
    }

    /**
     * @param $password
     */
    public function generatePassword($password)
    {
        if ($password != null) {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    public function removeAvatar()
    {
        if ($this->avatar != null) {
            Storage::delete('uploads/usersAvatar/'.$this->avatar);
        }
    }
}
