<?php
class lib_user extends spModel
{
	var $pk = "uid"; //User's primary key
	var $table = "users"; //Users table
	
	var $verifier = array( //User verification
		"rules" => array( //Rules
			'uname' => array(  //Only verify user name, because password is encipered.
				'notnull' => TRUE, //Not NULL
				'minlength' => 4,  //User name length > 1
				'maxlength' => 8  //User name length < 12
			),
			'upass' => array(
                 'minlength' => 4,
                 'maxlength' => 8
            ),
            'upass2' => array(
                 'equalto' => 'upass'
            ),
			'email' => array(
			     'notnull' => TRUE,
			     'email' => TRUE,
			),
			'lname' => array(
			     'notnull' => TRUE
			),
			'fname' => array(
			     'notnull' => TRUE
			),
			'birthday' => array(
			     'istime' => TRUE,
			)
		),
		"messages" => array( //Prompt
			'uname' => array(
				'notnull' => "User Name can not be NULL",
				'minlength' => "Size of User Name must larger than 4",
				'maxlength' => "Size of User Name must less than 8"
			),
			'upass' => array(
                 'minlength' => "Size of password must larger than 4",
                 'maxlength' => "Size of password must less than 8"
            ),
            'upass2' => array(
                 'equalto' => "Password comfirmation error"
            ),
			'email' => array(
			     'notnull' => "Emaill address can not be NULL",
			     'email' => "Email address format error"
			),
			'lname' => array(
			     'notnull' => "Last name can NOT be NULL"
			),
			'fname' => array(
			     'notnull' => "First name can not be NULL"
			),
			'birthday' => array(
			     'istime' => "Birthday format error"
			)
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
    
    public function create($row){
        $row["upass"] = md5($row["upass"]);
        $row = array_merge($row, array("aclrole"=>'m'));
        return parent::create($row);
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