<?php

namespace App\Entity;

use App\Doctrine\Filter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrucRepository")
 * @Filter(column="data")
 */
class Truc
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $filter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $data;

}

