<?php
    $db = new SQLite3('db/wichteln2');

if($_REQUEST['oldname']) {
    $db->query("UPDATE participants SET assigned = 0 WHERE name = '{$_REQUEST['oldname']}'");
}
    $index = 1;
    $res = $db->query('SELECT * FROM participants');
    while ($row = $res->fetchArray()) {
        $array[$row['name']] = $row['assigned'];
        if($_REQUEST['oldname'] && $_REQUEST['oldname']==$row['name']) {
            $array[$row['name']] = 1;
        }
    }
    $filtered_array = array_filter($array, function($var) {  return !$var; });
    if(count($filtered_array) > 0){
        $name = array_rand($filtered_array);
        $db->query("UPDATE participants SET assigned = 1 WHERE name = '{$name}'");
        $pos = array_search($name, array_keys($array));
    } else {
        //$db->query("UPDATE participants SET assigned = 0");
        $pos = -1;
    }

?>


<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
                body { 
                    background: url('img/wallpaper.jpeg') no-repeat center center fixed; 
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;
                }
                h2 {
                    color:white;
                    font-size:5em;
                    text-shadow: 2px 2px #ff0000;

                }
                * {
                    box-sizing: border-box;
                }

                p {
                    font-size:1.3em;
                }

               
                .wrapper {
                    margin-top:14em;
                    margin-left:1,6em;
                    perspective: 1000px;
                    perspective-origin: 50% 50%;                
                
                }        
                .tombola {
                position: relative;
                width: 90%;
                height: 200px;
                margin: 120px auto;
                transform-style: preserve-3d;
                transform-origin: center center -480px;
                transform: rotateX(0deg) translateZ(-480px);
                transition: 4s ease all;
                }
                .panel {
                top: 0px;
                padding: 60px;
                font-size: 40px;
                font-weight: bold;
                text-transform: uppercase;
                position: absolute;
                width: 90%;
                height: 200px;
                color: white;
                text-align: center;
                line-height: 2em;
                background: #94DBAF;
                border: 1px solid #297a48;
                }
                .p1 {
                    transform: translateZ(240px);
                    background: #94DBAF;
                    border: 1px solid #297a48;
                }
                .p2 {
                    transform: rotateX(-45deg) translateZ(240px);
                    background: #94d2db;
                    border: 1px solid #296f7a;
                }
                .p3 {
                    transform: rotateX(-90deg) translateZ(240px);
                    background: #949cdb;
                    border: 1px solid #29337a;
                }
                .p4 {
                    transform: rotateX(-135deg) translateZ(240px);
                    background: #c194db;
                    border: 1px solid #5c297a;
                }
                .p5 {
                    transform: rotateX(-180deg) translateZ(240px);
                    background: #db94c0;
                    border: 1px solid #7a295b;
                }
                .p6 {
                    transform: rotateX(-225deg) translateZ(240px);
                    background: #db9d94;
                    border: 1px solid #7a3429;
                }
                .p7 {
                    transform: rotateX(-270deg) translateZ(240px);
                    background: #dbd294;
                    border: 1px solid #7a7029;
                }
                .p8 {
                    transform: rotateX(45deg) translateZ(240px);
                    background: #aedb94;
                    border: 1px solid #477a29;
                }

                a {
                    display:block;
                }

        </style>
        <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
       
    </head>
    <body>
      
        <div class="wrapper">
            <?php if($pos == -1) {  ?>
                <h2>Die Auslosung ist beendet</h2>
            <?php } else { ?>
        <div class="tombola">
            <?php foreach($array as $nam => $assigned) { ?>
                <div class="panel p<?php echo $index; ?>"><?php echo $nam; ?></div>
            <?php $index++; } ?>
          
        </div>
        <?php } ?>
        </div>


    </body>
</html>

<script type="text/javascript">
            // Script to randomise the panel the tombola lands on
            $(document).ready(function(){
                var rotation = [1440,1485,1530,1575,1620,1665,1710,1755];
                //var pick = Math.floor(Math.random()*8);
                var pick = <?php echo $pos; ?>;
                var spin = rotation[pick];
                $('.tombola').css({'transform':'rotateX('+spin+'deg) translateZ(-480px)'});
                setTimeout(callback, 7000); //Ruft die Callback-Funktion nach 3 Sekunden auf

            });

            function callback() {
                if(confirm("Du hast <?php echo $name ?> gezogen. Bist du das selbst?")) {
                    if(confirm("Dann wird jetzt nochmal gelost")) {
                        window.location.href = "?oldname=<?php echo $name ?>";
                    }
                } else {
                    alert("Dann ist es amtlich. Dein Wichtel ist: <?php echo $name; ?>. Schließe jetzt die Seite!");
                }
            }


        </script>