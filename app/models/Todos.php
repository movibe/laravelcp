<?php
class Todos extends Eloquent {
	protected $table = 'todos';

	public function assign(){
		$this->admin_id=Confide::user()->id;
        return $this->save();
	}

	public function delete()
    {
		$id=$this->id;
		if(!parent::delete()) return false;
		return !$this->find($id) ? true : false;
    } 
}