<?php

declare(strict_types = 1);

class Database {

  //Dados da conexão
  private static mysqli $conn; // 

  //Impede o instanciamento
  private function __construct()
  {
    
  }

  public static function getConnection(): mysqli{
    //Caso a variável estática da conexão esteja como nula adiciona os dados a ela
    if(!isset(self::$conn)) {
      $host = "localhost";
      $username = "root";
      $password = "";
      $database = "users_db";
      
      //Cria a instância da conexão com a classe mysqli
      self::$conn = new mysqli(
        $host,
        $username,
        $password,
        $database,
      );

      //Caso haja falha na conexão termina o script e deixa a mensagem de erro
      if(self::$conn->connect_error) die("Conexão Falhou" . self::$conn->connect_error);
    }
    

    return self::$conn; //Retorna o objeto da conexão
  }
}