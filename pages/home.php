<?php
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
?>



<?php
//set base constant 
if( !isset($_SESSION['usrid1']) || !isset($_SESSION['pasid1']) ) {
 ?>
 <script>setTimeout("location.href='login.php'",500);</script> 
 <?php
 die( 'Illegal Acces' ); 
}

//request page
$page	= isset($_GET['p'])?$_GET['p']:'';
//$act	= isset($_GET['act'])?$_GET['act']:'';
$id		= isset($_GET['id'])?$_GET['id']:'';
$page	= strtolower($page);
?>
<!DOCTYPE html>
<html dir="ltr" lang="en-US"><head>
    <meta charset="utf-8">
	<meta http-equiv="refresh" content="180">
    <title>Home</title>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
	<script src="plugins/highcharts/code/highcharts.js"></script>
    <script src="plugins/highcharts/code/highcharts-3d.js"></script>
	<script src="plugins/highcharts/code/modules/exporting.js"></script>
    <script src="plugins/highcharts/code/modules/export-data.js"></script>
	</head>
<body>
      <div class="callout callout-info">
        <h4>Welcome <?php echo strtoupper($_SESSION['usrid1']);?> at Indo Taichen Textile Industry</h4>
        This is a web-based Indo Taichen system
        </div>      
</body>
</html>
	<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'column',
		
        options3d: {
            enabled: true,
            alpha: 10,
            beta: 20,
            depth: 70
        }
    },
    title: {
        text: 'Dept Penyebab'
    },
    subtitle: {
        text: '<?php echo $r['bln'];?>'
    },
    plotOptions: {
        column: {
            depth: 15,
			color: 'coral',
        }
    },
    xAxis: {
		categories: [<?php echo $r['dept'];?>],
        labels: {
            skew3d: true,
			style: {
                fontSize: '12px',
            }
        }
    },
    yAxis: {
        title: {
            text: 'Persentase'
        }
    },
    series: [{
        name: 'Masalah',
        data: [<?php echo $r['jml'];?>],
		dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
    }]
});
Highcharts.chart('container1', {
    chart: {
        type: 'column',
        options3d: {
            enabled: true,
            alpha: 0,
            beta: 0,
            depth: 70
        }
    },
    title: {
        text: 'Defect'
    },
    subtitle: {
        text: '<?php echo $r['bln'];?>'
    },
    plotOptions: {
        column: {
            depth: 15
        }
    },
    xAxis: {
		categories: [<?php echo $r1['defect'];?>],
        labels: {
            skew3d: true,
            style: {
                fontSize: '10px',
            }
        }
    },
    yAxis: {
        title: {
            text: 'Persentase'
        }
    },
    series: [{
        name: 'Defect',
        data: [<?php echo $r1['jml']; ?>],
		dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
    }]
});		
		</script>
	