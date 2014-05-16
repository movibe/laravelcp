<?php

use Illuminate\Support\Facades\URL; 
use Illuminate\Filesystem\Filesystem;

class Post extends Eloquent {

	public function user()
    {
		return $this->belongsTo('User');
    }

	public function templates(){
		$path=Config::get('view.paths');
		$fileSystem = new Filesystem;
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR.Theme::getTheme().DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'layouts');
		return $files;
	}

	public function parents(){
		return array_merge(array('0'=>''),DB::table('posts')->orderBy('title', 'asc')->lists('title','id'));
	}

    public function delete()
    {
		$id=$this->id;
		$this->comments()->delete();
		if(!parent::delete()) return false;
		return empty($this->find($id));
    } 

	public function content()
	{
		return nl2br($this->content);
	}

	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function comments()
	{
		return $this->hasMany('Comment');
	}

    public function date($date=null)
    {
        if(is_null($date)) {
            $date = $this->created_at;
        }
		if(!$date) $date=Carbon::now();
        return String::date($date);
    }

	public function url()
	{
		return Url::to($this->slug);
	}

	public function created_at()
	{
		return $this->date($this->created_at);
	}

	public function updated_at()
	{
        return $this->date($this->updated_at);
	}
}
