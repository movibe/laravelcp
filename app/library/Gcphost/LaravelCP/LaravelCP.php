<?php namespace Gcphost\LaravelCP;
use Setting,User,Confide,Activity,Input,Mail,Config,Event, Lava, DB;
use Illuminate\Filesystem\Filesystem;

class LaravelCP {
	static private $email;

	static public function merge(){
		$rows=json_decode(Input::get('rows'));
		if(is_array($rows) && count($rows) > 0){
			if(count($rows) < 2) return Api::to(array('error',Lang::get('core.mergeerror'))) ? : \Response::json(array('result'=>'error', 'error' =>  Lang::get('core.mergeerror')));
			$_merge_to=false;
			foreach($rows as $i=>$r){
				if ($r != Confide::user()->id){
					$user = User::find($r);
					if(!empty($user)){
						if(!$_merge_to){
							$_merge_to=$user;
							continue;
						}
						if(!$user->merge($user)) return Api::to(array('error', 'Failed to delete ' . $r)) ? : \Response::json(array('result'=>'error', 'error' =>  'Failed to delete '.$r));
					} else  return Api::to(array('error', 'Could not find user '. $r)) ? : \Response::json(array('result'=>'error', 'error' =>  'Could not find user '. $r));
				}
			}
		}
		if(!Api::make(array('success'))) return \Response::json(array('result'=>'success'));
	}

	static public function runDeleteMass($r){
		if ($r != Confide::user()->id){
			$user = User::find($r);
			if(!empty($user)){
				Event::fire('controller.user.delete', array($user));
				$user->delete();
			} else return Api::to(array('error', '')) ? : \Response::json(array('result'=>'error', 'error' =>  ''));
		}
	}

	static public function emailTemplates(){
		$path=Config::get('view.paths');
		$fileSystem = new Filesystem;
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR.Theme::getTheme().DIRECTORY_SEPARATOR."emails");
		return $files;
	}

	static public function sendEmailContactUs(){
		$data=array(
			'body'=>'From:'. Input::get('name'). ' ('. Input::get('email') .')<br/><br/>'.Input::get('body'), 
			'subject'=>Input::get('subject'), 
			'email'=>Input::get('email'), 
			'name'=>Input::get('name'), 
			'to' => Setting::get('site.contact_email')
		);

		$send=Mail::later(60,Theme::path('emails/default'), $data, function($message)
		{
			$message->to($data['to'])->subject($data['subject']);
			$message->replyTo($data['email'], $data['name']);

		});

		return true;
	}

	static public function sendEmail($user, $template='emails.default', $delay=30){
		//if (!View::exists($template))$template='emails.default';
		
		Event::fire('controller.user.email', array($user));

		$data=array(
			'body'=>Input::get('body'), 
			'subject'=>Input::get('subject'), 
			'files'=>Input::file('email_attachment'), 
			'user' => $user,
			'to' => $user->email
		);
		$tpl=Theme::path(str_replace('.','/',$template));
		$send=Mail::later($delay, $tpl, $data, function($message) use ($data)
		{
			$message->to($data['to'])->subject($data['subject']);

			$files=$data['files'];
			if(count($files) > 1){
				foreach($files as $file) $message->attach($file->getRealPath(), array('as' => $file->getClientOriginalName(), 'mime' => $file->getMimeType()));
			} elseif(count($files) == 1) $message->attach($files->getRealPath(), array('as' => $files->getClientOriginalName(), 'mime' => $files->getMimeType()));

		});

		Activity::log(array(
			'contentID'   => $user->id,
			'contentType' => 'email',
			'description' => Input::get('subject'),
			'details'     => Input::get('body'),
			'updated'     => $user->id ? true : false,
		));

		return true;
	}
}
