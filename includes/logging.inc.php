<?php


class Log{

    public static function addLogEntry($sqlSession, $logMessage, $userid){

        $qry = $sqlSession->prepare("INSERT INTO logging (logvalue, usersid) 
        VALUES (:logentry, :userId)");
        $qry->execute(array(':logentry'=>$logMessage, ':userId'=>$userid));

    }

}


?>