<?php
use Gcphost\Helpers\User\UserRepository as User;

class AdminEmailController extends BaseController {
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;

    }

	 public function getEmails($user){
        if ( $user->id )
        {
			$list = $user->emails();

			if(Api::Enabled()){
				$u=$list->get();
				return Api::make($u->toArray());
			} else return Datatables::of($list)
				 ->edit_column('updated_at','{{{ Carbon::parse($updated_at)->diffForHumans() }}}')
				->edit_column('details','{{{ strip_tags(substr($details,0,100))}}}')
				->make();
		}
	 }
   
    public function getIndex($user)
    {
        if ( $user->id )
        {
        	$title = $user->email;
        	$mode = 'edit';
			$templates=LCP::emailTemplates();
        	return Theme::make('admin/users/send_email', compact('user', 'title', 'mode', 'templates'));
        } else return Api::to(array('error', Lang::get('admin/users/messages.does_not_exist'))) ? : Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
    }

    public function postIndex($user=false)
    {
		$title = Lang::get('core.email');

		if(is_array(Input::get('to')) && count(Input::get('to')) >0){
			$_results=false;
			foreach (Input::get('to') as $user_id){
				$user=$this->user->find($user_id);
				if(!empty($user)) {
					$_results=LCP::sendEmail($user, Input::get('template'));
				} else $_results=false;
			}
			if($_results == true){
				$message=Lang::get('admin/users/messages.email.success');
				return Theme::make('admin/users/email_results', compact('title','message', '_results'));
			} else {
				$message=Lang::get('admin/users/messages.email.error');
				return Theme::make('admin/users/email_results', compact('title','message', '_results'));
			}
		} elseif (isset($user))
        {
			if(LCP::sendEmail($user, Input::get('template'))) {
				return Api::to(array('success', Lang::get('admin/users/messages.email.success'))) ? : Redirect::to('admin/users/' . $user->id . '/email')->with('success', Lang::get('admin/users/messages.email.success'));
			} else return Api::to(array('error', Lang::get('admin/users/messages.email.error'))) ? : Redirect::to('admin/users/' . $user->id . '/email')->with('error', Lang::get('admin/users/messages.email.error'));
		} else {
			$message=Lang::get('admin/users/messages.email.error');
			Theme::make('admin/users/email_results', compact('title','message'));
		}
    }

	public function getEmailMass($a=false){
		$ids=explode(',',rtrim(Input::get('ids'),','));
		$multi=array();
		if(is_array($ids) && count($ids) > 0){
			foreach($ids as $id){
				$user=$this->user->find($id);
				if(!empty($user)) $multi[$id]=$user->email;
			}
		}
		$title = Lang::get('core.email');
		$mode = 'edit';
		$templates=LCP::emailTemplates();
		return Theme::make('admin/users/send_email', compact('title','mode', 'multi', 'templates'));
	}
}