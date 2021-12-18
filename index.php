<?php
$json = file_get_contents('people.json');
$json_data = json_decode($json,true);
$contents=file_get_contents("messages.txt");
$lines=explode("\n",$contents);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $en_name = $_POST['person'];
    $fa_name = $json_data[$en_name];
    $question = $_POST['question'];
    $key_of_array=intval(hash("sha256",$question.$en_name))%sizeof($lines);
    $msg = $lines[$key_of_array];
  }
else {

    $en_name = array_rand($json_data);
    $fa_name = $json_data[$en_name];
    $question= NULL;
    $msg='سوال خود را بپرس';
}         

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
    <span id="label">پرسش:</span>
            <span id="question"><?php echo $question ?></span>
        

    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post" action='index.php'>
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">  
            <?php
                echo '<option value="'.$en_name.'">'.$fa_name.'</option>';
                     foreach ($json_data as $key => $value)
                 { 
                     if($key != $en_name)
                     {echo '<option value="'.$key.'">'.$value.'</option>';}
                 }
            ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>