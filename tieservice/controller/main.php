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
        $_SESSION["sql_dump"][]="___________________________________________________";
                        
        //Submit capture feeling
        if($fid = $this->spArgs("fid")) {
            
            $row = array("uid"=>$uid, "fid"=>$fid);
            $moodObj->create($row);
            $_SESSION["sql_dump"][]= $moodObj->dumpSql();
        }
        
        //Display homepage for current user
        //Retrive all feelings, list for choice
        $this->feelings = $feelingObj->findAll();
        $_SESSION["sql_dump"][]= $userObj->dumpSql();
        
        //user's moods data
        $this->moods = $moodObj->listing($uid, 10);
        $_SESSION["sql_dump"][]= $userObj->dumpSql();
    }
    
    //User Register
    public function register(){
        $userObj = spClass("lib_user"); //Model lib_user, access table of users
        $_SESSION["sql_dump"][]="___________________________________________________";
                                                
        if( $uname = $this->spArgs("uname") ){ //Submit, register
            $upass = $this->spArgs("upass");
            $upass2 = $this->spArgs("upass2");
            $email = $this->spArgs("email");
            $lname = $this->spArgs("lname");
            $fname = $this->spArgs("fname");
            $birthday = $this->spArgs("birthday");
            $gender = $this->spArgs("gender");
            $address = $this->spArgs("address");
            $phone = $this->spArgs("phone");
             
            //Check user name and password and email
            $row = array('uname' => $uname, 
                          'upass' => $upass, 
                          'upass2' => $upass2, 
                          'email' => $email,
                          'lname' => $lname,
                          'fname' => $fname,
                          'birthday' => $birthday,
                          );
            $results = $userObj->spVerifier($row);
            if( false == $results ){ // flase, no illegle data
            
                //Register
                $row = array_merge($row, array("gender"=>$gender,"address"=>$address,"phone"=>$phone));
                $res = $userObj->create($row);
                $_SESSION["sql_dump"][]= $userObj->dumpSql();
                if( false == $res ){
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
	    
        $_SESSION["sql_dump"][]="___________________________________________________";
	    	    	    	    	    	    
		if($uname = $this->spArgs("uname")){ //Submit, log in
			$upass = spClass("md5password")->pwvalue(); //Get encipered password via md5password
			
			$userObj = spClass("lib_user"); //Model lib_user
			
			//Check user name and password
			$rows = array('uname' => $uname, 'upass' => $upass);
			
			if( false == $results ){ // flase, no illegle data
			
				//Log in
				$res = $userObj->userLogin($uname, $upass);
				$_SESSION["sql_dump"][]= $userObj->dumpSql();
				if( false == $res ){
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
        $_SESSION["sql_dump"][]="___________________________________________________";
                                                
        $condition = array("uid"=>$uid);
        $this->profile = $userObj->find($condition);
        $_SESSION["sql_dump"][]= $userObj->dumpSql();
	}
	
	//Update user
	public function update(){
	    
        $userObj = spClass("lib_user");
	    $uid = $_SESSION["userinfo"]["uid"];
        $_SESSION["sql_dump"][]="___________________________________________________";
	    	    	    	    	                
	    if($uname = $this->spArgs("uname")) { //Submit update
	       $email = $this->spArgs("email");
	       $lname = $this->spArgs("lname");
	       $fname = $this->spArgs("fname");
	       $gender = $this->spArgs("gender");
	       $birthday = $this->spArgs("birthday");
	       $address = $this->spArgs("address");
	       $phone = $this->spArgs("phone");
	       
	       //Check values
           $row = array('uname' => $uname, 
              'upass' => "dummy", 
              'upass2' => "dummy", 
              'email' => $email,
              'lname' => $lname,
              'fname' => $fname,
              'birthday' => $birthday,
              );
	       $results = $userObj->spVerifier($row);
           if( false == $results ){ // flase, no illegle data
            
    	       //Update
    	       $condition = array("uid"=>$uid);
    	       $row = array("uname"=>$uname, "email"=>$email, "lname"=>$lname, "fname"=>$fname,
    	           "gender"=>$gender, "birthday"=>$birthday, "address"=>$address, "phone"=>$phone);
    	       $res = $userObj->update($condition, $row);
    	       $_SESSION["sql_dump"][]= $userObj->dumpSql();
    	       
    	       if(true == $res)
    	       {      
        	       //Updata session info and switch to view
                   $_SESSION["userinfo"]["uname"] = $uname;
                   $_SESSION["userinfo"]["email"] = $email;
                   $this->jump(spUrl("main","view"));
    	       }
           }else{
                //User name and password check failed.
                //dump($results);
                foreach($results as $item){ //Rules
                    foreach($item as $msg){ 
                        // Errors, first is enough
                        $this->error($msg,spUrl("main","update"));
                    }
                }
            }
	    }
	    
	    $condition = array("uid"=>$uid);
        $this->profile = $userObj->find($condition);
        $_SESSION["sql_dump"][]= $userObj->dumpSql();
	}
	
	//Listing users
	public function users(){
	    
	    $userObj = spClass("lib_user");
        $_SESSION["sql_dump"][]="___________________________________________________";
	    	    	    	    	    
	    $this->results = $userObj->spPager($this->spArgs("page",1),10)->findAll();
	    $_SESSION["sql_dump"][]= $userObj->dumpSql();
	    $this->pager = $userObj->spPager()->getPager();
	}
	
	//delete user
	public function delete(){
	    $userObj = spClass("lib_user");
	    $uid = $this->spArgs("uid");
	    $condition = array("uid"=>$uid);
	    $userObj->delete($condition);
	    $_SESSION["sql_dump"][]= $userObj->dumpSql();
	    
	    $this->jump(spUrl("main","users"));
	}
} 