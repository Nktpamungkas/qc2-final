<?php
ini_set("error_reporting", 1);
session_start();
include "../../koneksi.php";
//--
//$con=mysqli_connect("localhost","root","");
//$db=mysqli_select_db("db_qc",$con)or die("Gagal Koneksi");
//$idkk=$_GET['idkk'];
$idkk=$_REQUEST['idkk'];
$act=$_GET['g'];
$data=mysqli_query($con,"SELECT * FROM tbl_tq_nokk WHERE nokk='$idkk' ORDER BY id DESC LIMIT 1");
$r=mysqli_fetch_array($data);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles_cetak.css" rel="stylesheet" type="text/css">
<title>Cetak Label</title>
<style>
	td{
	border-top:0px #000000 solid; 
	border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; 
	border-right:0px #000000 solid;
	}
	</style>
</head>


<body>
<table width="100%" border="0"style="width: 7in;">
  <tbody>    
    <tr>
      <td align="left" valign="top" style="height: 1.6in;"><table width="100%" border="0" class="table-list1" style="width: 2.3in;">
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[nokk];?> / ERP : <?php echo $_POST[loterp];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[langganan];?> / <?php echo $_POST[buyer];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[no_po];?> || <?php echo $_POST[no_order];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[no_hanger]."/".$_POST[no_item];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo substr($_POST[warna],0,15)."/".substr($_POST[warna],0,15);?></td>
        </tr>
        <tr>
          <td valign="top" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[qty3]."x".$_POST[qty4]." /".trim($_POST[lot])." ".$_POST[lebar]."x".$_POST[grms]."\n";?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[mc]." /".$_POST[suhu]." /".$_POST[proses];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"> Dmnd: <?php echo $_POST[demanderp]." /".$_POST[tgl_celup];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Comment: <?php echo $_POST[comment];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
        <!--<tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size:9px;"><?php echo "Test-".$r['no_test'];?></span></td>
          </tr>-->
      </table></td>
      <td align="left" valign="top" style="height: 1.6in;"><table width="100%" border="0" class="table-list1" style="width: 2.3in;">
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[nokk];?> / ERP : <?php echo $_POST[loterp];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[langganan];?> / <?php echo $_POST[buyer];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[no_po];?> || <?php echo $_POST[no_order];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[no_hanger]."/".$_POST[no_item];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo substr($_POST[warna],0,15)."/".substr($_POST[warna],0,15);?></td>
        </tr>
        <tr>
          <td valign="top" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[qty3]."x".$_POST[qty4]." /".trim($_POST[lot])." ".$_POST[lebar]."x".$_POST[grms]."\n";?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[mc]." /".$_POST[suhu]." /".$_POST[proses];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"> Dmnd: <?php echo $_POST[demanderp]." /".$_POST[tgl_celup];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Comment: <?php echo $_POST[comment];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
        <?php 
        if(strpos($r['pelanggan'],'UNDER A') !== false){
        ?>
        <?php } ?>
        <!--<tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size:9px;"><?php echo "Test-".$r['no_test'];?></span></td>
          </tr>-->
      </table></td>
      <td align="left" valign="top" style="height: 1.6in;"><table width="100%" border="0" class="table-list1" style="width: 2.3in;">
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[nokk];?> / ERP : <?php echo $_POST[loterp];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[langganan];?> / <?php echo $_POST[buyer];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[no_po];?> || <?php echo $_POST[no_order];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[no_hanger]."/".$_POST[no_item];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo substr($_POST[warna],0,15)."/".substr($_POST[warna],0,15);?></td>
        </tr>
        <tr>
          <td valign="top" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[qty3]."x".$_POST[qty4]." /".trim($_POST[lot])." ".$_POST[lebar]."x".$_POST[grms]."\n";?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><?php echo $_POST[mc]." /".$_POST[suhu]." /".$_POST[proses];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"> Dmnd: <?php echo $_POST[demanderp]." /".$_POST[tgl_celup];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">Comment: <?php echo $_POST[comment];?></td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
        <tr>
          <td style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;">&nbsp;</td>
        </tr>
        <?php 
        if(strpos($r['pelanggan'],'UNDER A') !== false){
        ?>
        <?php } ?>
        <!--<tr>
          <td colspan="3" style="border-top:0px #000000 solid; border-bottom:0px #000000 solid;
	border-left:0px #000000 solid; border-right:0px #000000 solid;"><span style="font-size:9px;"><?php echo "Test-".$r['no_test'];?></span></td>
          </tr>-->
      </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>