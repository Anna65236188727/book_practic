<?php
    session_start();

    $subscription=false;
    if(!isset($_SESSION['user_login'])){
        header("location:index.php");
    }
    $id=$_SESSION['user_login'];

    $show_form=true;
    include "class.php";
    include "connect.php";


    $mysql= new mysqli($host , $username , $password , $database);
    $sql="SELECT subscription FROM user WHERE user_ID='$id' AND subscription='yes'";
    $resault=$mysql->query($sql);
    $mysql->close();
    if($resault->num_rows>0){
        $subscription=true;
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Книжная полка</title>
    <link rel="icon" href="img/logo.ico" type="image/x-icon">
    

    <link rel="stylesheet" href="style/styl.css">

    <script>
        function expiration(optiontag){
            let opt_tg=optiontag.value;
            if(opt_tg=="day"){
                document.getElementById('cost').innerText="Cost 10$"
            }
            if(opt_tg=="week"){
                document.getElementById('cost').innerText="Cost 50$"
            }
            if(opt_tg=="month"){
                document.getElementById('cost').innerText="Cost 200$"
            }
        }
    </script>
</head>
<body>
<?php 
        include "header.php"; 
        if(isset($_POST['submit']) and $subscription==false){
            

            
            $card_number=$_POST['card_number'];
            $expiration=$_POST['expiration'];
            $cost="";
            if($expiration=="day")
                $cost=10;
            if($expiration=="week")
                $cost=50;
            if($expiration=="month")
                $cost=200;
            $myDB = new loged_user();
            $myDB->connect_db($host , $username , $password , $database);
            $myDB->subscribtion_history($id , $card_number , $expiration , $cost);
            
            echo "
                <div style='text-align:center; color: #ffffff;background-color: #1055CC;padding:7px; font-weight:bold;border: 2px solid darkgreen; margin-top:20px;'>
                    <p>Подписка успешно оформлена &#9989;</p>
                    <p>теперь вы можете скачать любую книгу, какую захотите</p>
                </div>
                <p style='background-color: #d1d1d1; color: #3C3C3C; text-align:center;padding:10px;'>Переходим на главную страницу ...</p>
                ";
            $show_form=false;
            header("refresh:3;url=index.php");
        }    

//Подписка уже есть
        else if($subscription==true){
            $show_form=false;
            echo "<div style='text-align:center; color: #ffffff;background-color: #1055CC;padding:7px; font-weight:bold;border: 2px solid darkgreen; margin-top:20px;'>
            <p>У вас уже есть подписка</p>
            </div>
            <p style='background-color: #d1d1d1; color: #3C3C3C; text-align:center;padding:10px;'>Переходим на главную страницу ...</p>
            ";
            header("refresh:3;url=index.php");     
        }

        if($show_form==true){
    ?>
    <div class='container'>
                <div class="login">
                    <img class='img_signin' src="img/sub.png" alt="">
                    <div class="signin-wrap">
                        <div class="ub40_black">Оформить подписку </div>
                        <div class="ub30_black" id="cost">Стоимость: 300₽</div>
                        
                        <form class='pass_email' action="#" method="POST">
                            <div class="input_name">
                                <label class='ur18_black'>Выберите желаемое количество времени </label>
                                <select class='text-field__input ur22_black' name="expiration">
                                    <option value="day" onclick="expiration(this)">Один день</option>
                                    <option value="week" onclick="expiration(this)"> Одна неделя</option>
                                    <option value="month" onclick="expiration(this)"> Один месяц</option>
                                </select>
                            </div>

                            <div class="input_name">
                                <label class='ur16_gray' for="name">Номер карты</label>
                                <input class='text-field__input' type="number" name="card_number" placeholder="Введите номер карты" required>
                            </div>

                            <div class="input_name">
                                <label class='ur16_gray' for="password">Пароль</label>
                                <input class='text-field__input' type="password" name="password" placeholder="Введите пароль" required>
                            </div>

                            
                            <input class="ub18_white button w100" type="submit" name="submit" value="Купить">

                        </form>
                        
                    </div>
                </div>
            </div>
    <?php } ?>
    <?php include "footer.php" ?>
</body>
</html>