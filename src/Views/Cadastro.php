<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
</head>
<body>
  
<h1>Cadastre-se</h1>

<p>
  <?php 
  if(isset($data["errors"])) {
    foreach($data["errors"] as $error) {
      echo "{$error} <br>";
    }
  }
  ?>
</p>

<form action="/user" method="POST">
<label for="username">Nome de usuário: </label>  
<input type="text" name="username" id="username">
<br>
<label for="email">E-mail: </label>  
<input type="text" name="email" id="email">
<br>
<label for="senha">Senha: </label>  
<input type="password" name="password" id="senha">

<button type="submit">Enviar</button>
</form>
</body>
</html>