<?php
//api provides a json interface to communicate to database,
//the client side code will use this interface to fetch users from database


//require dependencies
require_once('../Model/User/User.php');
require_once('../Model/User/UserRepository.php');
require_once('../Model/Entry/Entry.php');
require_once('../Model/Entry/EntryRepository.php');
require_once('../Model/DigitalDiaryDbContext.php');
require_once('../Model/DigitalDiaryDb.php');

//The controller mainly routes the request to related functions
//of user database access layer, using the DigitalDiaryDbContext class
class UserController
{
    public $context;

    function __construct(){
        $this->context = new DigitalDiaryDbContext();

    }

    //The controller execution, implements manual routing of the url to related funcions
    public function execute(){

        //get the http request method and the query string parameters
        $method = $_SERVER['REQUEST_METHOD'];
        $query = $_SERVER['QUERY_STRING'];
        parse_str($query,$parameters);

        //switch over the request method and call appropriate functions

        switch ($method)
        {
            case 'GET':
                //get request and a single query strig parameter means request to get user by id

                if(count($parameters)==1){
                    $result = $this->context->users->get($parameters['Id']);
                }
                //get request and no parameter means request to get all users

                else if(count($parameters)==0){
                    $result = $this->context->users->get();
                }
                //get request and 2 query string parameters means a filter request over users
                else if(count($parameters)==2){
                    $result = $this->context->users->where($parameters['column'],$parameters['value']);
                }
                break;
            case 'POST':
                //post request: extract posted data from request body, parse it into an array,
                //extrat values from array and make the new entity user, add the new user to the database
                $newUser = new User();
                $inputJSON = file_get_contents('php://input');
                $input= json_decode( $inputJSON, TRUE );

                $newUser->username=$input['UserName'];
                $newUser->FirstName=$input['FirstName'];
                $newUser->LastName = $input['LastName'];
                $newUser->password = $input['Password'];
                $newUser->Phone= $input['Phone'];
                $newUser->Picture= $input['Picture'];

                $this->context->users->add($newUser);
                break;
            case 'PUT':
                //Put request: extract posted data from request body, parse it into an array,
                //extrat values from array and make the new entity user,
                //Aslo take the id of user to edit from query string
                //update the old user with new one
                $newUser = new User();
                $inputJSON = file_get_contents('php://input');
                $input= json_decode( $inputJSON, TRUE );

                $newUser->username=$input['UserName'];
                $newUser->FirstName=$input['FirstName'];
                $newUser->LastName = $input['LastName'];
                $newUser->password = $input['Password'];
                $newUser->Phone= $input['Phone'];
                $newUser->Picture= $input['Picture'];

                $this->context->users->update($parameters['Id'],$newUser);
                break;
            case 'Delete':
                //delete request: extract the id from queyr string, delete user from database.

                $this->context->users->delete($parameters['Id']);
                break;


        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}


//when theis page is requested, make a new controller object
//and execute the controller
$controller =new UserController();
$controller->
execute();
