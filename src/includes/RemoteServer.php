<?php

class OneClickDeployerRemoteServer {

  public function __construct($opts) {
    $this->opts = $opts;
  }

  public function syncFiles($path) {

    $fileTransfert = new OneClickDeployerFileTransfert(
      $this->opts['hostname'],
      $this->opts['username'],
      $this->opts['password'],
      $this->opts['basepath']
    );
    $fileTransfert->send(trailingslashit($path));
  }

}
