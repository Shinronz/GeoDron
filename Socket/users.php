<?php

class WebSocketUser {

  public $socket;
  public $id;
  public $source;
  public $userid;
  public $headers = array();
  public $handshake = false;

  public $handlingPartialPacket = false;
  public $partialBuffer = "";

  public $sendingContinuous = false;
  public $partialMessage = "";
  
  public $hasSentClose = false;

  function __construct($id, $socket) {
    $this->id = $id;
    $this->socket = $socket;
  }

  function setData($userid, $source) {
    $this->userid = $userid;
    $this->source = $source;
  }
}