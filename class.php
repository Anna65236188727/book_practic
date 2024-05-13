<?php

    class signin{
        public $error=false;
        public $empty_error=false;
        public $empty_pic_error=false;
        public $empty_img_error=false;
        public $fname_error=false;
        public $lname_error=false;
        public $fname_lengh_error=false;
        public $lname_lengh_error=false;
        public $email_error=false;
        public $email_exist_error=false;
        public $mobile_error=false;
        public $pass_error=false;

        public $fname;
        public $lname;
        public $addr;
        public $email;
        public $mobile;
        public $pass;
        public $n_card_pic;
        public $profile_pic;
        public $active;

        private $mysql;

        public $show_form=true;
        public $successful_signin=false;


        function data_error($fname , $lname , $email , $mobile , $profile_pic , $n_card_pic , $pass){
            try{
                if(empty($fname) or empty($lname) or empty($email) or empty($mobile) or empty($pass))
                    throw new Exception();
//имя
                try{
                    if(strlen($fname)>25)
                        throw new Exception('lengh');
                }
                catch(Exception $e){
                    $this->error=true;
                    if($e->getMessage()=='lengh')
                        $this->fname_lengh_error=true;
                }
//фамилия
                try{
                    if(strlen($lname)>25)
                        throw new Exception('lengh');
                }
                catch(Exception $e){
                    $this->error=true;
                    if($e->getMessage()=='lengh')
                        $this->lname_lengh_error=true;
                }
//почта
                try{
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
                        throw new Exception();
                }
                catch(Exception $e){
                    $this->error=true;
                    $this->email_error=true;
                }
//телефон
                try{
                    if(!ctype_digit($mobile))
                        throw new Exception();
                }
                catch(Exception $e){
                    $this->error=true;
                    $this->mobile_error=true;
                }
//пароль
                try{
                    if(strlen($pass)>25)
                        throw new Exception();
                }
                catch(Exception $e){
                    $this->error=true;
                    $this->pass_error=true;
                }
//изображение
                try{
                    if(empty($profile_pic))
                        throw new Exception();
                }
                catch(Exception $e){
                    $this->error=true;
                    $this->empty_pic_error=true;
                }
            }
            catch(Exception $e){
                $this->error=true;
                $this->empty_error=true;
            }

            $this->fname=$fname;
            $this->lname=$lname;
            $this->email=$email;
            $this->mobile=$mobile;
            $pass=trim($pass);
            $this->pass=md5($pass);
            // $this->n_card_pic=$n_card_pic;
            $this->profile_pic=$profile_pic;

            header("Location: index.php");
        }

//загрузка изображения
        function upload($profile_tmpName , $n_card_tmpName , $profile_name , $n_card_name){
            move_uploaded_file($profile_tmpName,"upload/profile_pic/$profile_name");
            // move_uploaded_file($n_card_tmpName,"upload/nationalCard_pic/$n_card_name");
        }

//подключение к бд
        function connect_db($db_host , $db_username , $db_password , $db_name){
            $this->mysql= new mysqli($db_host , $db_username , $db_password , $db_name);
            if($this->mysql->connect_error)
                die('connection error');
        }

//сохранение пользователя в бд
        function insert_data(){
            $sql="SELECT * FROM user WHERE email='$this->email'" ;
            $resault=$this->mysql->query($sql);
            if($resault->num_rows>0){
                $this->email_exist_error=true;
            }
            else{
                $activation_code=0;
                $sql="INSERT INTO user(firstName , lastName , email , phoneNumber , password , confirmCode ,activation , profile_pic , nationalCard_pic , subscription , subscription_end)
                VALUE('$this->fname' , '$this->lname' , '$this->email' , '$this->mobile' , '$this->pass' , '$activation_code' , 'yes' , '$this->profile_pic' , '$this->n_card_pic' , 'no' , 'no subscription')";
                $resault=$this->mysql->query($sql);
                $this->mysql->close();
                if($resault===true){
                    $this->active=$activation_code;
                    $this->successful_signin=true;
                    $this->show_form=false;
                }
                else{
                    die("Не удалось сохранить");
                }
            }
        }
    }



    class login{

        public $error=false;
        public $empty_error=false;
        public $email_error=false;
        public $notExist_error=false;
        public $activation_error=false;

        public $email;
        public $password;
        public $active=true;

        private $mysql;

        function login_data_error($email , $pass){
            try{
                if(empty($email) or empty($pass))
                    throw new Exception();

                try{
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
                        throw new Exception();
                }
                catch(Exception $e){
                    $this->error=true;
                    $this->email_error=true;
                }

            }
            catch(Exception $e){
                $this->error=true;
                $this->empty_error=true;
            }
            $this->email=$email;
            $pass=trim($pass);
            $this->pass=md5($pass);
        }

        function connect_db($db_host , $db_username , $db_password , $db_name){
            $this->mysql= new mysqli($db_host , $db_username , $db_password , $db_name);
            if($this->mysql->connect_error)
                die('connection error');
        } 


        function login_permission(){
            $sql="SELECT * FROM user WHERE email='$this->email' AND password='$this->pass'";
            $result=$this->mysql->query($sql);
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $_SESSION['fname']=$row['firstName'];
                $_SESSION['lname']=$row['lastName'];
                $subscription_end=$row['subscription_end'];
                $subscription=$row['subscription'];
                $id=$row['user_ID'];
                if($row['activation']=='yes'){
                    $_SESSION['user_login']=$id;
                    $_SESSION['email']=$this->email;
                    $date=date("Y/m/d");
                    if($subscription=='yes' and $date >= $subscription_end){
                        $sql="UPDATE user SET subscription='no' WHERE user_ID='$id'";
                        $this->mysql->query($sql);
                    }
                    header("location:index.php");
                }
                else{
                    $_SESSION['email']=$this->email;
                    $this->active=false;
                }
                
            }
            else{
                $this->notExist_error=true;
            }
        }


        function active_account($activecode){
            $email=$_SESSION['email'];
            $sql="SELECT * FROM user WHERE email='$email' AND confirmCode='$activecode'";
            $result=$this->mysql->query($sql);
            if($result->num_rows>0){
                $row=$result->fetch_assoc();
                $_SESSION['user_login']=$row['user_ID'];
                $sql="UPDATE user SET activation='yes' WHERE email='$email'";
                $result=$this->mysql->query($sql);
                $this->active=true;
                header("location:index.php");
            }
            else{
                $this->activation_error=true;
            }
    
            
        }
    }



    class loged_user{

        private $mysql;
        public $profile;
        public $fname;
        public $lname;
        public $email;
        public $mobile;
        public $n_card;

        public $book_name;
        public $book_pic;
        public $download_date;

        public $email_exist_error=false;

        public function __get($name) {
            if (property_exists($this, $name)) {
                return $this->$name;
            } else {
                // Обработка ошибки или логирование
                error_log("Attempted to get property '$name' on non-existent property");
                return null;
            }
        }
    
        // Метод для установки значения свойства
        public function __set($name, $value) {
            if (property_exists($this, $name)) {
                $this->$name = $value;
            } else {
                // Обработка ошибки или логирование
                error_log("Attempted to set property '$name' on non-existent property");
            }
        }


        function connect_db($db_host , $db_username , $db_password , $db_name){
            $this->mysql= new mysqli($db_host , $db_username , $db_password , $db_name);
            if($this->mysql->connect_error)
                die('connection error');
        } 

        function profile_pic(){
            $email=$_SESSION['email'];
            $sql="SELECT * FROM user WHERE email='$email'";
            $resault=$this->mysql->query($sql);
            $row=$resault->fetch_assoc();
            $this->profile=$row['profile_pic'];
        }
//инфо в профиле
        function user_info($id){
            $sql="SELECT * FROM user WHERE user_ID='$id' ";
            $resault=$this->mysql->query($sql);
            $row=$resault->fetch_assoc();
            $this->profile=$row['profile_pic'];
            $this->fname=$row['firstName'];
            $this->lname=$row['lastName'];
            $this->email=$row['email'];
            $this->mobile=$row['phoneNumber'];
            $this->n_card=$row['nationalCard_pic'];
            $this->sub_end=$row['subscription_end'];
        }
//сохранение даты подписки
        function subscribtion_history($id , $credit_card , $expiration , $cost){
            $date=date("Y/m/d");
            $end="";
            if($expiration=="day") 
                $end=date('Y/m/d', strtotime($date. ' + 1 days'));
            if($expiration=="week")
                $end=date('Y/m/d', strtotime($date. ' + 7 days'));
            if($expiration=="month")
                $end=date('Y/m/d', strtotime($date. ' + 1 months'));

            $sql="INSERT INTO payment(user_id , date ,cost , credit_card_num , subscription_type /* , subscription_end */)VALUE('$id' , '$date' , '$cost' , '$credit_card' , '$expiration'/*  , '$end' */)";
            $this->mysql->query($sql);

            $sql="UPDATE user SET subscription='yes',subscription_end='$end' WHERE user_ID='$id'";
            $this->mysql->query($sql);
        }

//история скачиваний
        function download_info($id){
            $sql="SELECT * FROM download INNER JOIN books ON download.book_ID = books.book_ID WHERE user_ID='$id'";
            $resault=$this->mysql->query($sql);
            if($resault->num_rows>0){
                for($i=0 ; $i<$resault->num_rows ; $i++){
                    echo "<tr>";
                        $row=$resault->fetch_assoc();
                        $bookname=$row['bookName'];
                        $date=$row['date'];
                        $bpic=$row['book_picture'];
                        $book_category=$row['category'];
                        echo "
                        <td>$bookname</td>
                        <td>$date</td>
                        <td><img src='image/books/$book_category/$bpic' style='width:60px; height:60px;'></td>";

                    echo "</tr>";
                }
            }
        }

//история оплаты
        function paymet_info($id){
            $sql="SELECT * FROM payment WHERE user_ID='$id' ";
            $resault=$this->mysql->query($sql);
            if($resault->num_rows>0){
                for($i=0 ; $i<$resault->num_rows ; $i++){
                    echo "<tr>";
                        $row=$resault->fetch_assoc();
                        $credit_card=$row['credit_card_num'];
                        $date=$row['date'];
                        $subscription_type=$row['subscription_type'];
                        $cost=$row['cost'];
                        echo "
                        <td>$credit_card</td>
                        <td>$date</td>
                        <td>$subscription_type</td>
                        <td>$cost $</td>";
                    echo "</tr>";
                }
            }
        }


        function edit_info($field , $new , $id){
            if($field=='email'){
                $sql="SELECT * FROM user WHERE email='$new'" ;
                $resault=$this->mysql->query($sql);
                if($resault->num_rows>0){
                    $this->email_exist_error=true;
                }
                else{
                    $sql="UPDATE user SET email='$new' WHERE user_ID='$id'";
                    $this->mysql->query($sql);
                    header("location:user_profile.php");
                }
            }
            else{
                $sql="UPDATE user SET $field='$new' WHERE user_ID='$id'";
                $this->mysql->query($sql);
                header("location:user_profile.php");
            }
        }
    }



    class produts{
        private $mysql;
        public $book_name;
        public $book_category;
        public $book_description;
        public $book_picture;
        public $book_author;
        public $book_page;
        public $book_id;
        public $book_not_exist=false;

        function connect_db($db_host , $db_username , $db_password , $db_name){
            $this->mysql= new mysqli($db_host , $db_username , $db_password , $db_name);
            if($this->mysql->connect_error)
                die('connection error');
        } 
       
        function products($category){
            echo "<div class='ub30_black title'>$category</div>";
            $sql="SELECT * FROM books WHERE category='$category'";
            $resault=$this->mysql->query($sql);
            $this->mysql->close();
            if($resault->num_rows>0){  
                echo "<div class='categories2'>";
                for($i=0 ; $i<$resault->num_rows ; $i++){
                    $row=$resault->fetch_assoc();
                    $bname=$row['bookName'];
                    $book_pic=$row['book_picture'];
                    $book_id=$row['book_ID'];
                    echo "<a href='receive_book.php?book_id=$book_id'>
                            <div class='product_container'>
                                <div class='product-pic'>
                                    <img src='../image/books/$category/$book_pic'>
                                </div>
                                <div class='product-name ub18_black'>
                                    <p>$bname</p>
                                </div>
                            </div>
                        </a>";
                }
                echo "</div>";
            }

            else{
                echo "nothing exist";
            }
        }

        function show_book_info($book_id){
            $sql="SELECT * FROM books WHERE book_ID='$book_id'";
            $resault=$this->mysql->query($sql);
            if($resault->num_rows>0){
                $book=$resault->fetch_assoc();
                $this->book_name=$book['bookName'];
                $this->book_description=$book['description'];
                $this->book_category=$book['category'];
                $this->book_picture=$book['book_picture'];
                $this->book_id=$book_id;
                $this->book_author=$book['author'];
                $this->book_page=$book['page_count'];

            }

            else{
                $this->book_not_exist=true;
            }
        }
    }
?>