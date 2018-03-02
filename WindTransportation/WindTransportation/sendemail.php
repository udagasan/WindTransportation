<?php
   

    session_cache_limiter( 'nocache' );
    header( 'Expires: ' . gmdate( 'r', 0 ) );
    header( 'Content-type: application/json' );


    $to         = 'niamul@uiCookies';

    $email_template = 'simple.html';

    $subject    = strip_tags($_POST['subject']);
    $email       = strip_tags($_POST['email']);
    $phone      = strip_tags($_POST['phone']);
    $name       = strip_tags($_POST['name']);
    $company       = strip_tags($_POST['company']);
    $city       = strip_tags($_POST['city']);
    $message    = nl2br( htmlspecialchars($_POST['message'], ENT_QUOTES) );
    $result     = array();


    if(empty($name)){

        $result = array( 'response' => 'error', 'empty'=>'name', 'message'=>'<strong>Error!</strong> �sim  bo� olamaz!.' );
        echo json_encode($result );
        die;
    } 

    if(empty($email)){

        $result = array( 'response' => 'error', 'empty'=>'email', 'message'=>'<strong>Error!</strong> Mail bo� olamaz .' );
        echo json_encode($result );
        die;
    } 

    if(empty($message)){

         $result = array( 'response' => 'error', 'empty'=>'message', 'message'=>'<strong>Error!</strong> L�tfen g�nderece�iniz mesaj� yaz�n�z.' );
         echo json_encode($result );
         die;
    }
    


    $headers  = "From: " . $name . ' <' . $email . '>' . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";


    $templateTags =  array(
        '{{subject}}' => $subject,
        '{{email}}'=>$email,
        '{{message}}'=>$message,
        '{{name}}'=>$name,
        '{{company}}'=>$company,
        '{{city}}'=>$city,
        '{{phone}}'=>$phone
        );


    $templateContents = file_get_contents( dirname(__FILE__) . '/email-templates/'.$email_template);

    $contents =  strtr($templateContents, $templateTags);

    if ( mail( $to, $subject, $contents, $headers ) ) {
        $result = array( 'response' => 'success', 'message'=>'<strong>Success!</strong> Talebiniz al�nm��t�r. Te�ekk�r ederiz' );
    } else {
        $result = array( 'response' => 'error', 'message'=>'<strong>Error!</strong> Mail g�nderiminde hata olu�tu.'  );
    }

    echo json_encode( $result );

    die;
