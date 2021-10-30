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

                #startButton {
                     /* TODO: Position startButton in a proper way */
                }

               
                .wrapper {
                    margin-top:14em;
                    margin-left:1,6em;
                    perspective: 1000px;
                    perspective-origin: 50% 50%;                
                }        

                .tombola {
                    display: none;
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

                #drawFinished {
                    display: none;
                }

        </style>
        <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    </head>
    <body>
      
        <div class="wrapper">
            <h2 id="drawFinished">Die Auslosung ist beendet</h2>
            <div class="tombola">

            </div>
            <button type="button" id="startButton" class="btn btn-primary" onclick="populateTombolaWithData(data)">Klick und hol dir dein Wichtel ab, du Kek.</button>
           
        </div>

    </body>
</html>

<script type="text/javascript">

    var data = null;

    function showMessageDrawIsFinished() {
        $("#drawFinished").show();
    }

    function showTombola() {
        $(".tombola").show();
    }

    function populateTombolaWithData(data) {
        $("#startButton").hide();

        queryServer(function(data) {
            console.log(data);
            this.data = data;
            if (data.pickedPos == -1) {
                return showMessageDrawIsFinished();
            } else {
                var index = 1;
                var rotation = [1440,1485,1530,1575,1620,1665,1710,1755];
                for (var i = 0; i < data.participants.length; i++) {
                    participant = data.participants[i];
                    var pEntry = "<div class='panel p" + index + "'>" + participant + "</div>";
                    $(".tombola").append(pEntry);
                    index++;
                }
                $(".tombola").show();

                var pick = data["pickedPos"]
                var spin = rotation[pick];
                setTimeout(function() {
                    $('.tombola').css({'transform':'rotateX('+spin+'deg) translateZ(-480px)'});
                }, 100)

                setTimeout(callback, 7000, data.pickedName);
            }

        });       
    }

    function queryServer(done) {
        $.ajax({
            url: "participants.php",
        }).then(function(data) {
            done(data);
        });
    }

    /** Kann benutzt werden, wenn es wirklich gewollt ist, dass man noch mal rollen kann. */
    function rollbackSetEntry(name) {
        $.ajax({
            url: "rollback.php?name=" + name
        }).then(function(successful) {
            console.log(successful);
            // TODO: Check, ob successful true ist.
            // Dann: Lade Seite neu
            location.reload();
        })
    }
    

    function callback(name) {
        alert("Damit ist es amtlich. Dein Wichtel ist " + name);
    }


</script>