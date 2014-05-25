<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallLaravelCP extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:install_laravelcp';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install LaravelCP';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->info('===== Installation Started ===== ');
		
		$name=$this->argument('name');
		$email=$this->argument('email');
		$password=$this->argument('password');
		$role=$this->argument('role');
		$roles=array('admin','manager','client','site_user');

		while(!$name) $name = $this->ask('- What is your first and last name? ');

		while(!$email){
			$email = $this->ask('- What is your e-mail address? ');
			if(DB::table('users')->where('email', '=', $email)->count() >  0){
				$this->error('E-mail already used, try again.');
				$email='';
			}
		}
		
		while(!$password) $password = $this->secret('- What is the password you want to use? ');

		while(!in_array($role, $roles)) $role = $this->secret('- What is the role do you want to have? ['.implode('|', $roles).']? ');

		if ($this->argument('confirm') || $this->confirm('- Do you wish to continue? [yes|no] '))
		{

			if(DB::table('users')->where('email', '=', $email)->count() >  0) return $this->error('E-mail already used, try again.');
				
			$users = array(
				array(
					'email'      => $email,
					'displayname'      => $name,
					'username'      => $email,
					'password'   => Hash::make($password),
					'confirmed'   => 1,
					'confirmation_code' => md5(microtime().Config::get('app.key')),
				)
			);

			if(!DB::table('users')->insert( $users )) return $this->error('Unable to add user to table!');

			$roleModel = new Role;

			$user = User::where('email','=',$email)->first();
			$user->attachRole( $roleModel->byName($role)->id );

			$this->info('===== Installation Complete ===== ');

		} else $this->error('Maybe next time!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', InputArgument::OPTIONAL, 'Users full name'),
			array('email', InputArgument::OPTIONAL, 'Users e-mail'),
			array('password', InputArgument::OPTIONAL, 'Users password'),
			array('role', InputArgument::OPTIONAL, '[admin|manager|client|site_user]'),
			array('confirm', InputArgument::OPTIONAL, 'yes'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return(array());
		/*return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);*/
	}

}
