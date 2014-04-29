<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;

class Todos  extends Eloquent {

	protected $table = 'todos';
	public static $unguarded = true;

}