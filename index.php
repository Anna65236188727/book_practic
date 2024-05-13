<?php
    session_start();
    include "class.php";
    include "connect.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/styl.css">
    <title>Книжная полка</title>
    <link rel="icon" href="img/logo.ico" type="image/x-icon">
</head>
<body>
    <header>
       <?php include "header.php" ?>
    </header>
    <div class="container">
        <div class="offer">
            <div class="l_offer">
                <div class="ub40_black">Книги всегда под рукой с нашей электронной библиотекой</div>
                <a href="#catalog"><button class="ub24_white">В каталог</button></a>
            </div>
            <img class='r_offer' src="img/login.png" alt="">
        </div>
    </div>

 
    <div class="container" id='catalog'>
        <h3 class="catrgory-title ub30_black">Жанры книг</h3>
        <div class="categories">
            <a href="products/books_category.php?category=Научная фантастика">
                <div class="product">
                    <div>
                        <img src="image/category/nauchna_fantastika.png" alt="nauchna_fantastika">
                    </div>
                    <div class="um22_blue">
                        <p>Научная фантастика</p>
                    </div>
                </div>
            </a>

            <a href="products/books_category.php?category=Детектив">
                <div class="product">
                    <div>
                        <img src="image/category/detektiv.png" alt="detektiv">
                    </div>
                    <div class="um22_blue">
                        <p>Детектив</p>
                    </div>
                </div>
            </a>

            <a href="products/books_category.php?category=Научная литература">
                <div class="product">
                    <div>
                        <img src="image/category/nauchna_literatura.png" alt="nauchna_literatura">
                    </div>
                    <div class="um22_blue">
                        <p>Научная литература</p>
                    </div>
                </div>
            </a>

            <a href="products/books_category.php?category=Приключения">
                <div class="product">
                    <div>
                        <img src="image/category/prikluchenia.png" alt="prikluchenia">
                    </div>
                    <div class="um22_blue">
                        <p>Приключения</p>
                    </div>
                </div>
            </a>

            <a href="products/books_category.php?category=Роман">
                <div class="product">
                    <div>
                        <img src="image/category/roman.png" alt="roman">
                    </div>
                    <div class="um22_blue">
                        <p>Роман</p>
                    </div>
                </div>
            </a>

            <a href="products/books_category.php?category=Фэнтези">
                <div class="product">
                    <div>
                        <img src="image/category/fentezi.png" alt="fentezi">
                    </div>
                    <div class="um22_blue">
                        <p>Фэнтези</p>
                    </div>
                </div>
            </a>

            <a href="products/books_category.php?category=Комедия">
                <div class="product">
                    <div>
                        <img src="image/category/komedia.png" alt="komedia">
                    </div>
                    <div class="um22_blue">
                        <p>Комедия</p>
                    </div>
                </div>
            </a>
            <a href="products/books_category.php?category=Поэзия">
                <div class="product">
                    <div>
                        <img src="image/category/poezia.png" alt="poezia">
                    </div>
                    <div class="um22_blue">
                        <p>Поэзия</p>
                    </div>
                </div>
            </a>
            <a href="products/books_category.php?category=Детская литература">
                <div class="product">
                    <div>
                        <img src="image/category/detska_literatura.png" alt="detska_literatura">
                    </div>
                    <div class="um22_blue">
                        <p>Детская литература</p>
                    </div>
                </div>
            </a>
           </div>
        </div>
    </div>
    <?php include "footer.php" ?>
</body>
</html>