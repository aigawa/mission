<?php
     $dsn = 'データベース名';
     $user = 'ユーザー名';
     $password = 'パスワード';
     $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     //テーブル作成
     $sql = "CREATE TABLE IF NOT EXISTS tbpost"
     ." ("
     . "id INT AUTO_INCREMENT PRIMARY KEY,"
     . "name char(32),"
     . "comment TEXT,"
     . "date DATETIME"
     .");";
     $stmt = $pdo->query($sql);
     header("Content-Type: text/html; charset=UTF-8"); //文字コードをUTF-8にする
           $date = new DATETIME();
           $date = $date->format('Y-m-d H:i:s');
           //投稿
           if(isset($_POST["name"]) && $_POST["name"] !== ""){
             if(isset($_POST["comment"]) && $_POST["comment"] !== ""){
              if(empty($_POST["edit_num"])){
               if($_POST["password"] == "1504"){
                //データ入力
                $sql = $pdo -> prepare("INSERT INTO tbpost (name, comment, date) VALUES (:name, :comment, :date)");
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                $name = $_POST["name"];
                $comment = $_POST["comment"];
                
                $sql -> execute();
               } else {
                  echo "パスワードが一致しません。";
                 }
              }
             }
           }   
         //削除判定
        if(isset($_POST["delete"]) && $_POST["delete"] !== ""){
         if($_POST["d_password"] == "1504"){
          $id = $_POST["delete"];
          $sql = 'delete from tbpost where id=:id';
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->execute();
         } else {
            echo "パスワードが一致しません。";
           }
        }

     //編集判定
     if(isset($_POST["edit"]) && $_POST["edit"] !== ""){
      if($_POST["e_password"] == "1504"){
        $edit = $_POST["edit"];
        $sql = 'SELECT * FROM tbpost';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach($results as $row){
          if($edit == $row['id']){
            $edit_num = $row['id'];
            $edit_name = $row['name'];
            $edit_comment = $row['comment'];
          } 
        }
       } else {
          echo "パスワードが一致しません。";
         }
     }

      //編集実行
      if(!empty($_POST["edit_num"])){
       if(isset($_POST["name"]) && $_POST["name"] !== ""){
        if(isset($_POST["comment"]) && $_POST["comment"] !== ""){
         if($_POST["password"] == "1504"){
           $id = $_POST["edit_num"];
           $name = $_POST["name"];
           $comment = $_POST["comment"];
           $sql = 'update tbpost set name=:name,comment=:comment where id=:id';
           $stmt = $pdo->prepare($sql);
           $stmt->bindParam(':name', $name, PDO::PARAM_STR);
           $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
           $stmt->bindParam(':id', $id, PDO::PARAM_INT);
           $stmt->execute();
          } else {
             echo "パスワードが一致しません。";
           }
        }
       } 
     } 
?>
<html>
  <head>
    <title>https://tb-210683.tech-base.net/mission_3-5.php</title>
    <meta charset = "utf-8">
  </head>
  <body>
    <form action = "https://tb-210683.tech-base.net/mission_5-1.php" method = "post">
    [入力フォーム]<br/> 
    名前:<br/>
       <input type = "text" name = "name" value = "<?php if(!empty($edit_name)){echo $edit_name;}?>" /><br/>
       <br/>
    コメント:<br/>
       <textarea name="comment" cols="30" rows="5"><?php if(!empty($edit_comment)){echo $edit_comment;}?></textarea><br/>
       <br/>
    パスワード:
       <input type = "text" name = "password" value = ""><br/>
       <input type = "submit" value = "送信"><br/>
       <input type = "hidden" name = "edit_num" value = "<?php if(!empty($edit_num)){echo $edit_num;}?>">
    [削除フォーム]<br/>
    削除番号:
       <input type = "text" name = "delete" value = "" />
       <input type = "submit" value = "削除"><br/>
    パスワード:
       <input type = "text" name = "d_password" value = ""><br/>
       <br/>
    [編集番号指定フォーム]<br/>
    編集番号:
       <input type = "text" name = "edit" value = "" />
       <input type = "submit" value = "編集"><br/>
     パスワード:
       <input type = "text" name = "e_password" value = ""><br/>
  </body>
</html>
    <?php
      //読み込み
     $dsn = 'データベース名';
     $user = 'ユーザー名';
     $password = 'パスワード';
     $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     //データ表示
     $sql = 'SELECT * FROM tbpost';
     $stmt = $pdo->query($sql);
     $results = $stmt->fetchAll();
     foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'];
		echo $row['name'];
		echo $row['comment'];
                echo $row['date']."<br>";
     }
    ?> 
 