<?php

namespace eDemy\MathBundle\Utils;

use eDemy\MainBundle\Controller\BaseController;
use Symfony\Component\Process\Process;

class Equation extends BaseController
{
    private $a, $b, $c;
    private $process;

    public function __construct($a, $b, $c)
    {
        parent::__construct();
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;

        /*
        $this->eq = "";
        $this->eq .= $this->a . "x^2";
        if($this->b > 0) $this->eq .= "+" . $this->b . "x";
        if($this->c > 0) $this->eq .= "+" . $this->c;
        $this->eq .= "=0";
        */
    }

    public function run($str)
    {
        $cmd = "\"import os;
            import sys;
            sympy_dir = os.path.normpath('../vendor/sympy');
            sys.path.insert(0, sympy_dir);
            import sympy;
            from sympy import *;
            x = Symbol('x');
            a = " . $this->a . ";
            b = " . $this->b . ";
            c = " . $this->c . ";
            eq =  " . $str . "
            pprint(latex(eq));
            \" ";
        $cmd = preg_replace("/;\s+/", ";", $cmd);
        $cmd = "python -c " . trim($cmd);
        $this->process = new Process($cmd);
        $this->process->run();
        if (!$this->process->isSuccessful()) {
            throw new \RuntimeException($this->process->getErrorOutput());
        }
    }

    public function view($image = true)
    {
        $this->run("Integer(a)*x**2 + Integer(b)*x + Integer(c);");
        $eq = $this->process->getOutput();
        $eq .= " = 0";
        if($image) {
            return $this->getImg($eq);
        } else {
            return $eq;;
        }
    }

    public function solve($image = true)
    {
        $this->run("solve(Integer(a)*x**2 + Integer(b)*x + Integer(c), x);");
        $eq = "x = ";
        $eq .= $this->process->getOutput();

        if($image) {
            return $this->getImg($eq);
        } else {
            return $eq;
        }
    }

    public function getStep1($format = 'text')
    {
        $eq1 = "";
        $eq1 .= $this->a . "x^2";
        if($this->b > 0) {
            $eq1 .= "+" . $this->b . "x";
        } elseif($this->b < 0) {
            $eq1 .= "-" . $this->b . "x";
        }
        if($this->c > 0) {
            $eq1 .= "=-" . $this->c;
        } elseif($this->c < 0) {
            $eq1 .= "=" . -1 * (int) $this->c;
        }

        if($format == 'text') {
            //return $eq1;
        }

        if($format == 'latex') {
            //return $this->getImg($eq1);
        }
    }

    public function getImg($eq)
    {
        $eq = trim($eq);
        $eq = str_replace(" ","",$eq);
        $eq = urlencode($eq);
        //die(var_dump($eq));
        $url = $this->get('router')->generate('edemy_math_render', array(
            'eq' => $eq
        ));
        return "<img src='" . $url . "' />";
    }
}
