<?php

class OneClickDeployerFileTransfert {

  public function __construct($hostname, $username, $password, $basepath)
  {
    $this->hostname = $hostname;
    $this->username = $username;
    $this->password = $password;
    $this->basepath = $basepath;
  }

  private function ensureIsConnected() 
  {
    if(!isset($this->conn)) {
      $this->conn = ftp_connect($this->hostname);
      ftp_login($this->conn, $this->username, $this->password);
      ftp_set_option($this->conn, FTP_USEPASVADDRESS, false);
      ftp_pasv($this->conn, true);
    }
  }

  private function getLocalPath($path)
  {
    return ABSPATH . ltrim($path, '/');
  }

  private function getRemotePath($path)
  {
    $path = ltrim($path, '/');
    return "{$this->basepath}{$path}";
  }

  public function send($path) 
  {
    $this->ensureIsConnected();

    // if($this->filesystem->exists($this->getRemotePath($path))) {
    //   $dirpath = $this->getRemotePath(rtrim($path, '/'));
    //   $pathinfo = pathinfo($dirpath);
    //   $this->execCommandSuccessfully('chdir', [$pathinfo['dirname']]);
    //   $this->execCommandSuccessfully('move', [$pathinfo['basename'], "{$pathinfo['basename']}.back", true]);
    // }

    // on crée le basepath s'il n'existe pas
    if(!@ftp_chdir($this->conn, $this->getRemotePath('/'))) {
      $splitedPath = explode('/', $this->getRemotePath('/'));
      $splitedPath = array_filter($splitedPath);
      if(count($splitedPath)) {
        ftp_chdir($this->conn, '/');
        foreach($splitedPath as $pathPart) {
          if(!@ftp_chdir($this->conn, $pathPart)) {
            ftp_mkdir($this->conn, $pathPart);
            ftp_chdir($this->conn, $pathPart);
          }
        }
      }
    }

    
    $dirs = [rtrim($path, '/')];
    $this->createDir($path);
    // @TODO check symlink : ne pas les envoyer pour éviter de sortir du dossier
    do {
      $searchInDir = $this->getLocalPath(array_shift($dirs));
      $localPaths = glob("{$searchInDir}/*");
      foreach($localPaths as $localPath) {
        $relativePath = str_replace(ABSPATH, '/', $localPath);
        if(is_dir($localPath)) {
          $dirs[] = $relativePath;
          $this->createDir($this->getRemotePath($relativePath));
        } else {
          $pathinfo = pathinfo($this->getRemotePath($relativePath));
          ftp_chdir($this->conn, $pathinfo['dirname']);
          echo "sync {$pathinfo['basename']}<br/>\n";
          ftp_put($this->conn, $pathinfo['basename'], $localPath, FTP_BINARY);
          if (@ftp_chmod($this->conn, 0644, $pathinfo['basename'] !== false)) {
            echo "chmod {$pathinfo['basename']}<br/>\n";
          }
        }
      }
    } while(count($dirs));
    
    ftp_close($this->conn);
    unset($this->conn);
  }

  private function createDir($path) 
  {
    // @TODO support microsoft path
    $splitedPath = explode('/', $path);
    $splitedPath = array_filter($splitedPath);
    
    if(count($splitedPath)) {
      ftp_chdir($this->conn, $this->getRemotePath('/'));
      foreach($splitedPath as $pathPart) {
        if(!@ftp_chdir($this->conn, $pathPart)) {
          echo "create {$pathPart}<br/>\n";
          ftp_mkdir($this->conn, $pathPart);
          if(@ftp_chmod($this->conn, 0755, $pathPart) !== false) {//decoct(fileperms($this->getLocalPath($testPath)) & 0777));
            echo "chmod {$pathPart}<br/>\n";
          }
          ftp_chdir($this->conn, $pathPart);
        }
      }
    }
  }

  private function execCommandSuccessfully($method, $params = []) 
  {
    $result = call_user_func_array([$this->filesystem, $method], $params);
    if($result === false) {
      throw new Error($this->filesystem->errors->get_error_message(). ' -- command '.$method.' params '. implode(', ', $params));
    }
    return $result;
  }
}