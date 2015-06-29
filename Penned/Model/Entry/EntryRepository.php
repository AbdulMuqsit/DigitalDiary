<?php

//Database Access Layer fo entity entry
class EntryRepository
{

    //database conneciton
    private $connection;

    //constructor takes a mysqli objects and assigns it's connection to
    //priavate member conneciton
    function __construct($database){
        $this->
connection = $database->connection;
    }


    //Add new entry to the database
    public function add(Entry $entry){

        $this->connection->next_result();

        $sql = $this->connection->prepare('INSERT INTO ENTRIES (Title, Text, TimeStamp) VALUES (?,?,?);');
        $sql->bind_param('sss', $entry->title, $entry->text, $entry->timeStamp);

        //echo an error if operation is not successful
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }

    //To get all of the entries from database
    public function getAll(){

        $this->connection->next_result();

        $sql = 'SELECT * FROM ENTRIES';
        $result = $this->connection->query($sql);

        //fetch te results in an associative array
        $result = $result->fetch_all(MYSQL_ASSOC);
        return $result;
    }

    //get an entry by id
    public function get($id){

        $this->connection->next_result();

        $sql = $this->connection->prepare('SELECT * FROM ENTRIES WHERE Id = ?');
        $sql->bind_param('i',$id);

        $sql->execute();
        $result = $sql->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }


    //to filter the entries,
    //takes the name of the column and value of the column as filter condition
    // selects all entries from database wehre column = value
    public function where($column,$value){

        $this->connection->next_result();

        $sql = $this->connection->prepare('SELECT * FROM ENTRIES WHERE '.$column.' = ?');
        $sql->bind_param('s',$value);

        $sql->execute();
        $result = $sql->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    //update an entry
    public function update($id,Entry $entry){
        $sql = $this->connection->prepare('UPDATE ENTRIES SET Title = ?, Text = ?, TimeStamp = ? WHERE Id = ?');
        $sql->bind_param('sssi', $entry->title, $entry->text, $entry->timeStamp, $id);
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }

    //delete an entry
    public function delete($id){
        $sql = $this->connection->prepare('DELETE FROM ENTRIES WHERE Id = ?');
        $sql->bind_param('i', $id);
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }


}
