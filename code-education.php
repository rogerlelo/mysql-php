<?php

// CONEXÃO AO BANCO
try{
    $statement = new PDO("mysql:host=localhost;dbname=teste;charset=utf8",'root','elaborata');
}catch(PDOException $e){
    die ("Não foi possivel estabelecer a conexão com o banco de dados. Erro: ".$e->getMessage()." Código: ".$e->getCode());
}
$curso = 1;
// CONSULTA
$sql = "SELECT m.id as idModulo, m.titulo as tituloModulo, v.id FROM  modulo m
			INNER JOIN curso c ON c.id = m.id_curso
			INNER JOIN videos v ON  v.id_modulo = m.id 
			WHERE c.id = $curso
			ORDER BY m.titulo ASC";

// REALIZANDO A CONSULTA NO BANCO
//$statement = $connection->query($sql);

//var_dump($resultado);

$stmt = $statement->prepare($sql);
$modulos = [];

$stmt->execute();

while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
    $modulos[$row['id']] = $row;

    $videos = [];
    $stmt2 = $statement->prepare("select id,titulo,tempo_video,s1,s2 from videos where id_curso=$curso and id_modulo=".$row['id']);
    $stmt2->execute();
    while (($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) !== false) {
        $videos[$row['id']] = $row2;
    }
    $modulos[$row['id']]['videos'] = $videos;
}

var_dump($modulos);