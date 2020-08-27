<html id="interface">
    
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHX6 Career Development Center</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/main.css">
    </head>

    <body>

        <?php
                $user = 'admin';
                $server = 'localhost';
                $password = '';
                $database = 'careerDev';

                $conn = new mysqli($server,$user,$password,$database);

                if(!$conn){
                        echo('<br>');
                        // echo("connection failed");
                        echo('<br>');
                } else {
                        echo('<br>');
                        // echo('connection successful');
                        echo('<br>');
                }

                if(isset($_POST['submit'])){
                        $bNum = $_POST['bNum'];

                        //post data to db

                        $query = "INSERT INTO interest (badgeNum, Contacted, Date) VALUES ($bNum,'0',NOW())";

                        echo('<br>');
                        if($conn->query($query)) {
                                // echo('data succesfully posted');

                        } else {
                                echo('<br>');
                                echo('data was not posted');
                                echo('<br>');
                                echo('<br>');
                                $conn->close();
                        }
                }

        ?>
 
            <form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input autofocus type="text" name="bNum">         
                  <input type = "submit" name = "submit" value = "Submit"> 
            </form>
    </body>
</html>
