<?php
namespace App\Entity;

// RBAC = Role Based Access Control
// Voters => Chain Of Responsibility

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
// ORM => for entity classes
// Assert => for DTO/Form classes

/**
 * Class User
 * @package App\Entity
 * @ORM\Entity()
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, EquatableInterface, \Serializable
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", options={ "comment": "User ID" })
     */
    private $user_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(min=8)
     */
    private $user_email;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $user_pass;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $user_registered;

    /**
     * @var string
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    private $user_rank;

    public function __toString()
    {
        return $this->user_email;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateTimestamp()
    {
        if ($this->user_registered==null){
            $this->user_registered=new \DateTime();
        }
    }

    // fields done... interfaces follow
    // class User implements UserInterface, EquatableInterface, \Serializable
    // ALT+INS, implement methods

    public function serialize()
    {
        $array = array($this->user_id, $this->user_email, $this->user_pass);
        return serialize($array);
    }
    public function unserialize($serialized)
    {
        list ($newUserId,$newUserEmail, $newUserPass) = unserialize($serialized);
        $this->user_id=$newUserId;
        $this->user_email=$newUserEmail;
        $this->user_pass=$newUserPass;
    }
    public function isEqualTo(UserInterface $user)
    {
        if ($this->getPassword()    !== $user->getPassword()) return false;
        if ($this->getSalt()        !== $user->getSalt()) return false;
        if ($this->getUsername()    !== $user->getUsername()) return false;
        return true;
    }
    public function getRoles()
    {
        // must return an array!!!
        $ret = array("ROLE_{$this->user_rank}");
        return $ret;
    }
    public function getPassword()
    {
        return $this->user_pass;
    }
    public function getSalt()
    {
        return null; // bcrypt!!!
    }
    public function getUsername()
    {
        return $this->user_email;
    }
    public function eraseCredentials()
    {
    }

    // ALT+INS, getters and setters
    // ****REMOVE**** setId()
    // \xampp\php\php bin/console doctrine:database:create
    // \xampp\php\php bin/console doctrine:schema:update --force

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getUserEmail(): string
    {
        return $this->user_email;
    }

    /**
     * @param string $user_email
     */
    public function setUserEmail(string $user_email): void
    {
        $this->user_email = $user_email;
    }

    /**
     * @return string
     */
    public function getUserPass(): string
    {
        return $this->user_pass;
    }

    /**
     * @param string $user_pass
     */
    public function setUserPass(string $user_pass): void
    {
        $this->user_pass = $user_pass;
    }

    /**
     * @return \DateTime
     */
    public function getUserRegistered(): \DateTime
    {
        return $this->user_registered;
    }

    /**
     * @param \DateTime $user_registered
     */
    public function setUserRegistered(\DateTime $user_registered): void
    {
        $this->user_registered = $user_registered;
    }

    /**
     * @return string
     */
    public function getUserRank(): string
    {
        return $this->user_rank;
    }

    /**
     * @param string $user_rank
     */
    public function setUserRank(string $user_rank): void
    {
        $this->user_rank = $user_rank;
    }

}