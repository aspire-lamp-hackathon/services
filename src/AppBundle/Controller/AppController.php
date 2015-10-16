<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;

class AppController extends Controller
{

    const SUCCESS = 0;

    const FORM_ERRORS = 1;

    const EXCEPTION_ERRORS = 2;

    private $response = array(
        'errorCode' => - 1,
        'errorMessage' => array()
    );

    /**
     * Method to filter the request
     *
     * @param Request $request            
     * @param Form $form            
     */
    public function filterInput(Request $request, Form $form)
    {
        $requestParams = array();
        if ($request->getContentType() == 'json') {
            $requestParams = json_decode($request->getContent(), true);
        } else {
            $requestParams = $request->request->all();
        }
        
        $filteredInput = $this->sanitizeInput($requestParams, $form);
        
        $request->request->set($form->getName(), $filteredInput);
    }

    /**
     * Method to remove unwanted parameters in the request.
     *
     * @param array $requestData            
     * @param Form $form            
     * @return multitype:unknown
     */
    protected function sanitizeInput($requestData, Form $form)
    {
        $filteredInput = array();
        foreach ($form->all() as $childName => $child) {
            if ($child->count() > 0 && isset($requestData[$childName])) {
                foreach ($child as $grandChildName => $grandChild) {
                    $filteredInput[$childName][$grandChildName] = $this->filterInput($requestData[$childName], $grandChild);
                }
            }
            
            if (isset($requestData[$childName])) {
                $filteredInput[$childName] = $requestData[$childName];
            }
        }
        
        return $filteredInput;
    }

    /**
     * Method to add form errors to the response array
     *
     * @param Form $form            
     * @return \AppBundle\Controller\AppController
     */
    protected function addFormErrors(Form $form)
    {
        $response = array();
        $response['errorCode'] = self::FORM_ERRORS;
        foreach ($form->getErrors(true) as $error) {
            $response['errorMessage'][] = $error->getMessage();
        }
        
        $this->response = $response;
        
        return $this;
    }

    /**
     * Method to add the exception messages to the response array
     *
     * @param Form $form            
     * @return \AppBundle\Controller\AppController
     */
    protected function addExceptionErrors(\Exception $e)
    {
        $response = array();
        if ($e->getCode() === null) {
            $response['errorCode'] = self::EXCEPTION_ERRORS;
            $response['errorMessage'] = 'Unexpected Error! Please try later';
        } else {
            $response['errorCode'] = $e->getCode();
            $response['errorMessage'] = $e->getMessage();
        }
        $this->response = $response;
        return $this;
    }

    /**
     * Method to mark the execution of the action as sucess
     *
     * @param $data to
     *            be returned in the response
     */
    protected function actionSuccess($data = null)
    {
        $this->response['errorCode'] = self::SUCCESS;
        $this->response['data'] = $data;
    }

    /**
     * Method to return the response
     *
     * @return Ambigous <multitype:number multitype: , to, string, multitype:string NULL , multitype:string >
     */
    protected function getResponse()
    {
        return $this->response;
    }
}