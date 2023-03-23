<?php
// namespace App\Config;

class ErrorHandler {
  public static function handleException(Throwable $exeption): void
  {
     http_response_code(500);

     echo json_encode([
      'code'=>$exeption->getCode(),
      'message'=>$exeption->getMessage(),
      'file'=>$exeption->getFile(),
      'line'=>$exeption->getLine(),
     ]);
     exit;
  }

  public static function handleError (
    int $errno,
    string $errstr,
    string $errfile,
    int $errline
  ) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
  }
}