<?php

class Todos extends Eloquent {

	protected $table = 'todos';

    public function delete()
    {
		$id=$this->id;
		if(! parent::delete()) return false;
		return empty($this->find($id));
    } 

	public function assign(){
		$this->admin_id=Confide::user()->id;
        return $this->save();
	}

}