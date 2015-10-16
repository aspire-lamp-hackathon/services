<?php
namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AppController;
use UserBundle\Form\Type\RegisterType;
use AppBundle\Document\User;
use UserBundle\Form\Type\LoginType;

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
                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->persist($user);
                $dm->flush();
                $this->actionSuccess(array(
                    'user_id' => $user->getId()
                ));
            } else {
                $this->addFormErrors($form);
            }
        } catch (\Exception $e) {
            $this->addExceptionErrors($e);
        }
        
        return new JsonResponse($this->getResponse());
    }

    public function loginAction(Request $request)
    {
        try {
            $form = $this->createForm(new LoginType());
            $this->filterInput($request, $form);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $userRepository = $this->getUserRepository();
                $userData = $userRepository->findOneByEmail($data['userid']);
                if ($userData->getPassword() == $data['password']) {
                    $this->actionSuccess(array(
                        'userId' => $userData->getPassword()
                    ));
                }
            } else {
                $this->addFormErrors($form);
            }
        } catch (\Exception $e) {
            $this->addExceptionErrors($e);
        }
        
        return new JsonResponse($this->getResponse());
    }

    protected function getUserRepository()
    {
        return $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AppBundle\Document\User');
    }
}
