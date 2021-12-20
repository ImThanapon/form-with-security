<?php
    require('connect.php');
    header('Content-Type: text/html; charset=utf-8');

    //strrev
    function utf8_strrev($str)
    {
        preg_match_all('/./us', $str, $ar);
        return join('', array_reverse($ar[0]));
    }
    function pass_encrypt($pass, $show = false)
    {
        //you secret word
        $key1    = 'asdfasf';
        $key2    = 'asdfasdf';
        $loop    = 1;
        $reverse = utf8_strrev($pass);

        if ($show == true) {
            echo '<br> กลับตัวอักษร ........................................... : ', $reverse;
        }
        for ($i = 0; $i < $loop; $i++) {
            $md5 = md5($reverse);
            if ($show == true) {
                echo '<br> เข้ารหัสเป็น 32 หลัก (md5)...................... : ', $md5;
            }
            $reverse_md5 = utf8_strrev($md5);
            if ($show == true) {
                echo '<br> กลับตัวอักษร reverse ตัว md5 ที่ได้มา ..... : ', $reverse_md5;
            }
            // substr(สตริงที่ต้องการเปลี่ยน, ตำแหน่งที่เริ่มต้น โดยเริ่มนับจาก 0, ความยาวที่ต้องการ)
            // เลือก 13 ตัวหลัง . md5($key1) . เลือก 13 ตัว แรก . md5($key2)
            $salt = substr($reverse_md5, -13) . md5($key1) . substr($reverse_md5, 0, 19) . md5($key2);  
            if ($show == true) {
                echo '<br> สร้างข้อความใหม่ .................................... : ', $salt;
            }
            $new_md5 = md5($salt);
            if ($show == true) {
                echo '<br> เข้ารหัสเป็น 32 หลัก ................................ : ', $new_md5;
            }
            $reverse = utf8_strrev($new_md5);
            if ($show == true) {
                echo '<br> กลับตัวอักษรอีกครั้ง ................................. : ', $reverse;
            }
        }
        //เข้ารหัส md5
        return md5($reverse);
    }

    // $pass = "สวัสดี+2561";
    $pass = "12345678";
    echo '<br> รหัสที่รับมา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ', $pass;
    echo '<br> md5() ธรรมดา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ', md5($pass);
    echo '<hr>';
    echo '<b>เรียกฟังก์ชั่น pass_encrypt</b>';
    echo '<br> รหัสที่รับมา .............................................. : ', $pass;
    //เข้ารหัส md5 ก่อน
    $encrypt = pass_encrypt($pass, true);


    //เข้ารหัส hash เพื่อนำไปบันทึกลงฐานข้อมูล
    $hash    = password_hash($encrypt, PASSWORD_DEFAULT);
    echo '<hr/> รหัสผ่าน : ' . $pass;
    echo '<br/> ผลลัพธ์ : <b>' . $hash . '</b>';
    echo '<br/>ความยาวของตัวอักษร : <b>', strlen($hash), '</b>';


    //ข้อมูลทดสอบ
    $pass_in_db = '$2y$10$ABYHB2u0KnqW1emgNOSAaeOsAEkwudJ23GW4pGcMKodOtIQCDcKHG'; // is $hash
    $post_data  = "12345678";
    echo '<hr/><br/>from <b>POST</b> = ' . $post_data;
    echo '<br/>data in <b>DB</b> = ' . $pass_in_db;
    echo '<br/><b>Md5</b> = ', md5($post_data);





    //password-verify
    if (password_verify(pass_encrypt($post_data), $pass_in_db)) {
        echo '<br/><br/><span style="color:green">loging สำเร็จ :Password is valid!</span>';
    } else {
        echo '<br/><br/><span style="color:red">loging ไม่สำเร็จ : Invalid password.</span>';
    }
?>

<br /><br />
<h3>Function Reference</h3>
<pre>
http://php.net/manual/en/function.strrev.php
http://php.net/manual/en/function.md5.php
http://php.net/manual/en/function.password-hash.php
http://php.net/manual/en/function.password-verify.php
</pre>