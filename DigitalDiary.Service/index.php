<?php
require_once('Model/User/User.php');
require_once('Model/User/UserRepository.php');
require_once('Model/Entry/Entry.php');
require_once('Model/Entry/EntryRepository.php');
require_once('Model/DigitalDiaryDbContext.php');
require_once('Model/DigitalDiaryDb.php');

//mysqli_report(MYSQLI_REPORT_ALL);

$context = new DigitalDiaryDbContext();

$user = new User();
$user->address="hello";
$user->FirstName="wow";
$user->LastName="wlp";

$context->users->add($user);
//foreach ($context->users->getAll() as $row) {
//    foreach ($row as $key=>$value)
//    {
//        echo "$value    ";
//    }

//}
foreach ($context->users->where('Id','4') as $row) {
    foreach ($row as $key=>$value)
    {
    	echo "$value    ";
    }

}

?>