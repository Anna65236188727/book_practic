<?php
    $user_login=false;
    if(isset($_SESSION['user_login'])){
        $user_login=true;
    }
?>
<header>
        <div class="container">
            <div class="head">
            <a href="../index.php">
                <img class="logo" src="../img/logo.png" alt="logo">
            </a>
                <nav class="nav">
                    <div class="search">
                        <form action="../search.php" method="POST">
                            <input type="text" name="search" placeholder="Найти..." required><input type="submit"
                                name="srch_sub" value="Поиск" id="search">
                        </form>
                    </div>
                    <div class="tel_adres">
                        <div class="ub18_black">+7 (900) 505-55-55</div>
                        <div class="ur12_gray">booksshelf@gmail.com</div>
                    </div>
                    <div class="btn">
                    <?php
                        if($user_login==true){                   
                            echo '<a href="../subscription.php"><button class="ub18_white">Подписка</button></a>';
                            echo '<a href="../user_profile.php"><button class="ub18_white">Профиль</button></a>';
                            echo '<a href="../logout.php"><button class="ub18_white">Выход</button></a>';
                        
                            $user=new loged_user();
                            $user->connect_db($host , $username , $password , $database);
                            $user->profile_pic();
                            $profile=$user->profile;
                            echo "<div class='header-prf'><img src='../upload/profile_pic/$profile'></div>";
                        }
                    
                        else{
                            ?>
                    <a href="../signin.php"><button class="ub18_white">Регистрация</button></a>
                    <a href="../login.php"><button class="ub18_white">Вход</button></a>
                    <?php } ?>
                    </div>
                </nav>

                <!-- Иконка бургерменю -->
                <div class="burger">
                    <span></span>
                </div>
            </div>
    </header>
    </div>
    </div>

    <script>
        document.querySelector('.burger').addEventListener('click', function () {
            this.classList.toggle('active');
            document.querySelector('.nav').classList.toggle('open');
        })
    </script>




