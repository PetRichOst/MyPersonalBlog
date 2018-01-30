<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Tester\CommandTester;

class Comment extends Model
{
    const IS_ENABLED = 1;
    const IS_DISABLED = 0;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function allow()
    {
        $this->status = Comment::IS_ENABLED;
        $this->save();
    }

    public function disallow()
    {
        $this->status = Comment::IS_DISABLED;
        $this->save();
    }

    public function toggleStatus()
    {
        if ($this->status == Comment::IS_DISABLED)
            return $this->allow();

        return $this->disallow();
    }

    public function remove()
    {
        $this->delete();
    }

    public function getDate()
    {
        return Carbon::createFromFormat('d/m/y', $this->created_at)->format('F d, Y');
    }
}
