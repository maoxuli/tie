<?php

/*
 * Functions around matching
 * 
 */

class matching extends spController
{
    
    //Listing matching
    public function index(){
        
        $moodObj = spClass("lib_mood");
        $uid = $_SESSION["userinfo"]["uid"];
        
        $this->results = $moodObj->matching($uid, 8);
        $this->sql_dump = $moodObj->dumpSql();
        //dump($this->results);
    }
}