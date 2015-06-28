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
$user->address="sdafds";
$user->FirstName="dfg";
$user->LastName="hdhdfg";

$context->users->add($user);
$context->users->update(3,$user);
$context->users->delete(4);
?>