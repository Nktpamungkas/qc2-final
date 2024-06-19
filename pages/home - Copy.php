<?php
session_start();
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
$act	= isset($_GET['act'])?$_GET['act']:'';
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
<?php $qry=mysql_query("SELECT GROUP_CONCAT('''',a.nama,'''') dept,GROUP_CONCAT(IFNULL(b.jml,0)) as jml, DATE_FORMAT(now(),'%M %Y') as bln FROM tbl_dept a
LEFT JOIN(
SELECT ROUND((COUNT(b.masalah)/(SELECT COUNT(*) FROM  tbl_qcf a
INNER JOIN tbl_email_bon c ON a.bpp=c.no_bon
LEFT JOIN tbl_qcf_detail b ON a.id=b.id_qcf WHERE DATE_FORMAT(tgl_kirim,'%m')=DATE_FORMAT(now(),'%m') AND not ISNULL(b.dept)))*100, 1) as jml, b.dept FROM tbl_qcf a
INNER JOIN tbl_email_bon c ON a.bpp=c.no_bon
LEFT JOIN tbl_qcf_detail b ON a.id=b.id_qcf WHERE DATE_FORMAT(tgl_kirim,'%m')=DATE_FORMAT(now(),'%m') AND not ISNULL(b.dept) GROUP BY dept) b ON a.nama=b.dept");
	$r=mysql_fetch_array($qry);
	$qry1=mysql_query("SELECT GROUP_CONCAT('''',a.nama,'''') defect ,GROUP_CONCAT(IFNULL(b.jml,0)) as jml, DATE_FORMAT(now(),'%M %Y') as bln FROM tbl_masalah a
INNER JOIN(SELECT ROUND((COUNT(b.masalah)/(SELECT COUNT(*) FROM  tbl_qcf a
INNER JOIN tbl_email_bon c ON a.bpp=c.no_bon
LEFT JOIN tbl_qcf_detail b ON a.id=b.id_qcf WHERE DATE_FORMAT(tgl_kirim,'%m')=DATE_FORMAT(now(),'%m') AND not ISNULL(b.dept)))*100, 1) as jml,b.masalah FROM tbl_qcf a
INNER JOIN tbl_email_bon c ON a.bpp=c.no_bon
LEFT JOIN tbl_qcf_detail b ON a.id=b.id_qcf WHERE DATE_FORMAT(tgl_kirim,'%m')=DATE_FORMAT(now(),'%m'
) AND not ISNULL(b.dept) GROUP BY b.masalah) b ON a.nama=b.masalah");
	$r1=mysql_fetch_array($qry1);?>	
	<div class="col-md-5">
        <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Column Chart Dept. Penyebab </h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div id="container" style="height: 450px"></div>
            </div>
            <!-- /.box-body -->
          </div>
          </div>
          <div class="col-md-7">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Column Chart Defect</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div id="container1" style="height: 450px"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>
          <!-- /.box -->
       
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
        text: '<?php echo $r[bln];?>'
    },
    plotOptions: {
        column: {
            depth: 15,
			color: 'coral',
        }
    },
    xAxis: {
		categories: [<?php echo $r[dept];?>],
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
        data: [<?php echo $r[jml];?>],
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
        text: '<?php echo $r[bln];?>'
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
        data: [<?php echo $r1[jml]; ?>],
		dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
    }]
});		
		</script>
	