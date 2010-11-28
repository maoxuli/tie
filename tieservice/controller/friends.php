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
	public function listing(){
	    
        //Retrieve friends list, and pass to page via results
        $this->results = spClass("lib_friend")->spPager($this->spArgs("page",1),5)->findAll(null,"time DESC","uid_1,uid_2,status,time");
        
        //Pages information
        $this->pager = spClass("lib_friend")->spPager()->getPager();
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
} 