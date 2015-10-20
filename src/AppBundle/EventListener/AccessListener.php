<?php
namespace AppBundle\EventListener;


//use AppBundle\Entity\Cube;
//use AppBundle\Entity\Parameter;
use AppBundle\Entity\TestCaseList;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
//use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//use Symfony\Component\Security\Core\Exception\AccessDeniedException;
//use Symfony\Component\HttpKernel\Exception\HttpException;

class AccessListener
{
    private $serviceAuth;
    private $context;
    private $container;

    public function __construct($service)
    {
        $this->serviceAuth = $service;
    }

    public function setContext(\Symfony\Component\Security\Core\SecurityContext $context)
    {
        $this->context = $context;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
       //$event->getRequest()->getSession()->remove('app');
        if(!$event->getRequest()->getSession()->isStarted()) $event->getRequest()->getSession()->start();
        if(!$event->getRequest()->getSession()->has('app')){
            $event->getRequest()->getSession()->set('app',$this->createAppSessionObject());
        }
    }

    private function createAppSessionObject(){
        $app = new \stdClass();
        $app->testCases = new TestCaseList();
        $app->limits = array(
            'lower_limit_t' => $this->container->getParameter('lower_limit_t'),
            'upper_limit_t' => $this->container->getParameter('upper_limit_t'),
            'lower_limit_n' => $this->container->getParameter('lower_limit_n'),
            'upper_limit_n' => $this->container->getParameter('upper_limit_n'),
            'lower_limit_m' => $this->container->getParameter('lower_limit_m'),
            'upper_limit_m' => $this->container->getParameter('upper_limit_m'),
            'lower_limit_w' => $this->container->getParameter('lower_limit_w'),
            'upper_limit_w' => $this->container->getParameter('upper_limit_w')
        );
        return $app;
    }


}