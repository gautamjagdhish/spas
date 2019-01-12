<?php 
    require "conn.php";
    $train_no = $_POST["name"];
    $phone_no = $_POST["email"];
    echo "Train number is ".$train_no." and phone no is ".$phone_no;
    /*$train_no='12345';
    $phone_no='08903784784';*/
    $q = "INSERT INTO passengers_phno(phone_no,train_no) VALUES ('$phone_no','$train_no')";
    if(!mysqli_query($conn ,$q))
        echo "error inserting data to database";
    $q="SELECT * FROM forum_post WHERE train_no='$train_no'";
    $result=$conn->query($q);
    if($result->num_rows > 0)
    {
        $row=$result->fetch_assoc();
        $id=$row["id"];
        $platform_no=$row["platform_no"];
        $expected_arrival=$row["expected_arrival"];
        $content=$row["content"];
        $urlurl="http://10.196.1.81:8000/post/".$id;
        $use='stage';
        $message = "Your train (train no. :".$train_no.") is running with ".$content.". Expected arrival time is ".$expected_arrival." at Platform number ".$platform_no.". For further updates, visit ".$urlurl;
    }
    else
        $message="Trains with number ".$train_no." doesn't exist or not coming to this station";
    echo $message;
    $url="www.way2sms.com/api/v1/sendCampaign";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);// set post data to true
    //mgj api=8SYLQEVQKZYYN831UGR4K5130WZYX9A0 and secret=BK9MHDJNZLI2HR2Q
    //ashrith api=3EXJR0P4FE0YN3OB3D03272XNZ4Q6ZA4 and secret=9RUMNR1Z4VCI74HJ
    curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=3EXJR0P4FE0YN3OB3D03272XNZ4Q6ZA4 &secret=9RUMNR1Z4VCI74HJ &usetype=stage &phone=$phone_no & senderid=SPASPA &message=$message");
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    echo $result;
?>