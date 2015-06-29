<?php


class DigitalDiaryDbContext
{
    //database

    public $users;
    public $entries;

    private $database;
    //constructor
    function __construct(){
        $this->database = new DigitalDiaryDb();
        $this->users = new UserRepository( $this->database);
        $this->entries = new EntryRepository($this->database);

    }

    //


}
