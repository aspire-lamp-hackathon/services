<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\Index(keys={"source"="2d"})
 * @MongoDB\Index(keys={"destination"="2d"})
 */
class Ride
{
    /** @MongoDB\Id */
    protected $id;

    /** @MongoDB\EmbedOne(targetDocument="Coordinates") */
    protected $source;

    /** @MongoDB\EmbedOne(targetDocument="Coordinates") */
    protected $destination;
    
    /** @MongoDB\Date */
    protected $dateOfJourney;

    /** @MongoDB\Int */
    protected $persons;
    
    /** @MongoDB\Int */
    protected $rideOfferInd;
    
    /**
     * @MongoDB\ReferenceOne(targetDocument="AppBundle\Document\User")
     */
    protected $user;
    

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set source
     *
     * @param AppBundle\Document\Coordinates $source
     * @return self
     */
    public function setSource(\AppBundle\Document\Coordinates $source)
    {
        $this->source = $source;
        return $this;
    }
    
    /**
     * Get source
     *
     * @return AppBundle\Document\Coordinates $source
     */
    public function getSource()
    {
        return $this->source;
    }
    
    /**
     * Set destination
     *
     * @param AppBundle\Document\Coordinates $destination
     * @return self
     */
    public function setDestination(\AppBundle\Document\Coordinates $destination)
    {
        $this->destination = $destination;
        return $this;
    }
    
    /**
     * Get destination
     *
     * @return AppBundle\Document\Coordinates $destination
     */
    public function getDestination()
    {
        return $this->destination;
    }
    
    /**
     * Set dateOfJourney
     *
     * @param date $dateOfJourney
     * @return self
     */
    public function setDateOfJourney($dateOfJourney)
    {
        $this->dateOfJourney = $dateOfJourney;
        return $this;
    }
    
    /**
     * Get dateOfJourney
     *
     * @return date $dateOfJourney
     */
    public function getDateOfJourney()
    {
        return $this->dateOfJourney;
    }
    
    /**
     * Set persons
     *
     * @param int $persons
     * @return self
     */
    public function setPersons($persons)
    {
        $this->persons = $persons;
        return $this;
    }
    
    /**
     * Get persons
     *
     * @return int $persons
     */
    public function getPersons()
    {
        return $this->persons;
    }
    
    /**
     * Set rideOfferInd
     *
     * @param int $rideOfferInd
     * @return self
     */
    public function setRideOfferInd($rideOfferInd)
    {
        $this->rideOfferInd = $rideOfferInd;
        return $this;
    }
    
    /**
     * Get rideOfferInd
     *
     * @return int $rideOfferInd
     */
    public function getRideOfferInd()
    {
        return $this->rideOfferInd;
    }
    
    /**
     * Set user
     *
     * @param AppBundle\Document\User $user
     * @return self
     */
    public function setUser(\AppBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    /**
     * Get user
     *
     * @return AppBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }
}

/** @MongoDB\EmbeddedDocument */
class Coordinates
{
    /** @MongoDB\Float */
    protected $x;

    /** @MongoDB\Float */
    protected $y;
    

    /**
     * Set x
     *
     * @param float $x
     * @return self
     */
    public function setX($x)
    {
        $this->x = $x;
        return $this;
    }
    
    /**
     * Get x
     *
     * @return float $x
     */
    public function getX()
    {
        return $this->x;
    }
    
    /**
     * Set y
     *
     * @param float $y
     * @return self
     */
    public function setY($y)
    {
        $this->y = $y;
        return $this;
    }
    
    /**
     * Get y
     *
     * @return float $y
     */
    public function getY()
    {
        return $this->y;
    }
}
