<?php
namespace RidesBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\AppController;
use RidesBundle\Form\Type\RidesType;
use AppBundle\Document\Ride;

class RidesController extends AppController
{

    public function saveAction(Request $request)
    {
        try {
            $ride = new Ride();
            $form = $this->createForm(new RidesType(), $ride);
            
            $this->filterInput($request, $form);
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $ride->setUser($this->get('security.context')
                    ->getToken()
                    ->getUser());
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

    public function searchAction(Request $request)
    {
        try {
            $ride = new Ride();
            $form = $this->createForm(new RidesType(), $ride);
            
            $this->filterInput($request, $form);
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $requestData = $form->getData();
                $index = 0;
                $data = array();
                $nearestPoints = $this->get('doctrine_mongodb')
                    ->getManager()
                    ->createQueryBuilder('AppBundle:Ride')
                    ->field('source')
                    ->near($requestData->getSource()
                    ->getX(), $requestData->getSource()
                    ->getY())
                    ->getQuery()
                    ->execute();
                foreach ($nearestPoints as $nearestPoint) {
                    if ($nearestPoint->getUser()) {
                        
                        $data[$index]['name'] = $nearestPoint->getUser()->getName();
                        $data[$index]['email'] = $nearestPoint->getUser()->getEmail();
                        $data[$index]['mobile'] = $nearestPoint->getUser()->getMobile();
                    }
                    if ($nearestPoint->getSource()) {
                        $data[$index]['latitude'] = $nearestPoint->getSource()->getX();
                        $data[$index ++]['longitude'] = $nearestPoint->getSource()->getY();
                    }
                    $this->actionSuccess(array(
                        'points' => $data
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
}
