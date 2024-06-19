<?php
include("../koneksi.php");
$ip = $_SERVER['REMOTE_ADDR'];
$tmpdir = sys_get_temp_dir();
$file = tempnam($tmpdir, 'ctk');
$handle = fopen($file, 'w');
$condensed = Chr(27) . Chr(33) . Chr(4);
$roman1=Chr(27).Chr(120).Chr(48);
$roman0=Chr(27).Chr(120).Chr(49);
$sans = chr(27).chr(107).chr(49);
$bold1 = Chr(27).Chr(69); 
$bold0 = Chr(27).Chr(70);
$tebal=Chr(14);
$ukuran=Chr(27).Chr(50);
$ukuran1=Chr(27).Chr(51).Chr(52);
$initialized = Chr(27).Chr(64); 
$condensed1 = Chr(15);
$condensed0 = Chr(18);
$Data = $initialized;
$Data .= $condensed1;
$Data .=$bold1;
$Data .=$ukuran1;
$Data .="--------------------------\n";
$Data .="Customer :";
$Data .="PO       :";
$Data .="Order    :";
$Data .="Item     :";
$Data .="Qtt      :";
$Data .="Mc       :";
$Data .="Lot      :";
$Data .="Coment   :";	  
$Data .=$ukuran;
$Data .="--------------------------\n";
$Data .="\n";
$Data .="\n";
$Data .="\n";
//echo $Data;
fwrite($handle, $Data);
fclose($handle);
//copy($file, "//".$ip."/EPSON LQ-2190 ESCP2");
copy($file, "//QCF04-PC/EPSON LQ-2190 ESCP2");
unlink($file);
	
	?>
<script> 
window.location.href='../InputData-<?php echo $_POST['nokk'];?>';
</script>    
