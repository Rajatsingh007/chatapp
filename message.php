<?php

require __DIR__ . '/vendor/autoload.php';

// Change the following with your app details:

// Create your own pusher account @ https://app.pusher.com



// $options = array(

//    'cluster' => 'ap2',

//    'encrypted' => true

//  );

 $options = array(
    'cluster' => 'ap2',
    'useTLS' => true
  );

 $pusher = new Pusher\Pusher(

   '22e880957852add41853',

   '935bbb01e1c3177c0daa',

   '1600620',

   $options

 );



// Check the receive message

if(isset($_POST['message']) && !empty($_POST['message'])) {

  $data = $_POST['message'];
  $time = $_POST['time'];
  $dataToWrite = '<small style="color:red">'.$time.' </small>'. $data.'<br>';
  $dateWiseFile = "messages/messages_".date('d-m-Y').".txt";
  $myfile = fopen($dateWiseFile, "a") or die("Unable to open file!");
  $txt = "$dataToWrite \n";
  fwrite($myfile, $txt);
  fclose($myfile);

// Return the received message

if($pusher->trigger('test_channel', 'my_event', $dataToWrite)) {

echo 'success';

} else {

echo 'error';

}

}