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

    //Listing friends of a user
    public function index() {
        $_SESSION["sql_dump"][]="___________________________________________________";

        $friObj = spClass("lib_friend");
        $moodObj = spClass("lib_mood");
    	$uid = $_SESSION["userinfo"]["uid"];

    	//Friends
    	//Friend (uid,uname, email, lname, fname)
    	$fris = $friObj->listing($uid);
    	$_SESSION["sql_dump"][]= $friObj->dumpSql();

    	//Retrive moods for each friends
		foreach($fris as &$fri){
		    //Moods
		    //Mood (fid, time, fname)
		    $fri["moods"] = $moodObj->listing($fri["uid"], 10);
            $_SESSION["sql_dump"][]= $moodObj->dumpSql();
		}
		$this->friends = $fris;
    }

	//Add new friends
	public function add(){
        $_SESSION["sql_dump"][]="___________________________________________________";
	    $friObj = spClass("lib_friend");
	    $uid = $_SESSION["userinfo"]["uid"];
	   	$uid2 = $_REQUEST["uid"];
	   	$condition = array("uid_1"=>$uid, "uid_2"=>$uid2);

	    $res = $friObj->create($condition);
	    $_SESSION["sql_dump"][]= $friObj->dumpSql();

	    $this->jump(spUrl("friends","index"));
	}

	//Remove friends
	public function remove(){
        $_SESSION["sql_dump"][]="___________________________________________________";
	    $friObj = spClass("lib_friend");

		$uid = $_SESSION["userinfo"]["uid"];
	   	$uid2 = $_REQUEST["uid"];
<<<<<<< HEAD
	   	$condition = array("uid_1"=>$uid, "uid_2"=>$uid2);

	    $res = $friObj->delete($condition);
	    $_SESSION["sql_dump"][]= $friObj->dumpSql();

	    $this->jump(spUrl("friends","index"));
=======
	   	$condition = array("uid_1"=>$uid, "uid_2"=>$uid2);	
	    $res = $friObj->delete($condition);
	    $_SESSION["sql_dump"][]= $friObj->dumpSql();
	    $condition = array("uid_1"=>$uid2, "uid_2"=>$uid);  
        $res = $friObj->delete($condition);
	    $_SESSION["sql_dump"][]= $friObj->dumpSql();
	    
	    $this->jump(spUrl("friends","index"));	
>>>>>>> d9cd325864a93501f7aba2dd9553552549e3da39
	}

	//View friendship between two users
	public function view() {

	}

	//Update friendship between two users
	public function update() {

	}

}
