<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;

class RegisterController
{
  private User $userModel;

  public function __construct()
  {
    $this->userModel = new User();
  }

  //Renderiza a view
  public function  renderRegisterView(array $data = [], int $response_code=200)
  {
    http_response_code($response_code);
    include __DIR__ . "/../Views/Cadastro.php";
    die();
  }

  public function createUser()
  {
    //Limpa os inputs
    $this->sanitizeUserData($_POST);

    //Desestrutura os dados da superglobal $_POST
    ["username" => $username, "email" => $email, "password" => $password] = $_POST;

    //Faz a validação dos dados
    $dataErrors = $this->validateUserData($username, $email, $password);

    //Caso haja erros na validação renderiza a view com erro
    if(count($dataErrors) > 0) $this->renderRegisterView(["errors" => $dataErrors], 409);

    $password = password_hash($password, PASSWORD_DEFAULT); 

    $this->userModel->create([$username, $email, $password]);
  }

  //Filtra os dados do request
  private function sanitizeUserData(array &$data) {
    //Caso haja mais que 3 campos retorna uma resposta de bad request para medidas de segurança
    if(count($data) > 3) {
      echo "bad request";
      die("bad request");
      http_response_code(400);
    }

    $data["username"] = filter_var($data["username"], FILTER_SANITIZE_SPECIAL_CHARS);

    $data["email"] = filter_var($data["email"], FILTER_SANITIZE_SPECIAL_CHARS);

  }

  //Valida os dados do usuário
  private function validateUserData(string $username, string $email): array
  {

    //Verifica a formatação dos dados
    $correctSizeUsername = strlen($username) <= 25 ? true : false;
    $correctSizeEmail = strlen($email) <= 25 ? true : false;

    $emailFormat = preg_match("#^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$#", $email) ? true : false;
    $usernameFormat = preg_match("#^[a-zA-Z0-9_-]$#", $username);

    //Verifica a existência dos usuários
    $usernameExist = $this->userModel->readUserByName($username) ? true : false;
    $emailExist = $this->userModel->readUserByEmail($email) ? true : false;

    $errors = [];

    //Adiciona as mensagens de erro na array
    if(!$correctSizeEmail) array_push($errors, "E-mail muito grande.");
    if(!$correctSizeUsername) array_push($errors, "Tamanho de usuário inválido. O usuário deve ter entre 5 e 25 caracteres.");
    if(!$emailFormat) array_push($errors, "E-mail Inválido.");
    if(!$usernameFormat) array_push($errors, "Usuário Inválido.");
    if($usernameExist) array_push($errors, "Usuário já cadastrado.");
    if($emailExist) array_push($errors, "E-mail já cadastrado.");

    return $errors;
  }
}
