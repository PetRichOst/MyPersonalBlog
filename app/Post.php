<?php

namespace App;

use App\Tag;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Intervention\Image\ImageManagerStatic as Image;

class Post extends Model
{
    use Sluggable;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;
    const IS_STANDARD = 1;
    const IS_FEATURED = 0;

    protected $fillable = [
        'title',
        'content',
        'date',
        'description'
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
        return $this->belongsTo(Category::class);
    }

    public function getCategoryTitle()
    {
        return ($this->category != null)
            ? $this->category->title
            : 'Нет категории';
    }

    public function getCategorySlug()
    {
        return ($this->category != null)
            ? $this->category->slug
            : 'no-category';
    }

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags(){
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
    }

    public function getImplodeTagsTitles()
    {
        return (!$this->tags->isEmpty())
            ? implode(', ', $this->tags->pluck('title')->all())
            : 'Нет тегов';
    }

    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();

        return $post;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    public function uploadImage($image)
    {
        if ($image == null)
            return;

        $this->removeImage();

        $fileName = str_random(10).'.'.$image->extension();
        Image::make($image->getRealPath())->resize(500, 500)->save('uploads/'.$fileName);
//        Image::make($image->getRealPath())->resize(1000, 800)->save('uploads/'.$fileName);
        $this->image = $fileName;
        $this->save();
    }

    public function getImage()
    {
        if ($this->image == null)
            return 'img/no-avatar.png';

        return '/uploads/' . $this->image;
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

        return $this->setStandard();
    }

    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');

        $this->attributes['date'] = $date;
    }
    public function getDateAttribute($value)
    {
         return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');

    }

    public function removeImage()
    {
        if ($this->image != null){
            Storage::delete('uploads/' . $this->image);
        }
    }

    public function getDate()
    {
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }

    public function hasPrevious()
    {
        return self::where('id', '<', $this->id)->max('id');
    }

    public function getPrevious()
    {
        return self::find($this->hasPrevious());
    }

    public function hasNext()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getNext()
    {
        return self::find($this->hasNext());
    }

    public function related()
    {
        return self::all()->except($this->id);
    }

    public function hasCategory()
    {
        return ($this->category_id != null)
            ? true
            : false;
    }
}
