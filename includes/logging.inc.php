<?php


class Log{

    public static function addLogEntry($sqlSession, $logMessage){

        $qry = $sqlSession->prepare("INSERT INTO logging (logvalue) 
        VALUES (:logentry)");
        $qry->execute(array(':logentry'=>$logMessage));

    }

}


?>