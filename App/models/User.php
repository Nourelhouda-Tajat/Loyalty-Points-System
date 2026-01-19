<?php
namespace App\Models;

class User {
    private $id;
    private $email;
    private $passwordHash;
    private $name;
    private $totalPoints;

    public function __construct($email, $passwordHash, $name, $id = null,  $totalPoints=0){
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->name = $name;
        $this->id = $id;
        $this->totalPoints = $totalPoints;
    }

    public function getId(){ return $this->id;}
    public function getEmail(){return $this->email;}
    public function getPasswordHash(){ return $this->passwordHash;}
    public function getName(){ return $this->name;}
    public function getTotalPoints(){ return $this->totalPoints;}

}