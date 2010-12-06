<?php
class lib_mood extends spModel
{
    var $pk = "uid"; //primative key
    var $table = "moods"; // table

    //Automatic add datetime
    public function create($row){
        $row = array_merge($row, array("time"=>date("Y-m-d H:i:s")));
        parent::create($row);
    }
    
    //Retrive moods for user
    public function listing($uid, $limit){
        $sql = "select moods.time, feelings.fid, feelings.fname from "
                . "moods, feelings where moods.uid=" . $uid 
                . " and moods.fid=feelings.fid order by moods.time DESC limit " . $limit;
        return $this->_db->getArray($sql);
    }
    
    //Matching
    public function matching($uid, $limit){
        
        $m = $this->find(array("uid"=>$uid), "time DESC", "fid");
        $sql = "select u.uid, u.uname, u.email, u.lname, u.fname, m.time, f.fname "
            . "from users u, moods m, feelings f "   
            . "where not exists(select 1 from moods where uid = m.uid and time > m.time) "
            . "and u.uid=m.uid and m.fid=f.fid and u.uid != " . $uid
            . " order by abs(m.fid-" . $m["fid"] . ") ASC limit " . $limit;
        return $this->_db->getArray($sql);
    }
}