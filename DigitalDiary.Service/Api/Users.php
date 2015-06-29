<?php
require_once('../Model/User/User.php');
require_once('../Model/User/UserRepository.php');
require_once('../Model/Entry/Entry.php');
require_once('../Model/Entry/EntryRepository.php');
require_once('../Model/DigitalDiaryDbContext.php');
require_once('../Model/DigitalDiaryDb.php');

$controller =new UserController();
$controller->
execute();


class UserController
{
    public $context;

    function __construct(){
        $this->context = new DigitalDiaryDbContext();

    }

    public function execute(){
        $method = $_SERVER['REQUEST_METHOD'];
        $query = $_SERVER['QUERY_STRING'];
        parse_str($query,$parameters);


        switch ($method)
        {
            case 'GET':
                if(count($parameters)==1){
                    $result = $this->context->users->get($parameters['Id']);
                }
                else if(count($parameters)==0){
                    $result = $this->context->users->get();
                }
                else if(count($parameters)==2){
                    $result = $this->context->users->where($parameters['column'],$parameters['value']);
                }
                break;
            case 'POST':
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
                $this->context->users->delete($parameters['Id']);
                break;


        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}

