<?php
    session_start();
    if(!isset($_SESSION['user_login'])){
        header("location:../login.php");
        die();
    }
        
    if(!isset($_GET['book_id']))
        header("location:../index.php");

    include "../connect.php";
    $subscription_error=false;
    $id=$_SESSION['user_login'];
    $mysql= new mysqli($host , $username , $password , $database);
    $sql="SELECT subscription FROM user WHERE user_ID='$id' AND subscription='no'";
    $resault=$mysql->query($sql);
    if($resault->num_rows>0){
        $subscription_error=true;
        header("location:../subscription.php");
    }

    
        if($subscription_error==false){
            $book_id=$_GET['book_id'];
            $mysql= new mysqli($host , $username , $password , $database);
            $sql="SELECT category,book_file FROM books WHERE book_ID='$book_id'";
            $resault=$mysql->query($sql);
            $book=$resault->fetch_assoc();
            $category=$book['category'];
            $filename=$book['book_file'];

            $date=date("Y/m/d");
            $user_id=$_SESSION['user_login'];

            $filepath="../files/$category/$filename";

            if(!empty($filename) && file_exists($filepath)){

                $sql="INSERT INTO download(book_ID , user_ID , date) VALUE('$book_id' , '$user_id' , '$date')";
                $resault=$mysql->query($sql);

                header("Cashe-Control: public");
                header("Content-Description: FILe Transfer");
                header("Content-Disposition: attachment; filename=$filename");
                header("Content-Type: application/zip");
                header("Content-Transfer-Emcoding: binary");
    
                readfile($filepath);
                exit;
            }
        }
?>