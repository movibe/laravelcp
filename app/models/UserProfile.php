<?php
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;

class UserProfile  extends Eloquent {

	protected $table = 'user_profiles';
	public static $unguarded = true;
	public function user()
    {
        return $this->belongsTo('User');
    }
}