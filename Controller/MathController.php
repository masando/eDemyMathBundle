<?php

namespace eDemy\MathBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use eDemy\MainBundle\Controller\BaseController;
use eDemy\MainBundle\Event\ContentEvent;
use eDemy\MathBundle\Utils\Equation;
use eDemy\MathBundle\Utils\EquationFactory;

class MathController extends BaseController
{
    public static function getSubscribedEvents()
    {
        return self::getSubscriptions('math', [], array(
            'edemy_math_index'      => array('onMathIndex', 0),
            'edemy_math_equation_2'   => array('onEquation', 0),
        ));
    }

    //pasamos un objeto eq_factory
    public function onMathIndex(ContentEvent $event)
    {
        $eq_factory = $this->get('edemy.math.equation_factory');
        //die(var_dump($eq_factory));
        $this->addEventModule($event, 'index.html.twig', array(
            'eq_factory' => $eq_factory,
        ));
        
        return true;        
    }

    //pasamos un objeto eq
    public function onEquation(ContentEvent $event)
    {
        $request = $this->getCurrentRequest();
        $a = $request->attributes->get('a');
        $b = $request->attributes->get('b');
        $c = $request->attributes->get('c');
        
        $eq = new Equation($a, $b, $c);
        $eq->setEventDispatcher($this->get('event_dispatcher'));
        
        $this->addEventModule($event, "equation.html.twig", array(
            'eq' => $eq,
        ));
        
        return true;
    }

    // ACTIONS
    public function renderLatexAction($eq)
    {
        $response = new Response();
        $img = file_get_contents('http://latex.codecogs.com/gif.latex?' . $eq);
        $response->setContent($img);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'image/gif');

        return $response;
    }
}
