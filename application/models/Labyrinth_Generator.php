<?php

class T_shape {
   private $pattern=array(
            array(1,1,1,1,1),
            array(0,0,1,0,0),
            array(1,0,1,0,1),
            array(0,0,1,0,0),
            array(1,0,1,0,1));


    private function RotateMatrix($rotate90DegreeLeftTimes)
    {
        $m=$this->pattern;
        for ($k=0;$k<$rotate90DegreeLeftTimes;$k++) {
            $temp = array(
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0));
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < 5; $j++) {
                	$t=-$j+5-1;
                    $temp[$t][$i]=$m[$i][$j];
                }
            }
            $m=$temp;
        }
        return $m;
    }

    public function PutForm($maze, $x, $y, $rotate90DegreeLeftTimes){
    	$newMaze = $maze;
        $rotated = $this->RotateMatrix($rotate90DegreeLeftTimes);
        if ($x+5<33&&$y+5<33)
            for ($i=$x;$i<$x+5;$i++)
                for ($j=$y;$j<$y+5;$j++)
                    $newMaze[$i][$j]=$rotated[$i-$x][$j-$y];
        return $newMaze;
    }
}


class Plus_shape {
   private $pattern=array(
            array(1,0,1,0,1),
            array(0,0,1,0,0),
            array(1,1,1,1,1),
            array(0,0,1,0,0),
            array(1,0,1,0,1));


    private function RotateMatrix($rotate90DegreeLeftTimes)
    {
        $m=$this->pattern;
        for ($k=0;$k<$rotate90DegreeLeftTimes;$k++) {
            $temp = array(
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0));
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < 5; $j++) {
                	$t=-$j+5-1;
                    $temp[$t][$i]=$m[$i][$j];
                }
            }
            $m=$temp;
        }
        return $m;
    }

    public function PutForm($maze, $x, $y, $rotate90DegreeLeftTimes){
        $rotated = $this->RotateMatrix($rotate90DegreeLeftTimes);
        $newMaze = $maze;
        if ($x+5<33&&$y+5<33)
            for ($i=$x;$i<$x+5;$i++)
                for ($j=$y;$j<$y+5;$j++)
                    $newMaze[$i][$j]=$rotated[$i-$x][$j-$y];
        return $newMaze;
    }
}


class L_shape {
   private $pattern=array(
            array(1,1,1,1,1),
            array(1,0,0,0,0),
            array(1,0,1,1,1),
            array(1,0,1,1,1),
            array(1,0,1,1,1));


    private function RotateMatrix($rotate90DegreeLeftTimes)
    {
        $m=$this->pattern;
        for ($k=0;$k<$rotate90DegreeLeftTimes;$k++) {
            $temp = array(
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0),
            			array(0,0,0,0,0));
            for ($i = 0; $i < 5; $i++) {
                for ($j = 0; $j < 5; $j++) {
                	$t=-$j+5-1;
                    $temp[$t][$i]=$m[$i][$j];
                }
            }
            $m=$temp;
        }
        return $m;
    }

    public function PutForm($maze, $x, $y, $rotate90DegreeLeftTimes){
    	$newMaze=$maze;
        $rotated = $this->RotateMatrix($rotate90DegreeLeftTimes);
        if ($x+5<33&&$y+5<33)
            for ($i=$x;$i<$x+5;$i++)
                for ($j=$y;$j<$y+5;$j++)
                    $newMaze[$i][$j]=$rotated[$i-$x][$j-$y];
        return $newMaze;
    }
}

class Labyrinth_Generator extends CI_Model {
	private $L;
    private $T;
    private $P;
    public $maze =array(
    				array(),array(),array(),
    				array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array(),
        			array(),array(),array());
    private $n, $m;

    public function __construct() {
    	$this->L=new L_shape();
    	$this->T = new T_shape();
    	$this->P=new Plus_shape();
        $this->n = 33;
        $this->m = 33;
        for ($i=0;$i<$this->n;$i++)
        	for ($j=0;$j<$this->m;$j++)
        		$this->maze[$i][$j]=0;
        for ($i=0;$i<$this->n;$i++)
            $this->maze[$i][$this->m-1]=$this->maze[$i][0]=1;
        for ($i=0;$i<$this->m;$i++)
            $this->maze[$this->n-1][$i]=$this->maze[0][$i]=1;
        for ($i=14;$i<19;$i++)
            for ($j=14;$j<19;$j++)
                $this->maze[$i][$j]=1;
    }

    private function DrawLine($i, $j, $direction){
        $returned = array();
        $index=0;
        //0 = stanga dreapta, 1 = sus,jos;
        if ($direction==0){
            $temp=$j;
            $returned[$index++]=$temp--;
            while ($temp>0&&$this->IsFreeAround($i,$temp))
                $returned[$index++]=$temp--;
            $temp=$j+1;
            while ($temp<$this->m&&$this->IsFreeAround($i,$temp))
                $returned[$index++]=$temp++;
        }
        else if ($direction==1){
            $temp=$i;
            $returned[$index++]=$temp--;
            while ($temp>0&&$this->IsFreeAround($temp,$j))
                $returned[$index++]=$temp--;
            $temp=$i+1;
            while ($temp<$this->n&& $this->IsFreeAround($temp,$j))
                $returned[$index++]=$temp++;
        }
        return $returned;
    }

    private function IsFreeAround($x, $y) {
        if ($x > 0 && $y > 0 && $this->maze[$x - 1][$y - 1] == 1) return false;
        if ($x > 0 && $this->maze[$x - 1][$y] == 1)return false;
        if ($x > 0 && $y < $this->m-1 && $this->maze[$x - 1][$y + 1] == 1) return false;
        if ($y > 0 && $this->maze[$x][$y - 1] == 1) return false;
        if ($y < $this->m-1 && $this->maze[$x][$y + 1] == 1) return false;
        if ($x < $this->n-1 && $y > 0 && $this->maze[$x + 1][$y - 1] == 1) return false;
        if ($x < $this->n-1 && $this->maze[$x + 1][$y] == 1) return false;
        if ($x < $this->n-1 && $y < $this->m-1 && $this->maze[$x + 1][$y + 1] == 1) return false;

        return true;

    }

    public function GenerateMaze() {
        for ($i = 2; $i < $this->n; $i += 6)
            for ($j = 2; $j < $this->m; $j += 6) {
                if (($i<10||$i>19||($j<10||$j>19))) {
                    $randomFormIndex = rand(0,3);
                    $rotate90DegreeLeftTimes = rand(0,3);
                    switch ($randomFormIndex) {
                        case 0:
                            $this->maze=$this->L->PutForm($this->maze, $i, $j, $rotate90DegreeLeftTimes);
                            break;
                        case 1:
                            $this->maze=$this->T->PutForm($this->maze, $i, $j, $rotate90DegreeLeftTimes);
                            break;
                        case 2:
                            $this->maze=$this->P->PutForm($this->maze, $i, $j, $rotate90DegreeLeftTimes);
                            break;
                        default:
                            break;
                    }
                }
            }

        //cand gaseste o pozitie libera, random 0 sau 1 (sud-nord sau est-vest) while isfreearound bag intr-un vector si pun la final;
        for ($i = 0; $i < $this->n; $i++)
            for ($j = 0; $j < $this->m; $j++)
                if ($this->IsFreeAround($i,$j))
                {
                    $fill = array();
                    $direction = rand(0,1);
                    $fill = $this->DrawLine($i,$j,$direction);
                    if ($direction==0)
                        for ($k=0;$k<count($fill);$k++)
                            $this->maze[$i][$fill[$k]]=1;
                    else if ($direction==1)
                        for ($k=0;$k<count($fill);$k++)
                            $this->maze[$fill[$k]][$j]=1;
                }
        $this->maze[19][16]=2;
        $this->maze[17][16]=$this->maze[16][16]=$this->maze[15][16]=$this->maze[17][15]=
        		$this->maze[17][17]=$this->maze[16][17]=$this->maze[16][15]=$this->maze[14][16]=
                $this->maze[15][17]=$this->maze[15][15]=0;
    }

    public function getMaze(){
        $labyrinth = array();
    	for ($i=0;$i<33;$i++){
            $row = "";
    		for ($j=0;$j<33;$j++){
    			$row = $row . strval($this->maze[$i][$j]);
    		}
    		array_push($labyrinth, $row);
    	}
        return $labyrinth;
    }
}

?>