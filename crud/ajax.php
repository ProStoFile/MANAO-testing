<?php

    require "crud-class.php";
    $obj = new crud();

    if(isset($_POST['fetch'])){
        $obj->fetch();
    }

    if(isset($_POST['del'])){
        $id = $_POST['id'];
        $obj->del($id);
    }

    if(isset($_POST['add'])){
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $obj->addnew($login,$password,$email,$username);
    }

    if(isset($_POST['edit'])){
        $id = $_POST['id'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $obj->edit($id,$login,$password,$email,$username);
    }

?>