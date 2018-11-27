<?php
//корабли

class Ship
{
    private $type;
    private $maxX;
    private $maxY;

    private $coords = [];

    public function __construct($type, $maxX, $maxY)
    {
        $this->type=$type;
        $this->maxX=$maxX-1;
        $this->maxY=$maxY-1;
        $this->place();
    }

    protected function place(){
        if($this->type == 4){
            $this->coords=$this->generateCoords(4);
        }
        elseif ($this->type == 3){
            $this->coords=$this->generateCoords(3);
        }
        elseif ($this->type == 2){
            $this->coords=$this->generateCoords(2);
        }
        elseif ($this->type == 1){
            $this->coords=$this->generateCoords(1);
        }
        else{
            throw new Exception('Неизвестный тип');
        }
    }

    public function getCoords(){
        return $this->coords;
    }

    /**
     * Задает координаты корабля, определяет его положение (по горизонтали или по вертикали)
     * @param $decks - количество палуб
     */
    protected function generateCoords($decks)
    {
        $rotate = rand(0, 1);

        if ($rotate == 1) {
            $maxX = $this->maxX - $decks;
        } else {
            $maxX = $this->maxX;
        }

        if ($rotate == 0) {
            $maxY = $this->maxY - $decks;
        } else {
            $maxY = $this->maxY;
        }

        $coords[0]['x'] = rand(0, $maxX);
        $coords[0]['y'] = rand(0, $maxY);

        for ($i = 1; $i < $decks; $i++) {
            if ($rotate == 1) {
                $coords[$i]['x'] = $coords[($i - 1)]['x'] + 1;
                $coords[$i]['y'] = $coords[($i - 1)]['y'];
            } else {
                $coords[$i]['x'] = $coords[($i - 1)]['x'];
                $coords[$i]['y'] = $coords[($i - 1)]['y'] + 1;
            }
        }

        return $coords;
    }


}