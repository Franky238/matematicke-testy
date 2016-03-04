<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class
 *
 * @ORM\Table(name="classroom")
 * @ORM\Entity
 */
class Classroom
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="TestBundle\Entity\User", mappedBy="classroom")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="TestBundle\Entity\Test", inversedBy="classrooms")
     * @ORM\JoinTable(name="classroom_has_test")
     */
    private $tests;

    /**
     * @ORM\ManyToMany(targetEntity="TestBundle\Entity\Teacher", mappedBy="classrooms")
     * @ORM\JoinTable(name="teacher_has_classroom")
     */
    private $teachers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teachers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Classroom
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
     * Add users
     *
     * @param \TestBundle\Entity\User $users
     * @return Classroom
     */
    public function addUser(\TestBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \TestBundle\Entity\User $users
     */
    public function removeUser(\TestBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add tests
     *
     * @param \TestBundle\Entity\Test $tests
     * @return Classroom
     */
    public function addTest(\TestBundle\Entity\Test $tests)
    {
        $this->tests[] = $tests;

        return $this;
    }

    /**
     * Remove tests
     *
     * @param \TestBundle\Entity\Test $tests
     */
    public function removeTest(\TestBundle\Entity\Test $tests)
    {
        $this->tests->removeElement($tests);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * Add teachers
     *
     * @param \TestBundle\Entity\Teacher $teachers
     * @return Classroom
     */
    public function addTeacher(\TestBundle\Entity\Teacher $teachers)
    {
        $this->teachers[] = $teachers;

        return $this;
    }

    /**
     * Remove teachers
     *
     * @param \TestBundle\Entity\Teacher $teachers
     */
    public function removeTeacher(\TestBundle\Entity\Teacher $teachers)
    {
        $this->teachers->removeElement($teachers);
    }

    /**
     * Get teachers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeachers()
    {
        return $this->teachers;
    }
}
