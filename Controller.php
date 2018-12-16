<?php
/**
 * Created by PhpStorm.
 * User: pixel63d
 * Date: 22.11.18
 * Time: 23:26
 */

class Controller
{
    function route(){
        if(isset($_GET['action']) && $_GET['action']=='start'){
            if (isset($_GET['name']) && !empty($_GET['name'])){
                $board=new Board($_GET['name']);
                $board->generate();

//Создаем 4х палубный корабль
                $board=$this->addShip($board, 4);

                for($i=0; $i<2; $i++){
                    $board=$this->addShip($board, 3);
                }

                for($i=0; $i<3; $i++){
                    $board=$this->addShip($board, 2);
                }

                for($i=0; $i<4; $i++){
                    $board=$this->addShip($board, 1);
                }

                $board->save();
            }
            else{
                echo 'Enter name';
            }


        }
        if(isset($_GET['action']) && $_GET['action']=='play'){
            $this->showPlayHtml();
        }
        if (isset($_GET['action']) && $_GET['action']=='shot'){
            if (isset($_GET['name']) && !empty($_GET['name'])){
                if (isset($_GET['enemy']) && !empty($_GET['enemy']) ){
                    if (isset($_GET['coordx']) && isset($_GET['coordy'])){
                        $board=new Board($_GET['enemy']);
                        $board->load();
                        $board->shot($_GET['coordx'], $_GET['coordy']);
                    }
                    else{
                        echo 'координаты не введены';
                    }
                }
                else{
                    echo 'Введите имя противника';
                }
            }
            else{
                echo ' Введите имя';
            }
        }
        else{
            $this->showIndexHtml();
        }
    }


    function showIndexHtml(){

        $html = '
<html>
    <head></head>
    <body>
        <form method="get">
            <input type="text" name="name"/>
            <input type="submit" value="отправить"/>
            <input type="hidden" name="action" value="start"/>
        </form>        
        <br />
        <a href="xyindex.php?action=play">играть</a>
    </body>
</html>
            ';
        echo $html;
    }

    function showPlayHtml(){

        $html = '
<html>
    <head></head>
    <body>
        <form method="get">
        имя<br/>
            <input type="text" name="name"/><br/>
            
            координата х<br/>
            <input type="text" name="coordx"/><br/>
            
            координата y<br/>
            <input type="text" name="coordy"/><br/>
            
            имя противника<br/>
            <input type="text" name="enemy"/><br/>
            <input type="submit" value="отправить"/>
            <input type="hidden" name="action" value="shot"/>
        </form>        
    </body>
</html>
            ';
        echo $html;
    }


    /**
     * @param $board
     */
    function addShip(Board $board, $type)
    {
        do {
            $shipPlaced = true;

            $ship = new Ship($type, $board->getX(), $board->getY());
            $coords = $ship->getCoords();

            foreach ($coords as $oneCoord) {
                if ($board->isFree($oneCoord['x'], $oneCoord['y']) != true) {
                    $shipPlaced = false;
                }
            }

        } while ($shipPlaced == false);

        $board->addShip($ship);
        return $board;
    }
}