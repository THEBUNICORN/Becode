<?php
/**
 * Easy log with the database via PDO!
 */
$db = new PDO('mysql:host=localhost;dbname=id2755047_chat;charset=utf8', 'id2755047_root', 'thebunikorn, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
/**
 * Analyse de request made via  the 'URL (GET) In order to dafin de déterminer si on souhaite récupérer les messages ou en écrire un
 */
$task = "list";
if(array_key_exists("task", $_GET)){
  $task = $_GET['task'];
}
if($task == "write"){
  postMessage();
} else {
  getMessages();
}
/**
 * If we want to get it back, we'll send a JSON request. 
 */
function getMessages(){
  global $db;
  // 1.We request the database to take out the last 20 last messages.
  $resultats = $db->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 20");
  // 2.We treat the results
  $messages = $results->fetchAll();
  // 3.We'll display the data in a JSON form
  echo json_encode($messages);
}
/**
 * If we want to write the opposite, we'll have to analyze the settings sent in POST and save them in the database.
 */
function postMessage(){
  global $db;
  // 1. Analyse the previous settings in POST (author, content).
  
  if(!array_key_exists('author', $_POST) || !array_key_exists('content', $_POST)){
    echo json_encode(["status" => "error", "message" => "One field or many have not been sent"]);
    return;
  }
  $author = $_POST['author'];
  $content = $_POST['content'];
  // 2. Create a request that will enable us to add data
  $query = $db->prepare('INSERT INTO messages SET author = :author, content = :content, created_at = NOW()');
  $query->execute([
    "author" => $author,
    "content" => $content
  ]);
  // 3.  Give a status to the success or failure in a JSON form.
  echo json_encode(["status" => "success"]);
}
 */