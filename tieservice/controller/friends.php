<?php

/*
 * Functions around friendship among users
 * - Add friends to a user
 * - Remote friends from a user
 * - listing friends of a user
 * - listing candidate friends of a user 
 */

class friends extends spController
{
	//Listing friends
	public function slisting(){
	    
	    $uid = $_SESSION["userinfo"]["uid"];
	    $condition = array("uid_1"=>$uid);
	    
        $this->results = spClass("lib_friend")->findAll($condition);
	}
	
	//Waiting list
	public function waiting(){
	    
	}
    
	//Add new friends
	public function add(){
	    		
	}
	
	//Remove friends
	public function remove(){

	}
	
	//View friend
	public function sview(){
	    $uid = $this->spArgs("uid");
	    $condition = array("uid"=>$uid);
        $this->result = spClass("lib_user")->find($condition);
	}
} 