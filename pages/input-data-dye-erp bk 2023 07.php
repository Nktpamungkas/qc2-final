<script>
function aktif(){
		if(document.forms['form1']['manual'].checked == true){
		document.form1.nokk.setAttribute("readonly",true);
		document.form1.nokk.removeAttribute("required");	
			
		}
		else{
		document.form1.nokk.removeAttribute("readonly");
		document.form1.nokk.setAttribute("required",true);	
			
		}
	}	
function rd(){
	if(document.forms['form1']['dyestuff'].value =="D" || document.forms['form1']['dyestuff'].value =="D+R"){
		document.forms['form1']['energi'].removeAttribute("disabled");
		document.forms['form1']['energi'].value="";
	}else{		
		document.forms['form1']['energi'].setAttribute("disabled",true);
		document.forms['form1']['energi'].value="";
	}						
					
}

function angka(e) {
   if (!/^[0-9 .]+$/.test(e.value)) {
      e.value = e.value.substring(0,e.value.length-1);
   }
}
		
		
		
		
        </script>
<?php
ini_set("error_reporting", 1);
session_start();
include"koneksi.php";
$nodemand=$_GET['nodemand'];
$sqlDB2="SELECT A.CODE AS DEMANDNO, TRIM(B.PRODUCTIONORDERCODE) AS PRODUCTIONORDERCODE, TRIM(E.LEGALNAME1) AS LEGALNAME1, TRIM(C.ORDERPARTNERBRANDCODE) AS ORDERPARTNERBRANDCODE, TRIM(C.BUYER) AS BUYER,
TRIM(C.SALESORDERCODE) AS SALESORDERCODE, TRIM(C.ITEMDESCRIPTION) AS ITEMDESCRIPTION, TRIM(A.SUBCODE05) AS NO_WARNA, TRIM(F.WARNA) AS WARNA,
TRIM(A.SUBCODE02) AS SUBCODE02, TRIM(A.SUBCODE03) AS SUBCODE03, TRIM(C.EXTERNALITEMCODE) AS NO_ITEM,TRIM(C.PO_NUMBER) AS PO_NUMBER, TRIM(C.INTERNALREFERENCE) AS INTERNALREFERENCE, A.BASEPRIMARYQUANTITY AS QTY_NETTO, TRIM(A.BASEPRIMARYUOMCODE) AS BASEPRIMARYUOMCODE,
A.BASESECONDARYQUANTITY AS QTY_NETTO_YARD, TRIM(A.BASESECONDARYUOMCODE) AS BASESECONDARYUOMCODE, C.QTY_ORDER, TRIM(C.QTY_ORDER_UOM) AS QTY_ORDER_UOM, C.QTY_PANJANG_ORDER,
TRIM(C.QTY_PANJANG_ORDER_UOM) AS QTY_PANJANG_ORDER_UOM, G.USEDBASEPRIMARYQUANTITY AS QTY_BAGI_KAIN, C.DELIVERYDATE,D.NAMENAME,D.VALUEDECIMAL FROM PRODUCTIONDEMAND A 
LEFT JOIN 
	(SELECT PRODUCTIONDEMANDSTEP.PRODUCTIONORDERCODE, PRODUCTIONDEMANDSTEP.PRODUCTIONDEMANDCODE FROM 
	PRODUCTIONDEMANDSTEP PRODUCTIONDEMANDSTEP
	GROUP BY PRODUCTIONDEMANDSTEP.PRODUCTIONORDERCODE,PRODUCTIONDEMANDSTEP.PRODUCTIONDEMANDCODE) B
ON A.CODE=B.PRODUCTIONDEMANDCODE
LEFT JOIN 
	(SELECT SALESORDER.ORDERPARTNERBRANDCODE, SALESORDERLINE.SALESORDERCODE, SALESORDERLINE.ORDERLINE, SALESORDERLINE.ITEMDESCRIPTION, SALESORDERLINE.SUBCODE03, SALESORDERLINE.SUBCODE05, SALESORDERLINE.BASEPRIMARYUOMCODE AS QTY_ORDER_UOM,
	CASE
        WHEN SALESORDER.EXTERNALREFERENCE IS NULL THEN SALESORDERLINE.EXTERNALREFERENCE
        ELSE SALESORDER.EXTERNALREFERENCE
    END AS PO_NUMBER,
    SALESORDERLINE.INTERNALREFERENCE, SUM(SALESORDERLINE.BASEPRIMARYQUANTITY) AS QTY_ORDER,SUM(SALESORDERLINE.BASESECONDARYQUANTITY) AS QTY_PANJANG_ORDER, 
	SALESORDERLINE.BASESECONDARYUOMCODE AS QTY_PANJANG_ORDER_UOM, SALESORDERDELIVERY.DELIVERYDATE,ITXVIEWORDERITEMLINKACTIVE.EXTERNALITEMCODE, ORDERPARTNERBRAND.LONGDESCRIPTION AS BUYER
	FROM SALESORDER SALESORDER
	LEFT JOIN SALESORDERLINE SALESORDERLINE ON SALESORDER.CODE=SALESORDERLINE.SALESORDERCODE 
	LEFT JOIN SALESORDERDELIVERY SALESORDERDELIVERY ON SALESORDERLINE.SALESORDERCODE=SALESORDERDELIVERY.SALESORDERLINESALESORDERCODE AND SALESORDERLINE.ORDERLINE=SALESORDERDELIVERY.SALESORDERLINEORDERLINE
	LEFT JOIN ITXVIEWORDERITEMLINKACTIVE ITXVIEWORDERITEMLINKACTIVE ON SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE = ITXVIEWORDERITEMLINKACTIVE.ORDPRNCUSTOMERSUPPLIERCODE AND SALESORDERLINE.ITEMTYPEAFICODE= ITXVIEWORDERITEMLINKACTIVE.ITEMTYPEAFICODE AND 
	SALESORDERLINE.SUBCODE01 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE01 AND SALESORDERLINE.SUBCODE02 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE02 AND SALESORDERLINE.SUBCODE03 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE03 AND
	SALESORDERLINE.SUBCODE04 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE04 AND SALESORDERLINE.SUBCODE05 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE05 AND SALESORDERLINE.SUBCODE06 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE06 AND 
	SALESORDERLINE.SUBCODE07 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE07 AND SALESORDERLINE.SUBCODE08 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE08 AND SALESORDERLINE.SUBCODE09 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE09 AND 
	SALESORDERLINE.SUBCODE10 = ITXVIEWORDERITEMLINKACTIVE.SUBCODE10
	LEFT JOIN ORDERPARTNERBRAND ORDERPARTNERBRAND ON SALESORDER.ORDPRNCUSTOMERSUPPLIERCODE = ORDERPARTNERBRAND.ORDPRNCUSTOMERSUPPLIERCODE AND SALESORDER.ORDERPARTNERBRANDCODE=ORDERPARTNERBRAND.CODE 
	GROUP BY SALESORDER.ORDERPARTNERBRANDCODE, SALESORDERLINE.SALESORDERCODE, SALESORDERLINE.ORDERLINE, SALESORDERLINE.ITEMDESCRIPTION, SALESORDERLINE.SUBCODE03, SALESORDERLINE.SUBCODE05, SALESORDERLINE.BASEPRIMARYUOMCODE,SALESORDERLINE.BASESECONDARYUOMCODE, 
	SALESORDER.EXTERNALREFERENCE,SALESORDERLINE.EXTERNALREFERENCE,SALESORDERLINE.INTERNALREFERENCE, SALESORDERDELIVERY.DELIVERYDATE, ITXVIEWORDERITEMLINKACTIVE.EXTERNALITEMCODE, ORDERPARTNERBRAND.LONGDESCRIPTION) C
ON A.ORIGDLVSALORDLINESALORDERCODE = C.SALESORDERCODE AND A.ORIGDLVSALORDERLINEORDERLINE = C.ORDERLINE
LEFT JOIN
	(SELECT PRODUCT.SUBCODE01, PRODUCT.SUBCODE02, PRODUCT.SUBCODE03, PRODUCT.SUBCODE04, PRODUCT.SUBCODE05,
	PRODUCT.SUBCODE06, PRODUCT.SUBCODE07, PRODUCT.SUBCODE08, PRODUCT.SUBCODE09, PRODUCT.SUBCODE10,  
	LISTAGG(TRIM(ADSTORAGE.NAMENAME),',') WITHIN GROUP(ORDER BY ADSTORAGE.NAMENAME ASC) AS NAMENAME, 
	LISTAGG(ADSTORAGE.VALUEDECIMAL,',') WITHIN GROUP(ORDER BY ADSTORAGE.NAMENAME ASC) AS VALUEDECIMAL
	FROM PRODUCT PRODUCT LEFT JOIN ADSTORAGE ADSTORAGE ON PRODUCT.ABSUNIQUEID=ADSTORAGE.UNIQUEID
	GROUP BY PRODUCT.SUBCODE01, PRODUCT.SUBCODE02, PRODUCT.SUBCODE03, PRODUCT.SUBCODE04, PRODUCT.SUBCODE05,
	PRODUCT.SUBCODE06, PRODUCT.SUBCODE07, PRODUCT.SUBCODE08, PRODUCT.SUBCODE09, PRODUCT.SUBCODE10) D
ON A.SUBCODE01=D.SUBCODE01 AND
A.SUBCODE02=D.SUBCODE02 AND
A.SUBCODE03=D.SUBCODE03 AND 
A.SUBCODE04=D.SUBCODE04 AND
A.SUBCODE05=D.SUBCODE05 AND 
A.SUBCODE06=D.SUBCODE06 AND 
A.SUBCODE07=D.SUBCODE07 AND 
A.SUBCODE08=D.SUBCODE08 AND 
A.SUBCODE09=D.SUBCODE09 AND 
A.SUBCODE10=D.SUBCODE10
LEFT JOIN
	(SELECT BUSINESSPARTNER.LEGALNAME1,ORDERPARTNER.CUSTOMERSUPPLIERCODE FROM BUSINESSPARTNER BUSINESSPARTNER 
	LEFT JOIN ORDERPARTNER ORDERPARTNER ON BUSINESSPARTNER.NUMBERID=ORDERPARTNER.ORDERBUSINESSPARTNERNUMBERID) E
ON A.CUSTOMERCODE=E.CUSTOMERSUPPLIERCODE
LEFT JOIN (
    SELECT ITXVIEWCOLOR.ITEMTYPECODE, ITXVIEWCOLOR.SUBCODE01, ITXVIEWCOLOR.SUBCODE02,
    ITXVIEWCOLOR.SUBCODE03, ITXVIEWCOLOR.SUBCODE04, ITXVIEWCOLOR.SUBCODE05, ITXVIEWCOLOR.SUBCODE06, 
    ITXVIEWCOLOR.SUBCODE07, ITXVIEWCOLOR.SUBCODE08, ITXVIEWCOLOR.SUBCODE09, ITXVIEWCOLOR.SUBCODE10, 
    ITXVIEWCOLOR.WARNA FROM ITXVIEWCOLOR ITXVIEWCOLOR) F ON
    A.ITEMTYPEAFICODE = F.ITEMTYPECODE AND 
    A.SUBCODE01 = F.SUBCODE01 AND 
    A.SUBCODE02 = F.SUBCODE02 AND 
    A.SUBCODE03 = F.SUBCODE03 AND 
    A.SUBCODE04 = F.SUBCODE04 AND 
    A.SUBCODE05 = F.SUBCODE05 AND 
    A.SUBCODE06 = F.SUBCODE06 AND 
    A.SUBCODE07 = F.SUBCODE07 AND 
    A.SUBCODE08 = F.SUBCODE08 AND 
    A.SUBCODE09 = F.SUBCODE09 AND 
    A.SUBCODE10 = F.SUBCODE10
LEFT JOIN
	(SELECT PRODUCTIONRESERVATION.ORDERCODE, PRODUCTIONRESERVATION.ITEMTYPEAFICODE, SUM(PRODUCTIONRESERVATION.USEDBASEPRIMARYQUANTITY) AS USEDBASEPRIMARYQUANTITY FROM PRODUCTIONRESERVATION 
	PRODUCTIONRESERVATION WHERE PRODUCTIONRESERVATION.ITEMTYPEAFICODE='KGF' GROUP BY PRODUCTIONRESERVATION.ORDERCODE, PRODUCTIONRESERVATION.ITEMTYPEAFICODE) G
ON A.CODE = G.ORDERCODE
WHERE A.CODE='$nodemand'";
$stmt=db2_exec($conn1,$sqlDB2, array('cursor'=>DB2_SCROLLABLE));
$rowdb2 = db2_fetch_assoc($stmt);
$ww=explode(",",$rowdb2['NAMENAME']);
$valueww=explode(",",$rowdb2['VALUEDECIMAL']);
//GRAMASI
if($ww[0]=="GSM"){ $gramasi=$valueww[0];}
else if($ww[1]=="GSM"){ $gramasi=$valueww[1];}
else if($ww[2]=="GSM"){ $gramasi=$valueww[2];}
else if($ww[3]=="GSM"){ $gramasi=$valueww[3];}
$posg=strpos($gramasi,".");
$valgramasi=substr($gramasi,0,$posg);
//WIDTH
if($ww[0]=="Width"){ $lebar=$valueww[0];}
else if($ww[1]=="Width"){ $lebar=$valueww[1];}
else if($ww[2]=="Width"){ $lebar=$valueww[2];}
else if($ww[3]=="Width"){ $lebar=$valueww[3];}
$posl=strpos($lebar,".");
$vallebar=substr($lebar,0,$posl);

$sqlroll="SELECT 
STOCKTRANSACTION.ORDERCODE,
COUNT(STOCKTRANSACTION.ITEMELEMENTCODE) AS JML_ROLL
FROM STOCKTRANSACTION STOCKTRANSACTION
WHERE STOCKTRANSACTION.ORDERCODE ='$rowdb2[PRODUCTIONORDERCODE]' AND STOCKTRANSACTION.TEMPLATECODE ='120'
AND STOCKTRANSACTION.ITEMTYPECODE ='KGF'
GROUP BY 
STOCKTRANSACTION.ORDERCODE";
$stmt1=db2_exec($conn1,$sqlroll, array('cursor'=>DB2_SCROLLABLE));
$rowr = db2_fetch_assoc($stmt1);
?>	
<?php
$Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
$TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
$Item		= isset($_POST['item']) ? $_POST['item'] : '';
$Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
$Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';

$con2=mysqli_connect("10.0.0.10","dit","4dm1n","db_dying");
//$qryDye=mysqli_query($con2,"SELECT * FROM tbl_cocok_warna_dye WHERE nokk='$nokk' ORDER BY id DESC Limit 1");
//$dtDye=mysqli_fetch_array($qryDye);
$qryDye1=mysqli_query($con2,"SELECT * FROM db_dying.tbl_hasilcelup WHERE LPAD(nokk, 8, 0)='$rowdb2[PRODUCTIONORDERCODE]' ORDER BY id DESC LIMIT 1");
$dtDyeing=mysqli_fetch_array($qryDye1);
$qryDye2=mysqli_query($con2,"SELECT sum(a.rol) as jml_roll, sum(a.bruto) as jml_kg, a.no_mesin, a.proses FROM db_dying.tbl_schedule a
LEFT JOIN db_dying.tbl_montemp b on a.id = b.id_schedule WHERE a.nokk='$dtDyeing[nokk]' and a.status ='selesai'");
$dtSch=mysqli_fetch_array($qryDye2);
?>
<form class="form-horizontal" action="pages/detail_cetak_dye_erp.php" method="post" enctype="multipart/form-data" name="form1">
 <div class="box box-info">
  	<div class="box-header with-border">
    <h3 class="box-title">Input Data Kartu Kerja</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
 	<div class="box-body"> 
	  <div class="col-md-6">
		 
	  	<div class="form-group">
                  <label for="nodemand" class="col-sm-3 control-label">No Demand</label>
                  <div class="col-sm-4">
				  <input name="nokk" type="hidden" class="form-control" id="nokk" 
                    value="<?php if($cek>0){echo $rcek['nokk'];}else{echo $rowdb2['PRODUCTIONORDERCODE'];}?>" placeholder="Nokk ERP">
				  <input name="nodemand" type="text" class="form-control" id="nodemand" 
                     onchange="window.location='InputDataDYEERP-'+this.value" value="<?php echo $_GET['nodemand'];?>" placeholder="No Demand" required >
		  </div>
		</div>
		<div class="form-group">
                  <label for="langganan" class="col-sm-3 control-label">Langganan</label>
                  <div class="col-sm-8">
                    <input name="langganan" type="text" class="form-control" id="langganan" 
                    value="<?php if($cek>0){echo $rcek['langganan'];}else{echo $rowdb2['LEGALNAME1'];}?>" placeholder="Langganan">
                  </div>				   
                </div>
		<div class="form-group">
                  <label for="buyer" class="col-sm-3 control-label">Buyer</label>
                  <div class="col-sm-8">
                    <input name="buyer" type="text" class="form-control" id="buyer" 
                    value="<?php if($cek>0){echo $rcek['buyer'];}else{echo $rowdb2['BUYER'];}?>" placeholder="Buyer">
                  </div>				   
                </div>
		<div class="form-group">
                  <label for="no_order" class="col-sm-3 control-label">No Order</label>
                  <div class="col-sm-4">
                    <input name="no_order" type="text" class="form-control" id="no_order" 
                    value="<?php if($cek>0){echo $rcek['no_order'];}else{if($rowdb2['SALESORDERCODE']!=""){echo $rowdb2['SALESORDERCODE'];}} ?>" placeholder="No Order">
                  </div>				   
                </div>
		<div class="form-group">
                  <label for="no_po" class="col-sm-3 control-label">PO</label>
                  <div class="col-sm-5">
                    <input name="no_po" type="text" class="form-control" id="no_po" 
                    value="<?php if($cek>0){echo $rcek['no_po'];}else{echo $rowdb2['PO_NUMBER'];} ?>" placeholder="PO" >
                  </div>				   
                </div>
		<div class="form-group">
                  <label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
                  <div class="col-sm-3">
                    <input name="no_hanger" type="text" class="form-control" id="no_hanger" 
                    value="<?php if($cek>0){echo $rcek['no_hanger'];}else{if($rowdb2['SUBCODE02']!=""){echo trim($rowdb2['SUBCODE02']).'-'.trim($rowdb2['SUBCODE03']);}}?>" placeholder="No Hanger">  
                  </div>
				  <div class="col-sm-3">
				  <input name="no_item" type="text" class="form-control" id="no_item" 
                    value="<?php if($rcek['no_item']!=""){echo $rcek['no_item'];}else if($rowdb2['NO_ITEM']!=""){echo $rowdb2['NO_ITEM'];}?>" placeholder="No Item">
				  </div>	
                </div>
		<div class="form-group">
                  <label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
                  <div class="col-sm-8">
					  <textarea name="jns_kain" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if($cek>0){echo $rcek['jenis_kain'];}else{if($rowdb2['ITEMDESCRIPTION']!=""){echo $rowdb2['ITEMDESCRIPTION'];} }?></textarea>
					  </div>
                  </div>
	<div class="form-group">
        <label for="tgl_delivery" class="col-sm-3 control-label">Tgl. Delivery</label>
        <div class="col-sm-4">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_delivery" type="text" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php if($cek>0){echo $rcek['tgl_delivery'];}else{if($rowdb2['DELIVERYDATE']!=""){echo date('Y-m-d', strtotime($rowdb2['DELIVERYDATE']));}}?>"/>
          </div>
        </div>
	  </div>
	  <div class="form-group">
			  <label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi</label>
			  <div class="col-sm-2">
				<input name="lebar" type="text" class="form-control" id="lebar" 
				value="<?php if($cek>0){echo $rcek['lebar'];}else{echo $vallebar;} ?>" placeholder="0" >
			  </div>
			  <div class="col-sm-2">
				<input name="grms" type="text" class="form-control" id="grms" 
				value="<?php if($cek>0){echo $rcek['gramasi'];}else{echo $valgramasi;} ?>" placeholder="0" >
			  </div>		
			</div>		

	  </div>
	  		<!-- col --> 
	  <div class="col-md-6">
		
	  	<div class="form-group">
			  <label for="warna" class="col-sm-3 control-label">Warna</label>
			  <div class="col-sm-8">
				<input name="warna" type="text" class="form-control" id="warna" 
				value="<?php if($cek>0){echo $rcek['warna'];}else{if($rowdb2['WARNA']!=""){echo $rowdb2['WARNA'];} }?>" placeholder="Warna">  
			  </div>				   
			</div>
		<div class="form-group">
			  <label for="no_warna" class="col-sm-3 control-label">No Warna</label>
			  <div class="col-sm-8">
				<input name="no_warna" type="text" class="form-control" id="no_warna" 
				value="<?php if($cek>0){echo $rcek['no_warna'];}else{if($rowdb2['NO_WARNA']!=""){echo $rowdb2['NO_WARNA'];}}?>" placeholder="No Warna">  
			  </div>				   
			</div>  
		   
			<div class="form-group">
                  <label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="qty1" type="text" class="form-control" id="qty1" 
                    value="<?php if($cek>0){echo $rcek['qty_order'];}else{echo round($rowdb2['QTY_ORDER'],2);} ?>" placeholder="0.00" >
					  <span class="input-group-addon">KGs</span></div>  
                  </div>
				  <div class="col-sm-4">
					<div class="input-group">  
                    <input name="qty2" type="text" class="form-control" id="qty2" 
                    value="<?php if($cek>0){echo $rcek['pjng_order'];}else{echo round($rowdb2['QTY_PANJANG_ORDER'],2);} ?>" placeholder="0.00" style="text-align: right;" >
                    <span class="input-group-addon">
							  <select name="satuan1" style="font-size: 12px;">
								  <option value="Yard" <?php if($rowdb2['QTY_PANJANG_ORDER_UOM']=="yd"){ echo "SELECTED"; }?>>Yard</option>
								  <option value="Meter" <?php if($rowdb2['QTY_PANJANG_ORDER_UOM']=="m"){ echo "SELECTED"; }?>>Meter</option>
								  <option value="PCS" <?php if($rowdb2['QTY_PANJANG_ORDER_UOM']=="un"){ echo "SELECTED"; }?>>PCS</option>
							  </select>
					    </span>
					</div>	
                  </div>		
                </div>
		<div class="form-group">
                  <label for="lot" class="col-sm-3 control-label">Prod. Order / Lot</label>
                  <div class="col-sm-2">
                    <input name="lot" type="text" class="form-control" id="lot" 
                    value="<?php if($cek>0){echo $rcek['lot'];}else{echo $rowdb2['PRODUCTIONORDERCODE'];}  ?>" placeholder="Prod Order / Lot" >
                  </div>				   
                </div>
		<div class="form-group">
                  <label for="loterp" class="col-sm-3 control-label">Nokk /Lot Legacy</label>
                  <div class="col-sm-3">
                    <input name="loterp" type="text" class="form-control" id="loterp" 
                    value="" placeholder="No KK Legacy" >
                  </div>
				  <div class="col-sm-2">
                    <input name="demanderp" type="text" class="form-control" id="demanderp" 
                    value="" placeholder="Lot Legacy" >
                  </div>				   
                </div>
		<div class="form-group">
			  <label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
			  <div class="col-sm-2">
				<input name="qty3" type="text" class="form-control" id="qty3" 
				value="<?php if($cek>0){echo $rcek['rol'];}else{if($dtSch['jml_roll'] != 0){echo $dtSch['jml_roll'];}} ?>" placeholder="0.00" >
			  </div>
			  <div class="col-sm-3">
				<div class="input-group">  
				<input name="qty4" type="text" class="form-control" id="qty4" 
				value="<?php if($cek>0){echo $rcek['bruto'];}else{if($dtSch['jml_kg'] != 0){echo $dtSch['jml_kg'];}} ?>" placeholder="0.00" style="text-align: right;" >
				<span class="input-group-addon">KGs</span>
				</div>	
			  </div>		
			</div>
		  <div class="form-group">
                  <label for="mc" class="col-sm-3 control-label">Mesin</label>
                  <div class="col-sm-3">
                    <input name="mc" type="text" class="form-control" id="mc" 
                    value="<?php echo $dtSch['no_mesin']; ?>" placeholder="Mesin" >
                  </div>			  
                </div>
		  <div class="form-group">
                  <label for="proses" class="col-sm-3 control-label">Proses</label>
                  <div class="col-sm-6">
                    <input name="proses" type="text" class="form-control" id="proses" 
                    value="<?php echo $dtSch['proses']; ?>" placeholder="Proses" >
                  </div>				   
          </div>		  
		  <div class="form-group">
        <label for="tgl_celup" class="col-sm-3 control-label">Tgl. Celup</label>
        <div class="col-sm-4">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_celup" type="text" class="form-control pull-right" id="datepicker3" placeholder="00-00-0000" value="<?php echo substr($dtDyeing['tgl_buat'],0,10); ?>" />
          </div>
        </div>
			  
	  </div>
		  <div class="form-group">
                  <label for="k_resep" class="col-sm-3 control-label">K.R</label>
                  <div class="col-sm-2">
                    <input name="k_resep" type="text" class="form-control" id="k_resep" 
                    value="<?php echo $dtDyeing['k_resep']; ?>" placeholder="K.Resep" readonly >
                  </div>				   
          </div>
<div class="form-group">
                  <label for="comment" class="col-sm-3 control-label">Comment</label>
                  <div class="col-sm-8">
					  <textarea name="comment" class="form-control" id="comment" placeholder="Comment.."></textarea>
					  </div>
                  </div>
	  <div class="form-group">
        <label for="cetak1" class="col-sm-3 control-label">Cetak</label>
        <div class="col-sm-4">
          <select name="cetak1" class="form-control">
			  <option value="1">1x</option>
			  <option value="2">2x</option>
			  <option value="3">3x</option>
				<option value="4">4x</option>
				<option value="5">5x</option>
		  </select>
        </div>
	  </div> 
      </div>
	  		
	 
		  <input type="hidden" value="<?php if($cek>0){echo $rcek['no_ko'];}else{echo $rKO['KONo'];}?>" name="no_ko">
		  
 	</div>
   <div class="box-footer">
   <?php if($_GET['nodemand']!=""){?>
   <button type="submit" class="btn btn-danger pull-right" name="cetak" value="cetak"><i class="fa fa-print"></i> Cetak</button>
   <?php } ?>
   </div>
    <!-- /.box-footer -->
 </div>
</form>
