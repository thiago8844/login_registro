<?php 

declare(strict_types=1);
namespace App\Controller;

class HomeController {

  public function renderHomeView() {
    echo "Home page";
    
    include __DIR__."/../Views/Home.php";
  }

  public function createUser() {
    
  }
}

?>

html