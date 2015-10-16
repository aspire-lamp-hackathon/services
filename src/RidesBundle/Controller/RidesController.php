<?php
namespace RidesBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AppController;
use RidesBundle\Form\Type\RidesType;
use AppBundle\Document\Ride;

class RidesController extends AppController
{
    public function searchAction(Request $request)
    {
        try {
            $ride = new Ride();
            $form = $this->createForm(new RidesType(), $ride);
            
            $this->filterInput($request, $form);
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->persist($ride);
                $dm->flush();
                $this->actionSuccess(array(
                    'ride_id' => $ride->getId()
                ));
            } else {
                $this->addFormErrors($form);
            }
        } catch (\Exception $e) {
            $this->addExceptionErrors($e);
        }
        
        return new JsonResponse($this->getResponse());
    }
}
