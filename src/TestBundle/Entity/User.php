<?php

namespace TestBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="TestBundle\Entity\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=100)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=40)
     */
    private $salt;

    /**
     * @ORM\ManyToMany(targetEntity="TestBundle\Entity\Subject", mappedBy="users")
     * @var object
     */
    private $subjects;

    /**
     * @ORM\Column(name="is_enabled", type="boolean")
     */
    private $isEnabled = true;

    /**
     * @ORM\OneToMany(targetEntity="TestBundle\Entity\ReturnedTest", mappedBy="user")
     */
    private $returnedTests;

    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
        $this->subjects = new ArrayCollection();
        $this->returnedTests = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
        ));
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->salt,
            ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function isEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Add subjects
     *
     * @param \TestBundle\Entity\Subject $subjects
     * @return User
     */
    public function addSubject(\TestBundle\Entity\Subject $subjects)
    {
        $this->subjects[] = $subjects;

        return $this;
    }

    /**
     * Remove subjects
     *
     * @param \TestBundle\Entity\Subject $subjects
     */
    public function removeSubject(\TestBundle\Entity\Subject $subjects)
    {
        $this->subjects->removeElement($subjects);
    }

    /**
     * Get subjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Add returnedTests
     *
     * @param \TestBundle\Entity\ReturnedTest $returnedTests
     * @return User
     */
    public function addReturnedTest(\TestBundle\Entity\ReturnedTest $returnedTests)
    {
        $this->returnedTests[] = $returnedTests;

        return $this;
    }

    /**
     * Remove returnedTests
     *
     * @param \TestBundle\Entity\ReturnedTest $returnedTests
     */
    public function removeReturnedTest(\TestBundle\Entity\ReturnedTest $returnedTests)
    {
        $this->returnedTests->removeElement($returnedTests);
    }

    /**
     * Get returnedTests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReturnedTests()
    {
        return $this->returnedTests;
    }
}
