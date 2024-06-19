<?php
include("../koneksi.php");
$ip = $_SERVER['REMOTE_ADDR'];
$tmpdir = sys_get_temp_dir();
$file = tempnam($tmpdir, 'ctk');
$handle = fopen($file, 'w');
//$condensed = Chr(27) . Chr(33) . Chr(4);
//$roman1=Chr(27).Chr(120).Chr(48);
//$roman0=Chr(27).Chr(120).Chr(49);
//$sans = chr(27).chr(107).chr(49);
//$bold1 = Chr(27).Chr(69); 
//$bold0 = Chr(27).Chr(70);
//$tebal=Chr(14);
//$ukuran=Chr(27).Chr(50);
//$ukuran1=Chr(27).Chr(51).Chr(52);
$initialized = Chr(27).Chr(64); 
$condensed1 = Chr(15);
//$condensed0 = Chr(18);
$Data = $initialized;
$Data .= $condensed1;
$Data .=$bold1;
//$Data .=$ukuran1;
for($x=1;$x<=$_POST['cetak1'];$x++){
$Data .=$_POST['langganan']."\n";
$Data .=$_POST['buyer']."\n";
$Data .=$_POST['no_po']."\n";
$Data .=$_POST['no_order']."\n";
$Data .=$_POST['no_hanger']." /".$_POST['no_item']."\n";
$Data .=substr($_POST['no_warna'],0,15)." /".substr($_POST['warna'],0,15)."\n";
$Data .=$_POST['qty3']."x".$_POST['qty4']." /".trim($_POST['lot'])." ".$_POST['lebar']."x".$_POST['grms']."\n";
$Data .=$_POST['mc']." /".$_POST['suhu']." /".$_POST['speed']."\n";
$Data .="ERP:".$_POST['loterp']."\n";
$Data .="Dmnd:".$_POST['demanderp']."\n";
$Data .=$_POST['tgl_finishing']."  ".$_POST['proses']."\n";
$Data .="Comment   : ".$_POST['comment']."\n\n";	  
//$Data .=$ukuran;
$Data .="\n";
$Data .="\n";
//$Data .="\n";
//$Data .="\n";
}

//echo $Data;
fwrite($handle, $Data);
fclose($handle);
//copy($file, "//".$ip."/EPSON LQ-2190 ESCP2");
copy($file, "//W-QCF-000002/EPSON LX-310");
unlink($file);
	
	?>
<script> 
window.location.href='../InputData-<?php echo $_POST['nokk'];?>';
</script>    
