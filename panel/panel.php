<?php

require_once "config.php";
session_start();


// print_r($_POST);
// print_r($_SESSION);

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


if (isset($_POST['delete'])){

    $link->query("TRUNCATE TABLE interest");

}

if(isset($_POST['change_pw'])){
    header("location: change_pw.php");



}

if(isset($_POST['update'])){
    // echo 'update set';
    $updateValue = $_POST['update'];
    $badgeNum = $_POST['badgeNum'];

    if($_POST['update'] == 'No' ){
        $updateValue = 1;
    } else {
        $updateValue = 0;
    }

    $query = "UPDATE interest SET Contacted=? WHERE badgeNum=?";
    // print_r($query);
    $stmt = $link->prepare($query);
    // var_dump($link);
    // var_dump($stmt);
    $stmt->bind_param("ii",$updateValue,$badgeNum);

    if( $stmt->execute() ){
        // echo "prepared update statement was successful";
    } else {
        // echo "pprepared update statement was not successful";
    }

    // $link->query($query);
    
}


?>

<?php ?>




<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHX6 Career Development Center</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel='stylesheet' href='../css/main.css'>
        <script
			  src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
			  integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
			  crossorigin="anonymous"></script>
        <style type="text/css">
.tg  {border-collapse:collapse;border-color:#93a1a1;border-spacing:0;}
.tg td{background-color:#fdf6e3;border-color:#93a1a1;border-style:solid;border-width:0px;color:#002b36;
  font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{background-color:#657b83;border-color:#93a1a1;border-style:solid;border-width:0px;color:#fdf6e3;
  font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .tg-0lax{text-align:left;vertical-align:top}
.tg-sort-header::-moz-selection{background:0 0}
.tg-sort-header::selection{background:0 0}.tg-sort-header{cursor:pointer}
.tg-sort-header:after{content:'';float:right;margin-top:7px;border-width:0 5px 5px;border-style:solid;
  border-color:#404040 transparent;visibility:hidden}
.tg-sort-header:hover:after{visibility:visible}
.tg-sort-asc:after,.tg-sort-asc:hover:after,.tg-sort-desc:after{visibility:visible;opacity:.4}
.tg-sort-desc:after{border-bottom:none;border-width:5px 5px 0}</style>
    </head>
    
    
    <body>
        
    <div class='container wrapper panel-wrapper' >
        
        <div id='formBlock'  >
        <div id='tableWrapper'>
        <table id="tg-RiKTG" class="tg" style='width:400px;'>
            <thead>
                <tr>
                    <th class="tg-0pky">Date</th>
                    <th class="tg-0lax">Badge Number</th>
                    <th class="tg-0lax">Contacted</th>
                </tr>

                <?php

                    $query = "SELECT * FROM interest";
                    $queryResult = $link->query($query);
                    // $link->query("TRUNCATE TABLE careerdev");

                    // get the contacted field from each row
                    // $queryResult->fetch_assoc()['Contacted'];

                    if($queryResult->num_rows > 0){

                        while($row = $queryResult->fetch_assoc()){

                            echo '<tr>';
                            echo '<td>'. $row['Date'] .'</td>';
                            echo '<td>'. $row['badgeNum'] .'</td>';

                            if( !$row['Contacted'] ) {
                                // if the person has not yet be contacted
                                echo '<td><form method="POST">';
                                // echo '<input type="submit" value=" ' . $row['badgeNum'] .' " name="update">';
                                echo '<input type="submit" value="No" name="update">';
                                echo '<input type="hidden" name="badgeNum" value="' . $row['badgeNum'] . '">';

                                echo '</form>';
                                echo '</td>';

                            } else {
                                echo '<td><form method="POST">';
                                echo '<input type="submit" value="Yes" name="update">';
                                echo '<input type="hidden" name="badgeNum" value="' . $row['badgeNum'] . '">';
                                echo '</form>';
                                echo '</td>';
                            }



                        }
                    }

                ?>

            </thead>
        </table>
        </div>
        <form method='POST' style="margin: 0 auto;padding:20px;">
        <a class='btn btn-primary' href="./logout.php">Log Out</a>
        <input type="submit" value="DELETE ALL DATA" name='delete' class='btn btn-primary' style='display:inline-block;'
        onclick="return confirm('Are you sure you want to PERMANENTLY delete this data ?')"
        
        >
        <input type="submit" value ="Change Password" name="change_pw" class='btn btn-primary'>
        </form>
        </div>

    </div>
    <div id='authorDiv'>
        Created & Maintained by <a href="mailto:katzir@amazon.com">Yuval Katzir</a>
    </div>
    </body>
    <script charset="utf-8">var TGSort=window.TGSort||function(n){"use strict";function r(n){return n?n.length:0}function t(n,t,e,o=0){for(e=r(n);o<e;++o)t(n[o],o)}function e(n){return n.split("").reverse().join("")}function o(n){var e=n[0];return t(n,function(n){for(;!n.startsWith(e);)e=e.substring(0,r(e)-1)}),r(e)}function u(n,r,e=[]){return t(n,function(n){r(n)&&e.push(n)}),e}var a=parseFloat;function i(n,r){return function(t){var e="";return t.replace(n,function(n,t,o){return e=t.replace(r,"")+"."+(o||"").substring(1)}),a(e)}}var s=i(/^(?:\s*)([+-]?(?:\d+)(?:,\d{3})*)(\.\d*)?$/g,/,/g),c=i(/^(?:\s*)([+-]?(?:\d+)(?:\.\d{3})*)(,\d*)?$/g,/\./g);function f(n){var t=a(n);return!isNaN(t)&&r(""+t)+1>=r(n)?t:NaN}function d(n){var e=[],o=n;return t([f,s,c],function(u){var a=[],i=[];t(n,function(n,r){r=u(n),a.push(r),r||i.push(n)}),r(i)<r(o)&&(o=i,e=a)}),r(u(o,function(n){return n==o[0]}))==r(o)?e:[]}function v(n){if("TABLE"==n.nodeName){for(var a=function(r){var e,o,u=[],a=[];return function n(r,e){e(r),t(r.childNodes,function(r){n(r,e)})}(n,function(n){"TR"==(o=n.nodeName)?(e=[],u.push(e),a.push(n)):"TD"!=o&&"TH"!=o||e.push(n)}),[u,a]}(),i=a[0],s=a[1],c=r(i),f=c>1&&r(i[0])<r(i[1])?1:0,v=f+1,p=i[f],h=r(p),l=[],g=[],N=[],m=v;m<c;++m){for(var T=0;T<h;++T){r(g)<h&&g.push([]);var C=i[m][T],L=C.textContent||C.innerText||"";g[T].push(L.trim())}N.push(m-v)}t(p,function(n,t){l[t]=0;var a=n.classList;a.add("tg-sort-header"),n.addEventListener("click",function(){var n=l[t];!function(){for(var n=0;n<h;++n){var r=p[n].classList;r.remove("tg-sort-asc"),r.remove("tg-sort-desc"),l[n]=0}}(),(n=1==n?-1:+!n)&&a.add(n>0?"tg-sort-asc":"tg-sort-desc"),l[t]=n;var i,f=g[t],m=function(r,t){return n*f[r].localeCompare(f[t])||n*(r-t)},T=function(n){var t=d(n);if(!r(t)){var u=o(n),a=o(n.map(e));t=d(n.map(function(n){return n.substring(u,r(n)-a)}))}return t}(f);(r(T)||r(T=r(u(i=f.map(Date.parse),isNaN))?[]:i))&&(m=function(r,t){var e=T[r],o=T[t],u=isNaN(e),a=isNaN(o);return u&&a?0:u?-n:a?n:e>o?n:e<o?-n:n*(r-t)});var C,L=N.slice();L.sort(m);for(var E=v;E<c;++E)(C=s[E].parentNode).removeChild(s[E]);for(E=v;E<c;++E)C.appendChild(s[v+L[E-v]])})})}}n.addEventListener("DOMContentLoaded",function(){for(var t=n.getElementsByClassName("tg"),e=0;e<r(t);++e)try{v(t[e])}catch(n){}})}(document)</script>
</html>