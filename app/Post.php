<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;
    const IS_STANDARD = 0;
    const IS_FEATURED = 1;

    protected $fillable = [
        'title',
        'content'
    ];
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category()
    {
        return $this->hasOne(Catagery::class);
    }

    public function author(){
        return $this->hasOne(User::class);
    }

    public function tags(){
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }

    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();

        return $post;
    }

    public function edit($fields, $id)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    public function uploadImage($image)
    {
        if ($image == null)
            return;

        Storage::delete('uploads/' . $this->image);
        $fileName = str_random(10).'.'.$image->extenson();
        $image->saveAs('uploads', $fileName);
        $this->image = $fileName;
        $this->save();
    }

    public function setCategory($id)
    {
        if($id == null)
            return;

        $this->category_id = $id;
        $this->save();
    }

    public function setTags($ids)
    {
        if ($ids == null)
            return;

        $this->tags()->sync($ids);
    }

    public function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save();
    }

    public function toggleStatus($value)
    {
        if($value == null){
            return $this->setDraft();
        }

        return $this->setPublic();
    }

    public function setFeatured()
    {
        $this->is_featured = Post::IS_FEATURED;
        $this->save();
    }

    public function setStandard()
    {
        $this->is_featured =  Post::IS_STANDARD;
        $this->save();
    }

    /**
     * @param $value
     */
    public function toggleFeatured($value)
    {
        if($value == null){
            return $this->setFeatured();
        }

        return $this->setStandart();
    }

    public function getImage()
    {
        if ($this->image == null)
            return 'img/no-image.png';

        return 'uploads/' . $this->image;
    }
}
