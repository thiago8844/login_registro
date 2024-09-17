<?php

declare(strict_types=1);

namespace App\Controller;

class LoginController
{

  public function renderLoginView()
  {

    include __DIR__ . "/../Views/Login.php";
    echo "Login Controller ativado";
  }
}
