<!DOCTYPE html>
<html>
<head>
<title>Sweet Alert</title>
<link rel="stylesheet" type="text/css" href="bower_components/sweetalert/sweetalert.css">
<script type="text/javascript" src="bower_components/sweetalert/sweetalert.min.js"></script>
</head>
<body>
<script>swal("Good job!", "You clicked the button!", "success");</script>	
<button onclick="classic()">Normal Alert</button>
<button onclick="sweet()">Sweet Alert</button>
<script>
function classic () {
alert("Normal Alert!");
}
function sweet (){
swal("Good job!", "You clicked the button!", "success");
}
</script>
</body>
</html>