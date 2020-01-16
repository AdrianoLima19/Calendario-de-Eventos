<?php

try{
    $connect = new PDO("mysql:host=localhost;dbname=database_evea","root","");
 }
catch(PDOException $e){
    echo $e->getMessage();
}
