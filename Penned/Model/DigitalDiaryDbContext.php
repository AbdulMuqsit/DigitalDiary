<?php

//The application database context
//Implements the repository pattern to access the database
//Applicaton will use this class to communicate to database
//this class itself uses the repository classes in model/user and model/entity folder
//and provides a generic interface for database communication
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
