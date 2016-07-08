<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCredendial extends Model
{
	protected $userID;

	public function __construct($u)
	{
		$this->userID = $u;
	}

    public function can($action)
    {
    	$a = UserCredentials::where('userid', $this->userID)->where('not_allowed', $action)->first();

    	try {
		    	$a = UserCredentials::where('userid', $this->userID)->where('not_allowed', $action)->first();
        		return true;
	    } catch(ModelNotFoundException $e) {
	        return false;
	    }
    }

}
