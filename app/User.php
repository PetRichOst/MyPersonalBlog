<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        $user = new static;

        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
        $this->save();
    }

    public function remove()
    {
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if ($image == null)
            return;

        Storage::delete('uploads/' . $this->image);
        $fileName = str_random(10).'.'.$image->extenson();
        $image->saveAs('uploads', $fileName);
        $this->image = $fileName;
        $this->save();
    }

    public function getAvatar()
    {
        if ($this->image == null)
            return 'img/no-avatar.png';

        return 'uploads/' . $this->image;
    }

    public function makeAdmin()
    {
        $this->is_admin = User::IS_ADMIN;
    }

    public function makeNormal()
    {
        $this->is_admin = User::IS_USER;
    }

    public function toggleAdmin($value)
    {
        if ($value == null)
            return $this->makeNormal();

        return $this->makeAdmin();
    }

    public function makeStatusBan()
    {
        $this->is_admin = User::IS_BANNED;
    }

    public function makeStatusUnban()
    {
        $this->is_admin = User::IS_UNBANNED;
    }

    public function toggleBan($value)
    {
        if ($value == null)
            return $this->makeStatusUnban();

        return $this->makeStatusBan();
    }
}
