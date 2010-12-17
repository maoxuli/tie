<?php
class lib_friend extends spModel
{
	var $pk = "fid"; //primative key
	var $table = "friends"; // table

    //Automatic add status and datetime
    public function create($row){
        $row = array_merge($row, array("status"=>'1', "time"=>date("Y-m-d H:i:s")));
        return parent::create($row);
    }
    
    //Retrive friends for user
    public function listing($uid){
        $sql = "SELECT users.uid, users.uname, users.email, users.lname, users.fname FROM "
                . "users, friends WHERE friends.status='1' AND ((friends.uid_1='" . $uid 
                . "' AND friends.uid_2=users.uid) OR (friends.uid_2='" . $uid 
                . "' AND friends.uid_1=users.uid)) ORDER BY users.uname";
        return $this->_db->getArray($sql);
    }
}