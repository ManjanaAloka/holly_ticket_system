<?php

error_reporting(0);
include '../include/conn.php';
session_start();


$result = array();

// =====================  login  ========================

if ($_REQUEST['login'] == true) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];


    $slect1 = $conn->query("SELECT email FROM `admin` WHERE  email='$email' AND `pass`='$password'");

    if ($slect1->num_rows == 1 && !empty($password) && !empty($email)) {
        $_SESSION['email'] = $email;
        $result['login'] = "ok";
    } elseif ($slect1->num_rows == 0 && !empty($password) && !empty($email)) {

        $result['login'] = "error_1"; //try to log in with signup first 


    } else {
        $result['login'] = "error_2"; // try again

    }
}

// =====================  create ticket  ========================
if ($_REQUEST['create_ticket'] == true) {
    $index = $_REQUEST['index'];
    $qr_code = md5($index . "_" . $date);
    $result['abc'] = $qr_code;
    $slect1 = $conn->query("SELECT `index` FROM `user` WHERE  `index`='$index'");

    if ($slect1->num_rows == 1 && $index != "") {
        $slect2 = $conn->query("SELECT `id` FROM `ticket` WHERE  `user_id`='$index'");
        $result['ref_ticket_count'] = $slect2->num_rows;
        $result['create_ticket'] = "1"; // kalin id eka use karala
        if ($_REQUEST['ref_ticket'] == true) {
            // $sql = $conn->query("INSERT INTO ticket(`user_id`,`qr`, `date`) VALUES ('$index','$qr_code','$date')");


            //⁡⁢⁣⁢====================== Sent Mail =======================⁡
            if ($_REQUEST['sent__mail'] == true) {
                $sender__mail = $_REQUEST['sender__mail'];
                $base64__data = $_REQUEST['base64__data'];
                $qr__code = $_REQUEST['qr__code'];

                #############===𝘽𝙖𝙨𝙚 𝟲𝟰 𝙙𝙖𝙩𝙖 𝙘𝙤𝙣𝙫𝙚𝙧𝙩 𝙛𝙞𝙡𝙚 𝙖𝙣𝙙 𝙨𝙖𝙫𝙚 part======################
                // Base64 encoded string representing the image data
                $base64_string = $base64__data;

                // Extracting the Base64 data part
                $data = explode(',', $base64_string)[1];

                // Decode the Base64 string
                $image_data = base64_decode($data);

                // Generate a unique filename
                $filename = "../tickets/" . $qr__code . '.png';

                // Save the image data to a file
                file_put_contents($filename, $image_data);

                #############===𝙎𝙚𝙣𝙩 𝙈𝙖𝙞𝙡 𝙥𝙖𝙧𝙩======################

                // $to = $sender__mail;
                // $subject = 'UoVT Holly Ticket';
                // $from = 'manjanaaloka997@gmail.com';

                // // Read the file content
                // $file_content = file_get_contents($filename);

                // // Generate a boundary
                // $boundary = md5(time());

                // // Headers
                // $headers = "From: $from\r\n";
                // $headers .= "MIME-Version: 1.0\r\n";
                // $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

                // // Message content
                // $message = "--$boundary\r\n";
                // $message .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
                // $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                // $message .= "Please find the attached file.\r\n\r\n";

                // // File attachment
                // $message .= "--$boundary\r\n";
                // $message .= "Content-Type: application/octet-stream; name=\"" . basename($file_path) . "\"\r\n";
                // $message .= "Content-Transfer-Encoding: base64\r\n";
                // $message .= "Content-Disposition: attachment\r\n\r\n";
                // $message .= chunk_split(base64_encode($file_content)) . "\r\n";

                // // Closing boundary
                // $message .= "--$boundary--";

                // Send email
                // mail($to, $subject, $message, $headers);
                $result['qr__code'] = $base64__data;
                $result['sent__mail'] = 'ok';
            }
            //⁡⁢⁣⁢=======================================================⁡
            $result['qr'] = $qr_code;
            $result['ref_ticket'] = "ok"; // try again

        }
    } elseif ($slect1->num_rows == 0 && $index != "") {
        $sql_1 = $conn->query("INSERT INTO user(`index`, `date`) VALUES('$index','$date')");
        $sql_2 = $conn->query("INSERT INTO ticket(`user_id`,`qr`, `date`) VALUES('$index','$qr_code','$date')");
        $result['qr'] = $qr_code;
        $result['create_ticket'] = "2"; //aluth user kenek
    } else {
        $result['create_ticket'] = "error"; // try again

    }

    $result['index'] = $index;
}


// =====================  scan ticket  ========================
if ($_REQUEST['scan'] == true) {
    $qrdata = $_REQUEST['qrdata'];
    $select1 = $conn->query("SELECT `id`,`status`,`user_id` FROM `ticket` WHERE  `qr`='$qrdata' AND `status`!='0'");
    $fetch1 = $select1->fetch_assoc();
    if ($fetch1['status'] == 1) {
        $result['scan'] = "1"; //valid ticket ekaki
        if ($_REQUEST['entered'] == true) {
            $update = $conn->query("UPDATE ticket SET `status`='2', `date`='$date' WHERE `qr`='$qrdata' AND `status`='1'");
            $result['scan'] = "2"; //valid ticket ekaki
        }
    } elseif ($fetch1['status'] == 2) {
        $result['scan'] = "3"; //before used ticket
    }
}

// ================Fetch All ticket===============
if ($_REQUEST['fetchAllTicket'] == true) {
    $select1 = $conn->query("SELECT `id`,`status`,`user_id` FROM `ticket` WHERE `status`!='0'");
    $result['asd'] = array();
    $x = 1;
    while ($fetchAll =  $select1->fetch_assoc()) {
        array_push($result['asd'], '<tr>
                                        <td>' . $x++ . '</td>
                                        <td>' . $fetchAll['user_id'] . '</td>
                                        <td>' . ($fetchAll['status'] == '1' ? 'Booked' : ($fetchAll['status'] == '2' ? 'Used' : '')) . '</td>
                                    </tr>');
    }
}

echo json_encode($result);
