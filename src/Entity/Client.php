<?php
/**
 * Created by PhpStorm.
 * User: gonzalo
 * Date: 03/12/2018
 * Time: 19:03
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Client
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="clients")
 * @ORM\HasLifecycleCallbacks
 */
class Client
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $client_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $client_name;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $client_lastname;

    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $client_phone;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     * @Assert\Email()
     * @Assert\Length(min=8)
     */
    private $client_email;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $client_created;

    // EXTRA METHODS ...

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps(){
        // date("Y-m-d H:i:s")
        if ($this->client_created==null){
            $this->client_created=new \DateTime();
        }
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @return string
     */
    public function getClientName(): string
    {
        return $this->client_name;
    }

    /**
     * @param string $client_name
     */
    public function setClientName(string $client_name): void
    {
        $this->client_name = $client_name;
    }

    /**
     * @return string
     */
    public function getClientLastname(): string
    {
        return $this->client_lastname;
    }

    /**
     * @param string $client_lastname
     */
    public function setClientLastname(string $client_lastname): void
    {
        $this->client_lastname = $client_lastname;
    }

    /**
     * @return string
     */
    public function getClientPhone(): string
    {
        return $this->client_phone;
    }

    /**
     * @param string $client_phone
     */
    public function setClientPhone(string $client_phone): void
    {
        $this->client_phone = $client_phone;
    }

    /**
     * @return string
     */
    public function getClientEmail(): string
    {
        return $this->client_email;
    }

    /**
     * @param string $client_email
     */
    public function setClientEmail(string $client_email): void
    {
        $this->client_email = $client_email;
    }

    /**
     * @return \DateTime
     */
    public function getClientCreated(): \DateTime
    {
        return $this->client_created;
    }

    /**
     * @param \DateTime $client_created
     */
    public function setClientCreated(\DateTime $client_created): void
    {
        $this->client_created = $client_created;
    }
}