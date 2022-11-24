<?php include "../connect.php"?>
<?php
session_start();
if(!isset($_SESSION["username"])){ //check ว่า login แล้วหรือยัง
    header("location:../home.php");
}
if($_SESSION["role"]=="user"){
    header("location:../member/user_home.php");
}
?>
<html>
    <head>
        <title>Everyday Baked Bakery</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <script src="script.js" defer></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="./admin_css/home.css">
        <link rel="stylesheet" href="./admin_css/editmenu.css">
        <script>
            let http = new XMLHttpRequest();
            function shtype(){
                let shw = document.getElementById("showtype");
                shw.className = "showlist";
                <?php 
                $stmt=$pdo->prepare("SELECT DISTINCT ชนิดขนม FROM ขนม");
                $stmt->execute();
                $x=0;
                while($row=$stmt->fetch()):?>
                    let <?="span".$x?> = document.createElement("span");
                    <?="span".$x?>.innerHTML = "•<?=$row["ชนิดขนม"]?> ";
                    console.log("<?="span".$x?>");
                    shw.appendChild(<?="span".$x?>);
                <?php $x++;
                endwhile;?>
                
            }
            function shfes(){
                let shw = document.getElementById("showfes");
                shw.className = "showlist";
                <?php 
                $stmt=$pdo->prepare("SELECT DISTINCT ประเภทตามเทศกาล FROM ขนม");
                $stmt->execute();
                $x=0;
                while($row=$stmt->fetch()):?>
                    let <?="span".$x?> = document.createElement("span");
                    <?="span".$x?>.innerHTML = "•<?=$row["ประเภทตามเทศกาล"]?> ";
                    console.log("<?="span".$x?>");
                    shw.appendChild(<?="span".$x?>);
                <?php $x++;
                endwhile;?>
            }
            function shclear(theid){
                console.log(theid);
                let cle = document.getElementById(theid);
                cle.className = "clearlist";
                cle.innerHTML = "";
            }
        </script>
    </head>
    
    <body>
        <header class="logo">everyday-baked-bakery
            <!-- bar for mobile -->
            <a href="#" class="toggle-button">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </a>
            <!-- bar for mobile -->
        </header>
        <nav class= "allbutton">
            <div class="button">
                <ul>
                    <li><a href="./admin_home.php">MOST BUY</a></li>
                    <li><a href="./showuser.php">USER</a></li>
                    <li><a href="./showmenu.php">MENU</a></li>
                    <li><a href="./showorder.php">ORDER </a></li>
                    <li><a href="#" >ADMIN : <?=$_SESSION["username"]?> +</a>
                    <ul>
                        <li><a href="./showclosemenu.php">CLOSE MENU</a></li>
                        <li><a href="./admin_method/logout.php">LOGOUT</a></li>
                    </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <section>
            <article class="add-block">
                <header>EDIT</header>
                <?php
                $stmt=$pdo->prepare("SELECT * FROM ขนม WHERE รหัสขนม = ?");
                $stmt->bindParam(1, $_GET["pid"]);
                $stmt->execute();
                $row=$stmt->fetch();?>
                <form action="./admin_method/edit.php" method="post" enctype="multipart/form-data">
                <div class="img"><img src="../img/<?=$row["รหัสขนม"]?>.jpg" style="width:100%"></div>
                <div>Image : <br><input type="file" name="menuimg"></div>
                <input type="hidden" name="pid" value="<?=$row['รหัสขนม']?>" required>
                <div>ชื่อขนม : <input type="text" name="pname" value="<?=$row['ชื่อขนม']?>" required></div>
                <div>ราคาขนม : <input type="text" pattern="[1-9][0-9]{0,9}" name="price" value="<?=$row['ราคาขนม']?>" required></div>
                <div>ชนิดขนม : <input type="text" name="typ" value="<?=$row['ชนิดขนม']?>" required> <span class="info" onmouseover="shtype()" onmouseout="shclear('showtype')">i</span><p id="showtype"></p></div>
                <div>ประเภทตามเทศกาล : <input type="text" name="fes" value="<?=$row['ประเภทตามเทศกาล']?>" required> <span class="info" onmouseover="shfes()" onmouseout="shclear('showfes')">i</span><p id="showfes"></p></div>
                <input type="submit" id="submit"value="Submit">
                </form>
            </article>
        </section>
    </body>
</html>