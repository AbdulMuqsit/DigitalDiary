<?php


class DigitalDiaryDbContext
{
    //database

    public $users;
    public $entries;

    private $database;
    //constructor
    function __construct(){
        $database = new DigitalDiaryDb();
        $this->users = new UserRepository( $database);
        $this->entries = new EntryRepository($database);

    }

    //


}
