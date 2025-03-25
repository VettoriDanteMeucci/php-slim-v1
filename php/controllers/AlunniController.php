<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni");
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function view(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $result = $mysqli_connection->query("SELECT * FROM alunni WHERE id = " . $args["id"]);
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function create(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $inputs = json_decode($request->getBody()->getContents(), true);
    $name = $inputs["name"];
    $surname = $inputs["surname"];
    $query = "INSERT INTO alunni (nome ,cognome) 
    VALUES ( '$name', '$surname' ); ";
    $mysqli_connection->query($query);
    $response->getBody()->write(json_encode($inputs));
    return $response->withHeader("Content-Type", "application/json")->withStatus(200);
  }

  public function update(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $newInfo = json_decode($request->getBody()->getContents(), true);
    $name = $newInfo['name'];
    $surname = $newInfo['surname'];
    $query = "UPDATE alunni 
    SET nome = '$name', cognome = '$surname' 
    WHERE id = $args[id]";
    $mysqli_connection->query($query);
    $response->getBody()->write(json_encode($newInfo));
    return $response->withHeader("Content-Type", "application/json")->withStatus(201);
  }

  public function delete(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $query = "DELETE FROM alunni WHERE id = $args[id]";
    $res = $mysqli_connection->query($query);
    if($res){
      return $response->withStatus(200);
    }else{
      return $response->withStatus(404);
    }
  }
}
