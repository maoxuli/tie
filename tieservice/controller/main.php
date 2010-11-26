<?php
import('md5password.php');
class main extends spController
{
	//Log In
	public function login(){
		$userObj = spClass("lib_user"); //Model lib_user
		if( $uname = $this->spArgs("uname") ){ //Submit, log in
			$upass = spClass("md5password")->pwvalue(); //Get encipered password via md5password
			
			//Check user name and password
			$rows = array('uname' => $uname, 'upass' => $upass);
			$results = $userObj->spVerifier($rows);
			
			if( false == $results ){ // flase, no illegle data
			
				//Log in
				if( false == $userObj->userLogin($uname, $upass) ){
					//Failed, return to login page
					$this->error("User Name or Password is wrong!", spUrl("main","login"));
					
				}else{
					//Succeed, redirect to proper page
					$useracl = spClass("spAcl")->get(); //Current user access role
					if('a' == $useracl ){
						$this->jump(spUrl("users","listing"));
					}else{
						$this->jump(spUrl("moods","home"));
					}
				}
			}else{
				//User name and password check failed.
				//dump($results);
				foreach($results as $item){ //Rules
					foreach($item as $msg){ 
						// Errors, first is enough
						$this->error($msg,spUrl("main","login"));
					}
				}
			}
		}
		//Not submit, auto redirect to main/login.html
	}
	
	//Log out
	public function logout(){
		//Delete session
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {setcookie(session_name(), '', time()-42000, '/');}
		session_destroy();
		//Return to homepage
		$this->jump(spUrl("main","login"));
	}
	
	//User Register
	public function register(){
		$userObj = spClass("lib_user"); //Model lib_user, access table of users
        if( $uname = $this->spArgs("uname") ){ //Submit, register
            $upass = $this->spArgs("upass");
            $upass2 = $this->spArgs("upass2");
            $email = $this->spArgs("email");
            
            //Check user name and password and email
            $rows = array('uname' => $uname, 'upass' => $upass, 'upass2' => $upass2, 'email' => $email);
            $results = $userObj->spVerifier($rows);
            
            if( false == $results ){ // flase, no illegle data
            
                //Register
                if( false == $userObj->userRegister($uname, $upass, $email) ){
                    //Failed, return to register page
                    $this->error("Register failed! Please try again.", spUrl("main","register"));
                    
                }else{
                    //Succeed, redirect to proper page
                    $this->jump(spUrl("main","login"));
                }
            }else{
                //User name and password check failed.
                //dump($results);
                foreach($results as $item){ //Rules
                    foreach($item as $msg){ 
                        // Errors, first is enough
                        $this->error($msg,spUrl("main","register"));
                    }
                }
            }
        }
        //Not submit, auto redirect to main/register.html
	}
	
    //User Setting
    public function setting(){
    }
} 