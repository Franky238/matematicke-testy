<?php

namespace TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ReturnedTest
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ReturnedTest
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
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\User", inversedBy="returnedTests")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\Subject", inversedBy="returnedTests")
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity="TestBundle\Entity\Test", inversedBy="returnedTests")
     */
    private $test;

    /**
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @Assert\File(maxSize="1000000")
     */
    private $file;


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
     * Set path
     *
     * @param string $path
     * @return ReturnedTest
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
     * Set user
     *
     * @param \TestBundle\Entity\User $user
     * @return ReturnedTest
     */
    public function setUser(\TestBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \TestBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set subject
     *
     * @param \TestBundle\Entity\Subject $subject
     * @return ReturnedTest
     */
    public function setSubject(\TestBundle\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \TestBundle\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set test
     *
     * @param \TestBundle\Entity\Test $test
     * @return ReturnedTest
     */
    public function setTest(\TestBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \TestBundle\Entity\Test 
     */
    public function getTest()
    {
        return $this->test;
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
        return 'uploads/returned_tests';
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
}
