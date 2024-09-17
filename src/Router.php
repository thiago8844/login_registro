<?php

declare(strict_types=1);

namespace App;

use Exception;

class Router
{

  private $routes = [];

  //Adiciona uma rota
  public function addRoute(string $path, string $method, array $controller)
  {
    $path = $this->normalizePath($path);

    $routes = &$this->routes;
    if (isset($routes[$path])) {
      //Criar exceção
      if ($routes[$path]["method"] == $method) return;
    }

    $routes[] = ["path" => $path, "method" => strtoupper($method), "controller" => $controller];
  }

  //Padroniza as rotas
  private function normalizePath(string $path): string
  {
    $path = trim($path, "/"); //Remove a contrabarra no início e no final da string $path
    $path = "/{$path}/"; //Adiciona a contrabarra no início e no final

    $path = preg_replace("#[/]{2,}#", "/", $path); //Expressão regular para identificar '/' consecutivas

    return $path;
  }

  public function routerDespatcher(string $path, string $method)
  {
    $path = $this->normalizePath($path);
    $method = strtoupper($method);
    
    $routes = &$this->routes;
    //Guard Clause pro loop
    foreach ($routes as $route) {
      if (!preg_match("#^{$route['path']}$#", $path) || $route["method"] != $method) {

        continue;
      }

      [$class, $function] = $route["controller"];


      $controllerInstance = new $class();

      $controllerInstance->{$function}();
      return;
    }

    http_response_code(404);
    include __DIR__ . "/Views/404.php";
  }
}
