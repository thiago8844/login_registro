<?php

declare(strict_types=1);

namespace App\Model;

use Database;
use Exception;
use mysqli;

require_once __DIR__ . "/../Database.php"; //Importa a classe estática da conexão com o banco

class User
{
  //Adiciona a conexão com o banco ao modelo  
  private mysqli $conn;

  //Cria a conexão ao ser instânciada
  public function __construct()
  {
    $this->conn = Database::getConnection();
  }

  //CRUDS

  //Cria usuário
  public function create(array $data)
  {

    [$username, $email, $password] = $data;

    //Faz o query SQL
    try {
      $this->conn->query("INSERT INTO users (user_name, email, senha) VALUES ('{$username}', '{$email}', '{$password}')");
    } catch (Exception $e) {
      die("Não foi possível criar usuário <br> {$e->getMessage()}");
    }
    $this->conn->close();
  }

  //Lê o usuário pelo ID
  public function readUserById(int $id)
  {
    try {
      //Faz o query
      $user = $this->conn->query("SELECT * FROM users WHERE id = '{$id}'");

      //Caso não encontre nenhum usuário retorna falso
      if ($user->num_rows == 0) return false;

      //Caso encontre retorna um mapa com os dados desse usuário
      return mysqli_fetch_assoc($user);
    } catch (Exception $e) {
      die("Erro ao reaver usuário <br> {$e->getMessage()}");
    }
  }

  public function readUserByEmail(string $email)
  {
    try {
      //Faz o query
      $user = $this->conn->query("SELECT * FROM users WHERE email = '{$email}'");

      //Caso não encontre nenhum usuário retorna falso
      if ($user->num_rows == 0) return false;

      //Caso encontre retorna um mapa com os dados desse usuário
      return mysqli_fetch_assoc($user);
    } catch (Exception $e) {
      die("Erro ao reaver usuário <br> {$e->getMessage()}");
    }
  }

  public function readUserByName($name)
  {
    try {
      //Faz o query
      $user = $this->conn->query("SELECT * FROM users WHERE user_name = '{$name}'");

      //Caso não encontre nenhum usuário retorna falso
      if ($user->num_rows == 0) return false;

      //Caso encontre retorna um mapa com os dados desse usuário
      return mysqli_fetch_assoc($user);
    } catch (Exception $e) {
      die("Erro ao reaver usuário <br> {$e->getMessage()}");
    }
  }
}
