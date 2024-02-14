<?php 
date_default_timezone_set("Asia/Colombo");
$date = date("Y/m/d").' - '.date("h:i:s");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<a onclick="openNewTab()">app2</a>

<a onclick="refreshExistingTab()">Refresh</a>
</body>
</html>
<script>

    var childWindow = "";
    var newTabUrl="https://stackoverflow.com/questions/27061451/how-to-refresh-another-page-using-javascript-without-opening-the-same-page-in-a";

    function openNewTab(){
        childWindow = window.open(newTabUrl);
    }

    function refreshExistingTab(){
        childWindow.location.href=newTabUrl;
    }

</script>