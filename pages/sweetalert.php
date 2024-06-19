<!DOCTYPE html>
<html>
<head>
<title>Sweet Alert</title>
<link rel="stylesheet" type="text/css" href="bower_components/sweetalert/sweetalert2.css">
<script type="text/javascript" src="bower_components/sweetalert/sweetalert2.min.js"></script>	
</head>
<body>
<script>
	swal({
  title: 'Data Telah DiUbah',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    /*swal(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )*/
	 window.location.href='?p=Input-Data'; 
  }
})
	
	</script>	
<button onclick="classic()">Normal Alert</button>
<button onclick="sweet()">Sweet Alert</button>
<script>
function classic () {
alert("Normal Alert!");
}
function sweet (){
swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this imaginary file!",   
            type: "success",   
            
        }, function(){   
            /*swal("Deleted!", "Your imaginary file has been deleted.", "success");*/
			window.location.href='?p=Input-Data';
        });
}
</script>
</body>
</html>
