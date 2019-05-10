<?php

class OneClickDeployerRemoteServer {

  public function __construct($opts) {
    $this->opts = $opts;
  }

  public function syncFiles($path) {

    $fileTransfert = new OneClickDeployerFileTransfert(
      $this->opts['ftp']['hostname'],
      $this->opts['ftp']['username'],
      $this->opts['ftp']['password'],
      $this->opts['ftp']['basepath']
    );
    $fileTransfert->send(trailingslashit($path));
  }

}
