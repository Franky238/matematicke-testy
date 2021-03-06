<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class
 *
 * @ORM\Table(name="subject")
 * @ORM\Entity
 */
class Subject
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
     * @ORM\ManyToMany(targetEntity="TestBundle\Entity\User", inversedBy="subjects")
     * @ORM\JoinTable(name="subject_has_users")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="TestBundle\Entity\Test", inversedBy="subjects")
     * @ORM\JoinTable(name="subject_has_test")
     */
    private $tests;

    /**
     * @ORM\ManyToMany(targetEntity="TestBundle\Entity\Teacher", inversedBy="subjects")
     * @ORM\JoinTable(name="teacher_has_subject")
     */
    private $teachers;

    /**
     * @ORM\OneToMany(targetEntity="TestBundle\Entity\ReturnedTest", mappedBy="subject")
     */
    private $returnedTests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tests = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teachers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->returnedTests = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Subject
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
     * @return Subject
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
     * @return Subject
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
     * @param \TestBundle\Entity\Teacher $teacher
     * @return Subject
     */
    public function addTeacher(\TestBundle\Entity\Teacher $teacher)
    {
        $this->teachers[] = $teacher;

        return $this;
    }

    /**
     * Remove teachers
     *
     * @param \TestBundle\Entity\Teacher $teacher
     */
    public function removeTeacher(Teacher $teacher)
    {
        $this->teachers->removeElement($teacher);
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

    /**
     * Add returnedTests
     *
     * @param \TestBundle\Entity\ReturnedTest $returnedTests
     * @return Subject
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
