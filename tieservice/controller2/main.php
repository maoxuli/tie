<?php

/* 
 * Basic functions around a user
 * - Register a user
 * - Login/Logout
 * - View user's information
 * - Update user's information
 * - Listing users (For administrator)
 * 
 */

import('md5password.php');
class main extends spController
{
    //User Register
    public function register(){
        
        $uname = $this->spArgs("uname");
        $upass = $this->spArgs("upass");
        $upass2 = $this->spArgs("upass2");
        $email = $this->spArgs("email");
        $lname = $this->spArgs("lname");
        $fname = $this->spArgs("fname");
        
        $userObj = spClass("lib_user"); //Model lib_user, access table of users
        
        //Check user name and password and email
        $rows = array('uname' => $uname, 'upass' => $upass, 'upass2' => $upass2, 'email' => $email);
        $results = $userObj->spVerifier($rows);
        
        if( false == $results ){ // flase, no illegle data
        
            //Register
            if( false == $userObj->userRegister($uname, $upass, $email, $lname, $fname) ){
                //Failed
                
                
            }else{
                //Succeed, redirect to proper page
                
            }
        }else{
            //User name and password check failed.
            //dump($results);
            foreach($results as $item){ //Rules
                foreach($item as $msg){ 
                    // Errors, first is enough
                    
                }
            }
        }
    }
    
    //Log  in
    public function login(){
        
        $uname = $this->spArgs("uname");
        $upass = $this->spArgs("upass");
        
        $userObj = spClass("lib_user"); //Model lib_user
        
        //Check user name and password
        $rows = array('uname' => $uname, 'upass' => $upass);
        $results = $userObj->spVerifier($rows);
            
        if( false == $results ){ // flase, no illegle data
        
            //Log in
            if( true == $userObj->userLogin($uname, $upass) ){
                //Failed
                $this->result = "OK";
            }
            else {
                $this->result = "FALSE";
            }
         }
         else{
            //User name and password check failed.
            $this->result = "FAULSE";
         }    
    }
	
	//Log out
	public function logout(){
		//Delete session
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {setcookie(session_name(), '', time()-42000, '/');}
		session_destroy();
		//Return
	}
	
	//View user
	public function view(){
	    //User id
        $uid = $_SESSION["userinfo"]["uid"];
        $condition = array("uid"=>$uid);
        $this->result = spClass("lib_user")->find($condition);
	}
	
	//Update user
	public function update(){
	    
	}
	
	//Listing users
	public function users(){
	    
	}
} 