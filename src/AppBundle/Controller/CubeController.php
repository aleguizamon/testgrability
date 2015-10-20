<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TestCase;
use AppBundle\Entity\Operation;
use AppBundle\Entity\Validations;
use AppBundle\Entity\TestCaseList;
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
     * Regenera el proceso conpleto de acuerdo a la información guardada en la sesión.
     *
     */
    public function regenerateAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $app = $request->getSession()->get('app');
            if($app->testCases->getCount() > 0)
                $response = new Response(json_encode(array(
                            'success'     => true,
                            'lastN'       => $app->testCases->getCurrent()->getParamN(),
                            'lastM'       => $app->testCases->getCurrent()->getParamM(),
                            'operCurrent' => $app->testCases->getCurrent()->getOperationList()->getCount()+1,
                            'caseTotal'   => $app->testCases->getTotal(),
                            'caseCurrent' => $app->testCases->getCount(),
                            'logs'        => $app->testCases->regenerateLog()
                        )));
            else $response = new Response(json_encode(array('success' => false)));
            return $response;
        }

    }

    /**
     * Reinicia todos los cálculos.
     *
     */
    public function resetAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $app = $request->getSession()->get('app');
            $app->testCases = new TestCaseList();
            return new Response(json_encode(array(
                        'success'     => true
                    )));
        }

    }

    /**
     * Procesa el valor enviado del número de casos de prueba.
     *
     */
    public function assignCasesAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $testCases = $request->get('cases',NULL);
            $app = $request->getSession()->get('app');
            $current = 1;
            $success = false;
            if( ($resp = Validations::validateT($testCases,$app->limits)) == "" ){
                $success = true;
                $app->testCases->setTotal($testCases);
                $request->getSession()->set('app',$app);
            }
            return new Response(json_encode(array(
                        'success' => $success,
                        'msg' => $resp,
                        'total' => $testCases,
                        'current' => $current
                    )));
        }

    }

    /**
     * Procesa los valores de N y M para cada caso de prueba.
     *
     */
    public function assignTestParamsAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $size = $request->get('size','0');
            $operations = $request->get('operations','0');
            $app = $request->getSession()->get('app');
            $success = false;
            $current = $app->testCases->getCount()+1;
            if( ($app->testCases->getCount()+1) <= $app->testCases->getTotal()){
                if( ($resp = Validations::validateN($size,$app->limits)) == "" && ($resp = Validations::validateM($operations,$app->limits)) == "" ){
                    $success = true;
                    $app->testCases->addTestCases(new TestCase($current));
                    $app->testCases->getCurrent()->init($size,$operations);
                    $request->getSession()->set('app',$app);
                }
            }
            else $resp = "Ha superado el límite de casos de prueba";

            return new Response(json_encode(array(
                        'success' => $success,
                        'msg' => $resp,
                        'total' => $operations,
                        'current' => $current
                    )));
        }

    }

    /**
     * Ejecuta la operacion enviada por el usuario.
     *
     */
    public function executeOperationAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $operation = $request->get('operation','');
            $app = $request->getSession()->get('app');
            $success = false;
            if($operation == 'updateBtn'){
                $params = $request->get('update','');
                if( ($resp = Validations::validateStringUpdate($params,$app->testCases->getCurrent()->getParamN(),$app->limits)) == "" ){
                    $success = true;
                    $current = $app->testCases->getCurrent()->getOperationList()->getCount()+1;
                    $app->testCases->getCurrent()->getCube()->update($params);
                    $app->testCases->getCurrent()->getOperationList()->addOperations(new Operation($current));
                    $app->testCases->getCurrent()->getOperationList()->getCurrent()->updateValues('U',$params);
                    $request->getSession()->set('app',$app);
                }
            }
            else if($operation == 'queryBtn'){
                $params1 = $request->get('querya','');
                $params2 = $request->get('queryb','');
                if( ($resp = Validations::validateStringQuery($params1,$params2,$app->testCases->getCurrent()->getParamN())) == "" ){
                    $success = true;
                    $current = $app->testCases->getCurrent()->getOperationList()->getCount()+1;
                    $result = $app->testCases->getCurrent()->getCube()->query($params1,$params2);
                    $app->testCases->getCurrent()->getOperationList()->addOperations(new Operation($current));
                    $app->testCases->getCurrent()->getOperationList()->getCurrent()->queryValues('Q',$params1,$params2,$result);
                    $request->getSession()->set('app',$app);
                }
            }

            return new Response(json_encode(array(
                        'success' => $success,
                        'msg' => $resp,
                        'nextCase' => $app->testCases->getCount()+1,
                        'totalCase' => $app->testCases->getTotal(),
                        'next' => $app->testCases->getCurrent()->getOperationList()->getCount()+1,
                        'total' => $app->testCases->getCurrent()->getParamM(),
                        'log' => $success ? $app->testCases->getCurrent()->formatLog() : array()
                    )));
        }


    }

}
