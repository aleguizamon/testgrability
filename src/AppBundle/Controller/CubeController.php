<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CubeController extends Controller
{
    public function indexAction(Request $request)
    {

        return $this->render('AppBundle:CubeSummation:index.html.twig', array(
            ));
    }

    /**
     * Procesa el valor enviado del número de casos de prueba.
     *
     */
    public function assignCasesAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $testCases = $request->get('cases','0');

            if($testCases > 0){
                return new Response(json_encode(array(
                            'success' => true,
                            'data' => 'aaa'
                        )));
            }
            else{

            }

        }

    }

}
