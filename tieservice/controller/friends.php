<?php
class friends extends spController
{
	//Friends List
	public function listing(){
	    
        //Retrieve friends list, and pass to page via results
        $this->results = spClass("lib_friend")->spPager($this->spArgs("page",1),5)->findAll(null,"time DESC","uid_1,uid_2,status,time");
        
        //Pages information
        $this->pager = spClass("lib_friend")->spPager()->getPager();
	}
	
	//Waiting list
	public function waiting(){
	    
	}
	
	//Matching list
	public function matching(){
	    
	}

    //Details of a friends
    public function view(){

    }
    
	//Add new friends
	public function add(){
	    		
	}
	
	//Remove friends
	public function remove(){

	}
} 