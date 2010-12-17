<?php
class lib_mood extends spModel
{
    var $pk = "mid"; //primative key
    var $table = "moods"; // table
    
    //Automatic add datetime
    public function create($row){
        $row = array_merge($row, array("time"=>date("Y-m-d H:i:s")));
        return parent::create($row);
    }
    
    //Retrive moods for user
    public function listing($uid, $limit){
        $sql = "SELECT moods.time, feelings.fid, feelings.fname FROM "
                . "moods, feelings WHERE moods.uid='" . $uid 
                . "' AND moods.fid=feelings.fid ORDER BY moods.time DESC LIMIT " . $limit;
        return $this->_db->getArray($sql);
    }
    
    //Matching
    public function matching($uid, $limit){
        
        $m = $this->find(array("uid"=>$uid), "time DESC", "fid");
        $sql = "SELECT u.uid, u.uname, u.email, u.lname last_name, u.fname first_name, m.time, f.fname "
            . "FROM users u, moods m, feelings f "   
            . "WHERE not exists(SELECT 1 FROM moods WHERE uid = m.uid AND time > m.time) "
            . "AND u.uid=m.uid AND m.fid=f.fid AND u.uid != '" . $uid
            . "' ORDER BY abs(m.fid-" . $m["fid"] . ") ASC LIMIT " . $limit;
        return $this->_db->getArray($sql);
    }
}