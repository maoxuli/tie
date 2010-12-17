<?php

/*
 * Functions around matching
 * 
 */

class matching extends spController
{
    
    //Listing matching
    public function index(){
        
        $_SESSION["sql_dump"][]="___________________________________________________";
                $moodObj = spClass("lib_mood");
        $uid = $_SESSION["userinfo"]["uid"];
        
        $this->results = $moodObj->matching($uid, 8);
        $_SESSION["sql_dump"][]= $moodObj->dumpSql();
    }
}