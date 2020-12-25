<?php
    // POSTを受け取る
    // POSTの場合はパスワードも送ってみる。

    // var_dump($_POST);
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $kigo = $_POST['kigo'];

    echo  $name;
    echo  $mail;
    echo  $kigo;

    // DBに接続
    try {
        $db = new PDO('mysql:dbname=kigo_anke;host=localhost;charset=utf8','root','root');
        echo "接続OK";
    } catch (PDOException $e) {
        echo 'DB接続エラー: ' . $e->getMessage();
    }


    // DBに値を渡す
    $sql = "INSERT INTO anke (ID,name,mail,kigo) VALUES (NULL, :a1, :a2, :a3)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':a1', $name, PDO::PARAM_STR);
    $stmt->bindValue(':a2', $mail, PDO::PARAM_STR);
    $stmt->bindValue(':a3', $kigo, PDO::PARAM_STR);
    $status = $stmt->execute();

    if($status==false){
        $error = $stmt->errorInfo();
        exit("QueryError;".$error[2]);
    }
    // else{
    //     header("Location: post.php");
    //     exit;
    // }


    function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES);
    }

    // echo $name;
    // echo '<br>';
    // echo $mail;
    // echo '<br>';
    // echo $pw;

    

?>

<html>

<head>
    <meta charset="utf-8">
    <title>POST（受信）</title>
</head>

<body>
    <table>
        <tr>
            <th>名前</th><th>メルアド</th><th>好きな季語</th>
        </tr>
        <?php
            $query = "SELECT * FROM anke";
            // SELECT構文で*を使って全レコードを指定
            $result = $db->query($query);
            // queryを使って$queryに＄$dbの値を渡す
            foreach ($result as $row) {
                echo "<tr>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['mail']."</td>";
                echo "<td>".$row['kigo']."</td>";
                echo "</tr>";
            }
        ?>
</table>


    <!-- <p>お名前：<?= h($name)?> </p>
    <p>EMAIL：<?= h($mail)?> </p>
    <p>好きな季語：<?= h($kigo)?> </p> -->
    <!-- <ul>
        <li><a href="index.php">index.php</a></li>
    </ul> -->
</body>

</html>
