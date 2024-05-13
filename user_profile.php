<?php
    session_start();

    if(!isset($_SESSION['user_login']))
        header("location:index.php");
    include "class.php";
    include "connect.php";

    $id=$_SESSION['user_login'];
    $myDB=new loged_user();
    $myDB->connect_db($host , $username , $password , $database);
    $myDB->user_info($id);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styl.css">
    <title>Книжная полка - Профиль</title>
    <link rel="icon" href="img/logo.ico" type="image/x-icon">
</head>
<body>
    <?php
        include "header.php";
        if(isset($myDB)){       
    ?>

        <div class="container ">
            <div class="user-profile">
                <div class="user_img_info">
                    <div class="user-profile-img">
                        <?php
                            echo "
                                <img src='upload/profile_pic/$myDB->profile'>
                            ";
                        ?>
                    </div>
                    <div class="user-profile-info">
                        <div>
                            <?php
                                echo "
                                    <div class='um22_blue'>Имя:</div>
                                    <div class='ur22_black'>$myDB->fname</div>
                                ";
                            ?>
                        </div>

                        <div>
                            <?php
                                echo "
                                    <div class='um22_blue'>Почта:</div>
                                    <div class='ur22_black'>$myDB->email</div>
                                ";
                            ?>
                        </div>

                        <div>
                            <?php
                                echo "
                                    <div class='um22_blue'>Номер телефона:</div>
                                    <div class='ur22_black'>$myDB->mobile</div>
                                ";
                            ?>
                        </div>
                    </div>
                    <div class="user-profile-setting">
                        <a href="logout.php"><button class="ub18_white">Выход</button></a>
                    </div>
                    
                </div>
                <div class="user-profile-table">
                    <div class='ur30_black'>История скачиваний:</div>
                    <table>
                        <tr>
                            <th class='ub22_black'>Название книги</th>
                            <th class='ub22_black'>Дата скачивания</th>
                            <th class='ub22_black'>Обложка</th>
                        </tr>
                        <?php
                            $myDB->download_info($id);
                        ?>
                    </table>
                </div>
            </div>
        </div>

    <?php } ?>
    <?php include "footer.php" ?>
</body>
</html>