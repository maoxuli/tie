<?php
class lib_user extends spModel
{
	var $pk = "uid"; //User's primary key
	var $table = "users"; //Users table
	
	var $verifier = array( //User verification
		"rules" => array( //Rules
			'uname' => array(  //Only verify user name, because password is encipered.
				'notnull' => TRUE, //Not NULL
				'minlength' => 2,  //User name length > 1
				'maxlength' => 12  //User name length < 12
			),
		),
		"messages" => array( //Prompt
			'uname' => array(
				'notnull' => "User Name can not be NULL",
				'minlength' => "Size of User Name must larger than 1",
				'maxlength' => "Size of User Name must less than 12"
			),
		)
	);
	
	/**
	 * Function of Log In
	 *
	 * @param uname    User Name
	 * @param upass    Password, cipered password with MD5
	 */
	public function userLogin($uname, $upass){ 
		$conditions = array(
			'uname' => $uname,
			'upass' => $upass, //Cipered password with MD5
		);
		// dump($conditions);
		// Log In
		if( $result = $this->find($conditions, null, "uid, uname, email, aclrole") ){ 
			// Log in successfully. Get user role
			spClass('spAcl')->set($result['aclrole']); // Set user role in ACL
			$_SESSION["userinfo"] = $result; //Set user info in session
			return true;
		}else{
			// Log in failed
			return false;
		}
	}
	
    /**
     * Function of Register
     *
     * @param uname    User Name
     * @param upass    Password, cipered password with MD5
     * @param email    Email address
     */
    public function userRegister($uname, $upass, $email, $lname, $fname){ 
        $row = array(
            "uname"=>$uname,
            "email"=>$email,
            "upass"=>md5($upass),
            "aclrole"=>"m",
            "lname"=>lname,
            "fname"=>fname,
        );
        parent::create($row);
        return true;
    }
	
	/**
	 * Redirect without rights
	 */
	public function acljump(){ 
		// Prompt of redirection, code from spController.php
		$url = spUrl("main","login");
		echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>function sptips(){alert(\"You have no rights, please log in!\");location.href=\"{$url}\";}</script></head><body onload=\"sptips()\"></body></html>";
		exit;
	}
	
   /**
     * Redirect without rights
     */
    public function acljump2(){ 
        // Prompt of redirection, code from spController.php
        $url = spUrl("main","login");
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><tie><response><code>0</code><message>You have no rights, please log in!</message><location>$url</location></response></tie>";
        exit;
    }
}