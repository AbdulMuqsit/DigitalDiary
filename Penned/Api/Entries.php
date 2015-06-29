<?php
require_once('../Model/User/User.php');
require_once('../Model/User/UserRepository.php');
require_once('../Model/Entry/Entry.php');
require_once('../Model/Entry/EntryRepository.php');
require_once('../Model/DigitalDiaryDbContext.php');
require_once('../Model/DigitalDiaryDb.php');

$controller = new EntryController();
$controller->execute();


class EntryController
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
                     $result = $this->context->entries->get($parameters['Id']);
                }
                else if(count($parameters)==0){
                    $result = $this->context->entries->get();
                }
                else if(count($parameters)==2){
                    $result = $this->context->entries->where($parameters['column'],$parameters['value']);
                }
                break;
            case 'POST':
                $newEntry = new Entry();
                $inputJSON = file_get_contents('php://input');
                $input= json_decode( $inputJSON, TRUE );

                $newEntry->title=$input['Title'];
                $newEntry->text=$input['Text'];
                $newEntry->timeStamp = $input['TimeStamp'];


                $this->dbContext->entries->add($newEntry);
                break;
            case 'PUT':
                $newEntry = new Entry();
                $inputJSON = file_get_contents('php://input');
                $input= json_decode( $inputJSON, TRUE );

                $newEntry->title=$input['Title'];
                $newEntry->text=$input['Text'];
                $newEntry->timeStamp = $input['TimeStamp'];

                $this->dbContext->entries->update($parameters['Id'], $newEntry);
                break;
            case 'Delete':
                $this->dbContext->entries->delete($parameters['Id']);
                break;


        }



    }
}

