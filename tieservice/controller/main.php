<?php

/* 
 * Basic functions of current user
 * - Register a user
 * - Login/Logout
 * - View user's information
 * - Update user's information
 * - Current user's moods management
 * - Listing users (For administrator)
 * 
 */

import('md5password.php');
class main extends spController
{
    //Current user's moods management
    public function index() {
        
        $feelingObj = spClass("lib_feeling");
        $userObj = spClass("lib_user");
        $moodObj = spClass("lib_mood");
        $uid = $_SESSION["userinfo"]["uid"];
        $this->sql_dump = "";
        
        //Submit capture feeling
        if($fid = $this->spArgs("fid")) {
            
            $condition = array("uid"=>$uid, "fid"=>$fid);
            $moodObj->create($condition);
            $this->sql_dump = $moodObj->dumpSql() . "\n";
        }
        
        //Display homepage for current user
        //Retrive all feelings, list for choice
        $this->feelings = $feelingObj->findAll();
        $this->sql_dump = $this->sql_dump . $feelingObj->dumpSql() . "\n";
        
        //Current user's info
        $condition = array("uid"=>$uid);
        $this->profile = $userObj->find($condition);
        $this->sql_dump = $this->sql_dump . $userObj->dumpSql() . "\n";
        
        //user's moods data
        $this->moods = $moodObj->listing($uid, 8);
        $this->sql_dump = $this->sql_dump . $moodObj->dumpSql();
        //dump($this->sql_dump);
    }
    
    //User Register
    public function register(){
        $userObj = spClass("lib_user"); //Model lib_user, access table of users
        if( $uname = $this->spArgs("uname") ){ //Submit, register
            $upass = $this->spArgs("upass");
            $upass2 = $this->spArgs("upass2");
            $email = $this->spArgs("email");
            $lname = $this->spArgs("lname");
            $fname = $this->spArgs("fname");
            
            //Check user name and password and email
            $rows = array('uname' => $uname, 'upass' => $upass, 'upass2' => $upass2, 'email' => $email);
            $results = $userObj->spVerifier($rows);
            
            if( false == $results ){ // flase, no illegle data
            
                //Register
                if( false == $userObj->userRegister($uname, $upass, $email, $lname, $fname) ){
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
    
	//Log In
	public function login(){
	    
		if($uname = $this->spArgs("uname")){ //Submit, log in
			$upass = spClass("md5password")->pwvalue(); //Get encipered password via md5password
			
			$userObj = spClass("lib_user"); //Model lib_user
			
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
						$this->jump(spUrl("main","users"));
					}else{
						$this->jump(spUrl("main","index"));
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
	
	//View user
	public function view(){
        //Current user id
        $userObj = spClass("lib_user");
        $uid = $_SESSION["userinfo"]["uid"];
        $condition = array("uid"=>$uid);
        $this->profile = $userObj->find($condition);
        $this->sql_dump = $userObj->dumpSql();
        //dump($this->sql_dump);
	}
	
	//Update user
	public function update(){
	    
        $userObj = spClass("lib_user");
	    $uid = $_SESSION["userinfo"]["uid"];
	    $this->sql_dump = "";
	    
	    if($uname = $this->spArgs("uname")) { //Submit update
	       $email = $this->spArgs("email");
	       $lname = $this->spArgs("lname");
	       $fname = $this->spArgs("fname");
	       $gender = $this->spArgs("gender");
	       $birthday = $this->spArgs("birthday");
	       $address = $this->spArgs("address");
	       $phone = $this->spArgs("phone");
	       
	       //Check values
	       
	       //
	       $condition = array("uid"=>$uid);
	       $row = array("uname"=>$uname, "email"=>$email, "lname"=>$lname, "fname"=>$fname,
	           "gender"=>$gender, "birthday"=>$birthday, "address"=>$address, "phone"=>$phone);
	       $userObj->update($condition, $row);
	       $this->sql_dump = $userObj->dumpSql() . "\n"; 
	       
	       //Updata session info and switch to view
           $_SESSION["userinfo"]["uname"] = $uname;
           $_SESSION["userinfo"]["email"] = $email;
	    }
	    
	    $condition = array("uid"=>$uid);
        $this->profile = $userObj->find($condition);
        $this->sql_dump = $this->sql_dump . $userObj->dumpSql();
        //dump($this->sql_dump);
	}
	
	//Listing users
	public function users(){
	    
	    $userObj = spClass("lib_user");
	    $this->results = $userObj->findAll();
	   
	}
} 