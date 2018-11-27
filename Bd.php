<?php
/**
 * Created by PhpStorm.
 * User: pixel63d
 * Date: 27.11.18
 * Time: 23:23
 */

class Bd
{
    private $connect;

    public function __construct()
    {
        $this->connect = new mysqli('localhost', 'root', '121', 'battle');

    }

    public function addBoard($name, $coords){
        $add=$this->connect->query('INSERT INTO `board` (`id`, `name`, `coords`) VALUES (NULL, \''.$name.'\', \''.$coords.'\')');
        if(!$add){
            echo $this->connect->error;
        }
    }

    public function loadBoard($name){
        if ($result = $this->connect->query('SELECT * FROM `board` where `name`=\''.$name.'\'')) {
            $row = $result->fetch_assoc();
            $coords=$row['coords'];
            $result->close();
        }else{
            $coords=null;
        }

        return $coords;
    }
}
