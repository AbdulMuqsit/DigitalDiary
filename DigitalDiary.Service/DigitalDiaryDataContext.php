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
        	echo 'Error Selecting Database';
        }

    }


    //destructor
    function __destruct(){
        $this->connection->close();
    }
}
