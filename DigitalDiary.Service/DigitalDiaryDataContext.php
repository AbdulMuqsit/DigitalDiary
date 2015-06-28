<?php


class DigitalDiaryDataContext
{
    //credential constants
    const servername  = "localhost";
    const username = "root";
    const password = "idkwmpsb@3";

    //connection
    private $connection;

    //constructor
    function __construct(){
        $this->
connection = new mysqli(self::servername,self::username,self::password);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        $this->createDatabase();
        $this->selectDatabase();
        $this->createTables();
    }


    //To create database if it does not already exist
    private function createDatabase(){
        $sql = "CREATE DATABASE IF NOT EXISTS DigitalDiary";
        if ($this->connection->query($sql) !== TRUE) {

            echo "Error creating database: " . $this->connection->error;
        }
    }

    //To select the software database
    private function selectDatabase(){
        if ($this->connection->select_db('digitaldiary')!==true)
        {
        	echo 'Error Selecting Database'.$this->connection->error;
        }

    }

    //To create database tables
    private function createTables(){
        $sql='CREATE TABLE IF NOT EXISTS Users(
            Id INT PRIMARY KEY,
            UserName  NVARCHAR (20),
            Password  NVARCHAR (20),
            FirstName NVARCHAR (30),
            LastName  NVARCHAR (30),
            Picture   NVARCHAR (100),
            PHONE     NVARCHAR (20),
            ADDRESS   NVARCHAR (255)
            );

            CREATE TABLE IF NOT EXISTS Entries(
            Id INT PRIMARY KEY,
            Title  NVARCHAR (255),
            Text   TEXT,
            TIMESTAMP  DATETIME,
            UserId INT NOT NULL,

            FOREIGN KEY (UserId) REFERENCES Users(Id) on delete cascade on update cascade
            );';

        if ( $this->connection->multi_query($sql)!==true){
        	echo 'Error creating tables'.$this->connection->error;
        }

    }


    //destructor
    function __destruct(){
        $this->connection->close();
    }
}
