<?php

class UserNotes  extends Eloquent {

	protected $table = 'user_notes';
	public static $unguarded = true;
	public function user()
    {
        return $this->belongsTo('User');
    }
}