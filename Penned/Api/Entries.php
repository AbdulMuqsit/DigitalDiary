<?php

//api provides a json interface to communicate to database,
//the client side code will use this interface to fetch entries from database


//require dependencies
require_once('../Model/User/User.php');
require_once('../Model/User/UserRepository.php');
require_once('../Model/Entry/Entry.php');
require_once('../Model/Entry/EntryRepository.php');
require_once('../Model/DigitalDiaryDbContext.php');
require_once('../Model/DigitalDiaryDb.php');




//The controller mainly routes the request to related functions
//of entry database access layer, using the DigitalDiaryDbContext class
class EntryController
{
    public $context;

    function __construct(){
        $this->context = new DigitalDiaryDbContext();

    }

    //The controller execution, implements manual routing of the url to related funcions
    public function execute(){

        //get the http request method and the query string
        $method = $_SERVER['REQUEST_METHOD'];
        $query = $_SERVER['QUERY_STRING'];
        parse_str($query,$parameters);


        //switch over the request method and call appropriate functions

        switch ($method)
        {
            case 'GET':
                //get request and single parameter means request to get entry by id
                if(count($parameters)==1){
                     $result = $this->context->entries->get($parameters['Id']);
                }
                //get request and no parameter means request to get all entries
                else if(count($parameters)==0){
                    $result = $this->context->entries->getAll();
                }
                //get request and 2 quary string parameters means a filter request over the entries
                else if(count($parameters)==2){
                    $result = $this->context->entries->where($parameters['column'],$parameters['value']);
                }
                break;
            case 'POST':
                //post request: extract posted data from request body, parse it into an array,
                //extrat values from array and make the new entity entry, add the new entry to database
                $newEntry = new Entry();
                $inputJSON = file_get_contents('php://input');
                $input= json_decode( $inputJSON, TRUE );

                $newEntry->title=$input['Title'];
                $newEntry->text=$input['Text'];
                $newEntry->timeStamp = $input['TimeStamp'];


                $this->dbContext->entries->add($newEntry);
                break;
            case 'PUT':
                //Put request: extract posted data from request body, parse it into an array,
                //extrat values from array and make the new entity entry,
                //Aslo take the id of entry to edit from query string
                //update the old entry with new one
                $newEntry = new Entry();
                $inputJSON = file_get_contents('php://input');
                $input= json_decode( $inputJSON, TRUE );

                $newEntry->title=$input['Title'];
                $newEntry->text=$input['Text'];
                $newEntry->timeStamp = $input['TimeStamp'];

                $this->dbContext->entries->update($parameters['Id'], $newEntry);
                break;
            case 'Delete':
                //delete request: extract the id from queyr string, delete entry from database.
                $this->dbContext->entries->delete($parameters['Id']);
                break;


        }

        header('Content-Type: application/json');
        echo json_encode($result);

    }
}


//when theis page is requested, make a new controller object
//and execute the controller
$controller = new EntryController();
$controller->execute();