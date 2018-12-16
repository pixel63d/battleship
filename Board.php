<?php
// Класс определяющий состояние доски и расстоновки кораблей

class Board
{
    private $x;

    private $y;

    private $matrix;

    private $id;

    private $name;

    private $ships=[];

    public function __construct($name, $x = 10, $y = 10)
    {
        $this->x = $x;
        $this->y = $y;
        $this->name=$name;
    }

    public function getX(){
        return $this->x;
    }

    public function getY(){
        return $this->y;
    }

    public function generate(){
        $this->matrix = [];

        for ($x = 0; $x < $this->x; $x++) {
            $this->matrix[$x] = [];

            for ($y = 0; $y < $this->y; $y++) {
                $this->matrix[$x][$y] = 0;
            }
        }
    }

    public function addShip(Ship $ship){
        $this->ships[]=$ship;
        foreach ($ship->getCoords() as $oneCooord){
            $this->matrix[$oneCooord['x']][$oneCooord['y']]=1;
        }
    }

    public function save(){
        $json=json_encode($this->matrix);
//        file_put_contents(__DIR__ . '/temp/'. $this->name, $json);
        //Вставка в БД
        $bD = new Bd();
        $bD->addBoard($this->name, $json );
    }

    public function update(){
        $json=json_encode($this->matrix);
//        file_put_contents(__DIR__ . '/temp/'. $this->name, $json);
        //Вставка в БД
        $bD = new Bd();
        $bD->updateBoard($this->name, $json );
    }

    public function load(){
        //$value=прочитать из файла
        //$this->matrix=json_decode($value);
//        $value = file_get_contents(__DIR__ . '/temp/'.$this->name);
        //ЧТЕНИЕ ИЗ БД
        $bD = new Bd();
        $value=$bD->loadBoard($this->name );
        $this->matrix=json_decode($value);
        return $this->matrix;
    }

    public function isFree($x, $y){
        if($this->matrix[$x][$y] != 0){
            return false;
        }

        return true;
    }
    public function shot($coordx, $coordy){
        if ($this->matrix[$coordx][$coordy] ==1){
            $this->matrix[$coordx][$coordy]=3;
            echo 'Попал ';
        }
        else{
            echo 'Мазила';
        }
        $this->update();

        $haveSheeps=false;
        foreach ($this->matrix as $x => $yarr){
            foreach ($yarr as $status){
                if($status ==1){
                    $haveSheeps=true;
                    break 2;
                }
            }
        }

        if($haveSheeps==false){
            echo 'Победил ' . $this->name;
        }
    }
}