<?php
class Comment extends \LaravelBook\Ardent\Ardent {
	public static $rules = array(
		'content' => 'required|min:3'
    );
	
	public function content()
	{
		return nl2br($this->content);
	}

	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function post()
	{
		return $this->belongsTo('Post');
	}

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function date($date=null)
    {
        if(is_null($date)) {
            $date = $this->created_at;
        }

        return String::date($date);
    }

    public function created_at()
    {
        return $this->date($this->created_at);
    }

    public function updated_at()
    {
        return $this->date($this->updated_at);
    }

    public function delete()
    {
		$id=$this->id;
		if(!parent::delete()) return false;
		return !$this->find($id) ? true : false;
    } 

}