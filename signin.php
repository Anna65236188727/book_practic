<?php
    include "class.php";
    include "connect.php";
    $show_form=true;
    $show_error=false;
    if(isset($_POST['submit'])){

        $profile_pic_name="x";
        $ncard_pic_name="x";
        $profile_pic_tmpName="";
        $ncard_pic_tmpName="";

        if(isset($_FILES['picture'])){
            $profile_pic_name=$_FILES['picture']['name'];
            $profile_pic_tmpName=$_FILES['picture']['tmp_name'];
        }
        if(isset($_FILES['n_card'])){
            $ncard_pic_name=$_FILES['n_card']['name'];
            $ncard_pic_tmpName=$_FILES['n_card']['tmp_name'];
        }
        

        $myDB= new signin();
        $myDB->data_error($_POST['fname'] , $_POST['lname'] , $_POST['email'] , $_POST['mobile'] , $profile_pic_name , $ncard_pic_name , $_POST['password']);
        if($myDB->error==false){
            $myDB->upload($profile_pic_tmpName , $ncard_pic_tmpName , $profile_pic_name , $ncard_pic_name);
            $myDB->connect_db($host , $username , $password , $database);
            $myDB->insert_data();
            if($myDB->show_form==false)
                $show_form=false;
        }
    }
?>

<!DOCTYPE html>
<html>
  <head>
  	<title>Книжная полка - Регистрация</title>
    <link rel="icon" href="img/logo.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styl.css">
	</head>
	<body>
    <?php header('Content-Type: text/html; charset=utf-8');?>
	<?php 
    
        include "header.php"; 
        if(isset($_POST['submit']) and isset($myDB)){
            $show_error=true;
            if($myDB->empty_error===true){
                echo '<div class="error ur18_black"><span>Заполните все поля &#10071;</span></div>';
            }
            if($myDB->email_exist_error===true)
                echo '<div class="error ur18_black"><span>Электронная почта уже существует &#10071;</span></div>';

        }

        if($show_form==true){
    ?>
    <div class="container"> 
	<div class="login">
            <img class='img_signin' src="img/signin.png" alt="">       
        	<div class="signin-wrap">
				<div class="ub40_black">Регистрация</div>
            	<form class='form_reg' action="#" method="POST" enctype="multipart/form-data">
                <div class="input_name">
                    <label class='ur16_gray' for="fname">Имя</label>
                    <input class='text-field__input ur16_gray' type="text" name="fname" placeholder="Введите имя">
                    <?php
                        if($show_error == true){
                            if($myDB->fname_error === true)
                                echo '<div class="error ur18_black"><span>Напишите имя кириллицей &#10071;</span></div>';
                            if($myDB->fname_lengh_error === true)
                                echo '<div class="error ur18_black"><span>Длина имени не должна превышать 25 символовs &#10071;</span></div>';
                        }
                   ?>
                </div>
        		<div class="input_name">
                    <label class='ur16_gray' for="lname">Фамилия</label>
                    <input class='text-field__input ur16_gray' type="text" name="lname" placeholder="Введите имя">
                    <?php
                        if($show_error == true){
                            if($myDB->lname_error === true)
                                echo '<div class="error ur18_black"><span>Напишите имя кириллицей &#10071;</span></div>';
                            if($myDB->lname_lengh_error === true)
                                echo '<div class="error ur18_black"><span>Длина имени не должна превышать 25 символовs &#10071;</span></div>';
                        }
                   ?>
                </div>
				<div class="input_name">
                    <label class='ur16_gray' for="email">Почта</label>
                    <input class='text-field__input ur16_gray' type="text" name="email" placeholder="Введите почту">
                    <?php
                        if($show_error == true){
                            if($myDB->email_error === true)
                                echo '<div class="error ur18_black"><span>Некорректный адрес электронной почты &#10071;</span></div>';
                        }
                   ?>
                </div>
        		<div class="input_name">
                    <label class='ur16_gray' for="mobile">Номер телефона</label>
                    <input class='text-field__input ur16_gray' type="text" name="mobile" placeholder="Введите номер телефона">
                    <?php
                        if($show_error == true){
                            if($myDB->mobile_error === true)
                                echo '<div class="error ur18_black"><span>Некорректный номер телефона &#10071;</span></div>';
                        }
                   ?>
                </div>
        		<div class="input_name">
					<div class='ur16_gray'>Загрузите свою фотографию</div>
                    <input class='ur16_gray' type="file" name="picture" id="pic" accept="image/*">
                    <?php
                        if($show_error == true){
                            if($myDB->empty_pic_error === true)
                                echo '<div class="error ur18_black"><span>Загрузите свою фотографию &#10071;</span></div>';
                        }
                   ?>
                </div>
        		<div class="input_name">
                    <label class='ur16_gray' for="password">Пароль</label>
                    <input class='text-field__input ur16_gray' type="password" name="password" placeholder="Введите пароль">
                    <?php
                        if($show_error == true){
                            if($myDB->pass_error === true)
                                echo '<div class="error"><span>Пароль должен содержать не более 20 символов &#10071;</span></div>';
                        }
                   ?>
                </div>
				<input class="ub18_white button w100" type="submit" name="submit" value="Зарегистрироваться">
            </form>
            <div class='ur18_black'>У вас уже есть аккаунт? <a class='blue' href="login.php">Войти</a></div>
			</div>
		</div>
    <?php } ?>

		</div>
        <?php include "footer.php" ?>
	</body>
</html>

