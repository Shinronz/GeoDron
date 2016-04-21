#!/usr/local/bin/php -q
<?php

require_once('websockets.php');
$address = "100.114.154.60";
$port = "6789";

class echoServer extends WebSocketServer {
  //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.
  
  protected function process ($user, $message) {
    $this->stdout($message);
   // $this->send($user, $message);
   foreach ($this->users as $user){
      $this->send($user,$message);
    }
    $fb = fopen('/home/nasa/position.json', 'w'); 
    fwrite($fb,$message);
    fclose($fb);
  }
  
  protected function connected ($user) {
    // Do nothing: This is just an echo server, there's no need to track the user.
    // However, if we did care about the users, we would probably have a cookie to
    // parse at this step, would be looking them up in permanent storage, etc.
  }
  
  protected function closed ($user) {
    // Do nothing: This is where cleanup would go, in case the user had any sort of
    // open files or other objects associated with them.  This runs after the socket 
    // has been closed, so there is no need to clean up the socket itself here.
  }
}

$echo = new echoServer($address,$port);

try {
  $echo->run();
}
catch (Exception $e) {
  $echo->stdout($e->getMessage());
}
