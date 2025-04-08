<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CertificazioniController
{
  public function index(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $id_alunno = $args["id"];
    $query = "SELECT * FROM certificazioni WHERE alunno_id = $id_alunno";
    $id_cert = isset($args["id_cert"]) ? $query .= " AND id = $args[id_cert]" : null; 
    $result = $mysqli_connection->query($query);
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  public function insert(Request $request, Response $response, $args){
    $mysqli_connection = new MySQLi('my_mariadb', 'root', 'ciccio', 'scuola');
    $id_alunno = $args["id"];
    $query = "INSERT INTO certificazioni (alunno_id, titolo, votazione, ente) VALUES ()";
    $inputs = json_decode($request->getBody()->getContents(), true);
    if(isset($inputs[""]))
    // $result = $mysqli_connection->query($query);
    // $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

}
