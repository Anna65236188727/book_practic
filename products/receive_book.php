<?php
    session_start();
    if(!isset($_GET['book_id']))
        header("location:../index.php");

        include "../class.php";
        include "../connect.php";
        $book_id=$_GET['book_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/styl.css">
    <link rel="icon" href="../img/logo.ico" type="image/x-icon">

    <title>Книжная полка</title>
</head>
<body>
    <?php
        include "header.php";
        $myDB=new produts();
        $myDB->connect_db($host , $username , $password , $database);
        $myDB->show_book_info("$book_id");
        if($myDB->book_not_exist===false){
    ?>

    <div class="book-info-container">
        <div class="show_book_info">
            <div class="show-book-pic">
                <?php
                    echo "<img src='../image/books/$myDB->book_category/$myDB->book_picture'>";
                ?>
            </div>
            <div class="book-info">
                <?php
                    echo "
                    <div>
                        <div class='ub40_black'>$myDB->book_name</div>
                    </div>
                    <div>
                        <div class='um30_black'>$myDB->book_author</div>
                    </div>
                    <div>
                        <div class='ur12_gray'>Категория:</div>
                        <div class='ur22_black'>$myDB->book_category</div>
                    </div>
                    <div>
                        <div class='ur12_gray'>Количество страниц:</div>
                        <div class='ur22_black'>$myDB->book_page</div>
                    </div>
                    <div>
                        <a href='download.php?book_id=$myDB->book_id'>
                            <button class='ub18_white w100'>Скачать</button>
                        </a>
                    </div>
                    ";
                ?>
            </div>
        </div>

        <div class="show-book-disc">
            <?php
                echo "<div class='ur30_black'>Описание</div>";
                echo "<div class='ur16_gray desc'>$myDB->book_description</div>";
            ?>
        </div>

       
    </div>
    <?php } ?>
    <?php include "footer.php" ?>
</body>
</html>