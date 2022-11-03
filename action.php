<?php

    $hostName='localhost';
    $authName='root';
    $pass='';
    $dbname='users';

    $conn= mysqli($hostName,$authName,$pass,$users);
    switch($_POST['action']) {
        case 'login':
            $text=$_POST['text'];
            $email=email_hash($_POST['email'], EMAIL_DEFAULT);
            $text=$_POST['text'];
            $password=$_POST['password'];
          
            $sql = "INSERT INTO users(text, email, text, password) VALUES('$text','$email', '$text', '$password')";
            $run_qry=mysqli_query($conn,$sql);
            if($run_qry){
                header("location:login.php");
            }  
            break;
        // case 'login':
        //     $email=$_POST['email'];
        //     $password=$_POST['password'];

        //     $select_user="SELECT * FROM users WHERE email='$email'";
        //     $run_qry=mysqli_query($conn,$select_user);
        //     if (mysqli_num_rows($run_qry)>0) {
        //         while ($row=mysqli_fetch_assoc($run_qry)) {
        //             if (password_verify('$password', $row['password'])){
        //                 $email=$row['email'];
        //                 session_start();
        //                 $_SESSION['email']=$row['email']
        //                 header("location:");
        //             }
        //             else {
        //                 header("location: login.php");
        //             }
        //         }
        //     }
        //     break;
        

    }

// if(isset($_POST['encrypt'])){

//     $simple_string = $_POST['email'];
//     echo "Original Data :" . $simple_string;
//     echo <br>;

//     $ciphering = "AES-128-CTR";
//     $option = 0;
//     $encryption_iv = '1234567890123456';
//     $encryption_key = "hello";
//     $encryption = openssl_encrypt($simple_string,$ciphering,$encryption_key,$option,$encryption_iv); 

//     echo "Encyption Data :" .$encryption;
//     echo "<br>";

// }

?>