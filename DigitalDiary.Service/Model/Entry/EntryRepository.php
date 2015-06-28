<?php

class EntryRepository
{
    private $connection;
    function __construct($database){
        $this->
connection = $database->connection;
    }

    public function add(Entry $entry){

        $this->connection->next_result();

        $sql = $this->connection->prepare('INSERT INTO ENTRIES (Title, Text, TimeStamp) VALUES (?,?,?);');
        $sql->bind_param('sss', $entry->title, $entry->text, $entry->timeStamp);
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }


    public function getAll(){

        $this->connection->next_result();

        $sql = 'SELECT * FROM ENTRIES';
        $result = $this->connection->query($sql);

        $result = $result->fetch_all(MYSQL_ASSOC);
        return $result;
    }


    public function get($id){

        $this->connection->next_result();

        $sql = $this->connection->prepare('SELECT * FROM ENTRIES WHERE Id = ?');
        $sql->bind_param('i',$id);

        $sql->execute();
        $result = $sql->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    public function where($column,$value){

        $this->connection->next_result();

        $sql = $this->connection->prepare('SELECT * FROM ENTRIES WHERE '.$column.' = ?');
        $sql->bind_param('s',$value);

        $sql->execute();
        $result = $sql->get_result();
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    public function update($id,Entry $entry){
        $sql = $this->connection->prepare('UPDATE ENTRIES SET Title = ?, Text = ?, TimeStamp = ? WHERE Id = ?');
        $sql->bind_param('sssi', $entry->title, $entry->text, $entry->timeStamp, $id);
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }

    public function delete($id){
        $sql = $this->connection->prepare('DELETE FROM ENTRIES WHERE Id = ?');
        $sql->bind_param('i', $id);
        if ($sql->execute()!==true)
        {
        	echo 'Error saving changes'.$this->connection->error;
        }
    }


}
