<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TestRepository")
 */
class Test
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="test_id", type="integer")
     */
    private $testId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set testId
     *
     * @param integer $testId
     *
     * @return Test
     */
    public function setTestId($testId)
    {
        $this->testId = $testId;

        return $this;
    }

    /**
     * Get testId
     *
     * @return int
     */
    public function getTestId()
    {
        return $this->testId;
    }
}

