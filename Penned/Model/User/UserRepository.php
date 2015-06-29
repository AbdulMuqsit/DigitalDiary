<?php
//Database Access Layer fo entity user

class UserRepository
{

    //database conneciton
    private $connection;

    //constructor takes a mysqli objects and assigns it's connection to
    //priavate member conneciton
    function __construct($database){
        $this->connection = $database->connection;
    }
    //Add new user to the database

    public function add(User $user){

        $this->connection->next_result();

        $sql = $this->connection->prepare('INSERT INTO USERS (UserName,Password, FirstName, LastName, PictureUri, Address) VALUES (?,?,?,?,?,?);');
        $sql->bind_param('ssssss', $user->username, $user->password, $user->FirstName, $user->LastName, $user->Picture, $user->address);

        //echo an error if operation is not successful

        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }

    //To get all of the users from database
    public function getAll(){

        $this->connection->next_result();

        $sql = 'SELECT * FROM USERS';
        $result = $this->connection->query($sql);

        $result = $result->fetch_all(MYSQL_ASSOC);
        return $result;
    }

    //get a user by id

    public function get($id){

        $this->connection->next_result();

        $sql = $this->connection->prepare('SELECT * FROM USERS WHERE Id = ?');
        $sql->bind_param('i',$id);

        $sql->execute();
        $result = $sql->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    //to filter the users,
    //takes the name of the column and value of the column as filter condition
    // selects all users from database wehre column = value
    public function where($column,$value){

        $this->connection->next_result();

        $sql = $this->connection->prepare('SELECT * FROM USERS WHERE '.$column.' = ?');
        $sql->bind_param('s',$value);

        $sql->execute();
        $result = $sql->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    //update an entry

    public function update($id,$user){
        $sql = $this->connection->prepare('UPDATE USERS SET UserName = ?,Password = ?, FirstName = ?, LastName = ?, PictureUri = ?, Address = ? WHERE Id = ?');
        $sql->bind_param('ssssssi', $user->username, $user->password, $user->FirstName, $user->LastName, $user->Picture, $user->address, $id);
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }

    //delete an entry

    public function delete($id){
        $sql = $this->connection->prepare('DELETE FROM USERS WHERE Id = ?');
        $sql->bind_param('i', $id);
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }
}
