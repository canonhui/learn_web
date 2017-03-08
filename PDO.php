<?php

/*Types d'erreur:
1. could not find driver  数据库引擎错误
2. Unknown MySQL server host  不是localhost
3. Can't connect to MySQL server  serveur est plante/disponible，或者不是mysql服务器
4. Unknown database <db_name>  数据库名称不正确或数据库不存在
5. Access denied for user  用户名或密码错误
*/

try {
	$dns = 'mysql:host=localhost;dbname=test';
	$dbuser = 'root3';
	$dbpass = '';
	
	// Options de connection
	$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);
	
	$conn = new PDO($dns, $dbuser, $dbpass, $options);
	$conn -> query("SET NAMES utf8");
	echo 'connection success!<br>';
} catch(Exception $e) {
	echo 'Error Message:', $e -> getMessage();
	die();
}
$select = $conn -> query('SELECT * FROM test');

// On indique que nous utiliserons les résultats en tant qu'objet
$select->setFetchMode(PDO::FETCH_OBJ);

// Nous traitons les résultats en boucle
while( $enregistrement = $select->fetch() )
{
  // Affichage d'un des champs
  echo '<h1>', $enregistrement->nom, ' ', $enregistrement->prenom, '</h1>';
}

// Traitement d'un seul résultat
$enregistrement = $select->fetch();
 
// On test si la variable $enregistrement, au cas
// ou elle serait vide.
if( $enregistrement ) {
  echo '<h1>', $enregistrement->nom, ' ', $enregistrement->prenom, '</h1>';
} 
// La requète n'a pas retournée de résultat
else {
  echo "Aucun résultat";
}

// Nous traitons les résultats en boucle
// C'est lors de l'utilisation de fetch() que nous spécifions
// le format de récupération pour le traitement.
while( $enregistrement = $select->fetch(PDO::FETCH_OBJ) )
{
  // Affichage d'un des champs
  echo '<h1>', $enregistrement->nom, ' ', $enregistrement->prenom, '</h1>';
}

// On transforme les résultats en tableaux d'objet
$createurs = $select->fetchAll(PDO::FETCH_OBJ);
 
// On traite le tableau $créateur
while( $enregistrement = next($createurs) )
{
  // Affichage d'un des champs
  echo '<h1>', $enregistrement->nom, ' ', $enregistrement->prenom, '</h1>';
}

// Suppression de données
try {
  // On envois la requète (Suppression arbitraire de 2 enregistrements)
  $nombreDeSuppression = $connection->exec("DELETE FROM createurs LIMIT 2");
 
  // On affiche le nombre d'enregistrements supprimés
  echo $nombreDeSuppression, " ont été supprimé.";
 
} catch ( Exception $e ) {
  echo "Une erreur est survenue lors de la suppression";
}

// Préparation de la requète
$selectionPrepa = $connection->prepare('SELECT * FROM createurs WHERE id=? LIMIT 1');
try {
  // On envois la requète
  $selectionPrepa->execute(array(1));
   
  // Traitement
  if( $enregistrement = $selectionPrepa->fetch(PDO::FETCH_OBJ)){
    echo '<h1>', $enregistrement->nom, ' ', $enregistrement->prenom,  '</h1>'; 
  }
} catch( Exception $e ){
  echo 'Erreur de suppression : ', $e->getMessage();
}

$selectionPrepa = $connection->prepare('SELECT * FROM createurs WHERE YEAR(date_naiss)=? AND nationalite=?');
try {
  // On envois la requète
  $selectionPrepa->execute(array(1925, 'fr'));
   
  // Traitement
  while( $enregistrement = $selectionPrepa->fetch(PDO::FETCH_OBJ)){
    echo '<h1>', $enregistrement->nom, ' ', $enregistrement->prenom,  '</h1>'; 
  }
   
} catch( Exception $e ){
  echo 'Erreur de requète : ', $e->getMessage();
}

//Premier cas, un paramètre utilisé plusieurs fois :
$selectionPrepa = $connection->prepare('SELECT * FROM createurs WHERE nom LIKE :search OR prenom LIKE :search;
try {
  // On envois la requète
  $selectionPrepa->execute(array('search'=>'%gi%'));
   
  // Traitement
  while( $enregistrement = $selectionPrepa->fetch(PDO::FETCH_OBJ)){
    echo '<h1>', $enregistrement->nom, ' ', $enregistrement->prenom,  '</h1>'; 
  }
   
} catch( Exception $e ){
  echo 'Erreur de requète : ', $e->getMessage();
}

//Autre cas, beaucoup de paramètres :
$insert = $connection->prepare('INSERT INTO createurs VALUES(
NULL, :nom, :prenom, :date_naiss, :date_mort, :nationalite, :pseudo)');
try {
  // On envois la requète
  $success = $insert->execute(array(
    'nom'=>'Dus',
    'prenom'=>'Jean-Claude',
    'date_naiss'=>date('Y-m-d'),
    'date_mort'=>NULL,
    'nationalite'=>'fr',
    'pseudo'=>NULL
  ));
   
  if( $success ) {
    echo "Enregistrement réussi";
  }  
} catch( Exception $e ){
  echo 'Erreur de requète : ', $e->getMessage();
}

$insert = $connection->prepare('INSERT INTO createurs VALUES(
NULL, :nom, :prenom, :date_naiss, :date_mort, :nationalite, :pseudo)');
try {
  // On rempli les paramètres
  $insert->bindParam(':nom', $nom, PDO::PARAM_STR, 100);
  $insert->bindParam(':prenom', $prenom, PDO::PARAM_STR, 100);
  $insert->bindParam(':date_naiss', date('Y-m-d'));
  $insert->bindParam(':nationalite, $nationalite, PDO::PARAM_STR, 2);
  $insert->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
   
  // On exécute
  $insert->execute();
 
  if( $success ) {
    echo "Enregistrement réussi";
  }  
} catch( Exception $e ){
  echo 'Erreur de requète : ', $e->getMessage();
}

?>