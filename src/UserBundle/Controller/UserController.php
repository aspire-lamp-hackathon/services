<?php
namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\User;
use AppBundle\Controller\AppController;
use AppBundle\Model\AppBundle\Model;
use UserBundle\Form\Type\RegisterType;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;

class UserController extends AppController
{

    public function registerAction(Request $request)
    {
        try {
            $user = new User();
            $form = $this->createForm(new RegisterType(), $user);
            $this->filterInput($request, $form);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user->save();
                $response = array(
                    'errorCode' => 0,
                    'errorMessage' => null
                );
            } else {
                $this->addFormErrors($form);
            }
        } catch (\Exception $e) {
            $this->addExceptionErrors($e);
        }
        
        return new JsonResponse($this->getResponse());
    }
}
