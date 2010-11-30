<?php

/*
 * Functions around friendship among users
 * - Add friend to a user
 * - Remove friend from a user 
 * - View friendship of two users
 * - Update friendship of two users
 * - Listing friends of a user
 * 
 */

class friends extends spController
{
	//Listing friends
	public function listing(){
	    
	    $uid = $_SESSION["userinfo"]["uid"];
	    $condition = array("uid_1"=>$uid);
	    
        $this->results = spClass("lib_friend")->findAll($condition);
	}
    
	//Add new friends
	public function add(){
	    		
	}
	
	//Remove friends
	public function remove(){

	}
	
	//View friendship
	public function view(){

	}
} 