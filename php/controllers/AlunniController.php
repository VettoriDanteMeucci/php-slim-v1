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

  public function isAttribute($value){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $res = $mysqli_connection->query("DESCRIBE alunni");
    $res = $res->fetch_all(MYSQLI_ASSOC);
    foreach($res as $row){
      if($row["Field"] == $value){
        return true;
      }
    }
    return false;
  }

  public function search(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $val = explode(":", $args["value"]); 
    $str = $val[0];
    $orderby = strtolower($val[1]);    
    $sort = strtoupper($val[2]);
    $query = "SELECT * FROM  
    alunni WHERE nome LIKE '%$str%' 
    OR cognome LIKE '%$str%' ";
    if($this->isAttribute($orderby)){
      $query .= " ORDER BY $orderby ";
      if(($sort == "DESC" || $sort == "ASC") ){
        $query .= $sort;
      }
    }
    $res = $mysqli_connection->query($query);
    $res = $res->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($res));
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
