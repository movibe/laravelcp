<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;

class AssignedRole extends Eloquent {
	
	protected $table = 'assigned_roles';
	public static $unguarded = true;
	public function user()
    {
		return $this->belongsTo('User');
    }
}