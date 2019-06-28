<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="lbPerson")
 * @ORM\HasLifecycleCallbacks
 */
class Person implements JsonSerializable
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $first_name;

    /**
     * @ORM\Column(type="string", nullable = true)
     */
    protected $second_name;

    public function get_id()
    {
        return $this->id;
    }

    public function get_first_name()
    {
        return $this->first_name;
    }

    public function set_first_name($first_name)
    {
        $this->first_name = $first_name;
    }

    public function get_second_name()
    {
        return $this->second_name;
    }

    public function set_second_name($second_name)
    {
        $this->second_name = $second_name;
    }

    public function setData($data)
    {
        $this->set_first_name($data['first_name']);
        $this->set_second_name($data['second_name']);
    }

    public function jsonSerialize()
    {
        return [
        'id' => $this->get_id(),
        'first_name' => $this->get_first_name(),
        'second_name' => $this->get_second_name(),
        ];
    }
}
