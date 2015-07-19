<?php

namespace eDemy\MathBundle\Utils;

use eDemy\MainBundle\Controller\BaseController;
use eDemy\MathBundle\Utils\Equation;
use Symfony\Component\Process\Process;

class EquationFactory extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function newEquation($a, $b, $c)
    {
        $eq = new Equation($a, $b, $c);
        $eq->setEventDispatcher($this->get('event_dispatcher'));
        return $eq;
    }
}
