<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity
 */
class Test
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @Assert\File(maxSize="1000000")
     */
    private $file;

    /**
     * @ORM\ManyToMany(targetEntity="TestBundle\Entity\Subject", mappedBy="tests")
     */
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity="TestBundle\Entity\ReturnedTest", mappedBy="test")
     */
    private $returnedTests;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subjects = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Test
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
     * UPLOAD OF THE TEST IN PDF FILE
     *
     * This functions handle path of uploaded file and his upload directory
     */

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/tests';
    }


    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        $filename = uniqid(null)."_".uniqid(null).".".$this->getFile()->getClientOriginalExtension();

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $filename
        );

        // set the path property to the filename where you've saved the file
        $this->path = $filename;

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Test
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Add subjects
     *
     * @param \TestBundle\Entity\Subject $subject
     * @return Test
     */
    public function addSubject(\TestBundle\Entity\Subject $subject)
    {
        $this->subjects[] = $subject;

        return $this;
    }

    /**
     * Remove subjects
     *
     * @param \TestBundle\Entity\Subject $subject
     */
    public function removeSubject(\TestBundle\Entity\Subject $subject)
    {
        $this->subjects->removeElement($subject);
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
     * Add returnedTests
     *
     * @param \TestBundle\Entity\ReturnedTest $returnedTests
     * @return Test
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
