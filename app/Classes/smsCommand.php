<?php namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use SMS;
use Auth;
class smsCommand{

	private $user;
	private $command;
	private $response = "I cannot let you do that, Dave. (for commands, respond -g help)";
	// private $commandArray = call_user_func_array('help'=>[$this, 'help']);

	

	public function __construct($command = null, $user = null)
	{
		$this->command = $command;
		$this->user = $user;
	}

	public function process()
	{

		switch(strtolower($this->command))
		{
			case "help":
				$this->help();
				break;
			case "stop gotd":
				$this->stopGotd();
				break;
			case "gimme gotd":
				$this->startGotd();
				break;
			case "yeah":
				$this->verifyPhoneNumberReceive();
				break;

		}

		return $this->response;
	}

	private function help()
	{
		$commandArray = ['help','stop gotd','gimme gotd'];
		$availCommands = "Available commands are: ";
		$prefix = '';
        foreach ($commandArray as $command) {
            $availCommands .= $prefix . $command;
            $prefix = ', ';
        }
		$this->response = $availCommands;
	}
	private function stopGotd()
	{
		$user = $this->user;
		if($user->gifOfTheDay)
		{
			$user->gifOfTheDay = false;
			$user->save();
			$this->response = 'No longer receiving gifs of the day :(';
		}
		else
		{
			$this->response = "Already set to not receive gifs of the day. To receive them again, respond -g gimme gotd";
		}

	}

	private function startGotd()
	{
		$user = $this->user;
		$user->gifOfTheDay = true;
		$user->save();
		$this->response = "Now receiving gifs of the day! :)";
	}


	public function verifyPhoneNumberReceive()
	{
		$user = $this->user;
		$user->verified = true;
		$user->save();
		SMS::send('SMS.blank', ['theMessage'=>'Sweet! Thanks for signing up :) respond back to me with any word to search for a gif'], function($sms) use ($user){
            $sms->to($user->phoneNumber);
        });
       
	}

	public function verifyPhoneNumberSend()
	{	
		if(empty($this->user))
		{
			$this->user = Auth::user();
		}
			
		if(!$this->user->verified)
		{
			$user = $this->user;
			SMS::send('SMS.blank', ['theMessage'=>'Are you legit and want daily gifs? Reply back with the word: yeah '], function($sms) use ($user){
	            $sms->to($user->phoneNumber);
	        });
	    }
	}
}
