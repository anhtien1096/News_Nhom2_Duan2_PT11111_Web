<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'parent', 'description', 'order', 'add_to_menu'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'add_to_menu'   => 'boolean',
        'status'        => 'boolean',
    ];

    /**
     * Virtual attribute for Category model
     * @var array
     */
    protected $appends = [
        'count',
    ];

    public function getCountAttribute()
    {
        if ($this->attributes['parent'] == 0) {
            return $this->where([
                    ['parent', $this->attributes['id']],
                ])->get()->count();
        }
        return '0';
    }

    /**
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = trim(title_case($name));
    }

    /**
     * @param $slug
     */
    public function setSlugAttribute($slug)
    {
        $this->attributes['slug'] = str_slug(trim(!empty($slug) ? $slug : $this->attributes['name']));
    }

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = !empty($value) ? $value : '';
    }

    /**
     * @param $value
     */
    public function setParentAttribute($value)
    {
        $this->attributes['parent'] = !empty($value) ? $value : 0;
    }

    /**
     * @param $value
     */
    public function setAddToMenuAttribute($value)
    {
        $this->attributes['add_to_menu'] = $value;
    }

    /**
     * @param $value
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return makeTimeAgo($value);
    }

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return makeTimeAgo($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getParentAttribute($value)
    {
        foreach (Categories::select('id', 'name')
                     ->where([
                         ['parent', 0],
                         ['status', 1]
                     ])->get() as $v) :
            if ($v->id == $value) {
                return $v->name;
            }
        endforeach;
        return 'Trống';
    }
    
    public function posts()
    {
        return $this->hasManyThrough('App\Posts', 'App\Categories', 'id', 'cate_id')->orderBy('created_at', 'desc')->limit(5);
    }

    public function children()
    {
        return $this->hasMany('App\Categories', 'parent')->where('add_to_menu', '=', '1');
    }
}
