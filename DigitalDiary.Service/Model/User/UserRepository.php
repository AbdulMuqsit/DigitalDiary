<?php

class UserRepository
{
    private $connection;
    function __construct($database){
        $this->
connection = $database->connection;
    }

    public function add(User $user){

        $this->connection->next_result();

        $sql = $this->connection->prepare('INSERT INTO USERS (UserName,Password, FirstName, LastName, PictureUri, Address) VALUES (?,?,?,?,?,?);');
        $sql->bind_param('ssssss', $user->username, $user->password, $user->FirstName, $user->LastName, $user->Picture, $user->address);
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }

    public function getAll(){

        $this->connection->next_result();

        $sql = 'SELECT * FROM USERS';
        $result = $this->connection->query($sql);

        $result = $result->fetch_all(MYSQL_ASSOC);
        return $result;
    }

    public function where($column,$value){

        $this->connection->next_result();

        $sql = $this->connection->prepare('SELECT * FROM USERS WHERE '.$column.' = ?');
        $sql->bind_param('s',$value);

        $sql->execute();
        $result = $sql->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}
