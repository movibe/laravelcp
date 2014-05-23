<?php
class Todos extends \LaravelBook\Ardent\Ardent {
	protected $table = 'todos';
	
	public static $rules = array(
		'title' => 'required'
    );

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