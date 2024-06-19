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
$nokk=$_GET['nokk'];
$sql=mssql_query("select top 1
			x.*,dbo.fn_StockMovementDetails_GetTotalWeightPCC(0, x.PCBID) as Weight, 
			pm.Weight as Gramasi,pm.CuttableWidth as Lebar, pm.Description as ProductDesc, pm.ColorNo, pm.Color,
      dbo.fn_StockMovementDetails_GetTotalRollPCC(0, x.PCBID) as RollCount
		from
			(
			select
				so.SONumber, convert(char(10),so.SODate,103) as TglSO, so.CustomerID, so.BuyerID, so.PODate,
				sod.ID as SODID, sod.ProductID, sod.Quantity, sod.UnitID, sod.WeightUnitID, 
				soda.RefNo as DetailRefNo,jo.DocumentNo as NoOrder,soda.PONumber,
				pcb.ID as PCBID, pcb.Gross as Bruto,soda.HangerNo,pp.ProductCode,
				pcb.Quantity as BatchQuantity, pcb.UnitID as BatchUnitID, pcb.ScheduledDate, pcb.ProductionScheduledDate,
				pcblp.DepartmentID,pcb.LotNo,pcb.PCID,pcb.ChildLevel,pcb.RootID,sod.RequiredDate
				
			from
				SalesOrders so inner join
				JobOrders jo on jo.SOID=so.ID inner join
				SODetails sod on so.ID = sod.SOID inner join
				SODetailsAdditional soda on sod.ID = soda.SODID left join
				ProductPartner pp on pp.productid= sod.productid left join
				ProcessControlJO pcjo on sod.ID = pcjo.SODID left join
				ProcessControlBatches pcb on pcjo.PCID = pcb.PCID left join
				ProcessControlBatchesLastPosition pcblp on pcb.ID = pcblp.PCBID left join
				ProcessFlowProcessNo pfpn on pfpn.EntryType = 2 and pcb.ID = pfpn.ParentID and pfpn.MachineType = 24 left join
				ProcessFlowDetailsNote pfdn on pfpn.EntryType = pfdn.EntryType and pfpn.ID = pfdn.ParentID
			where pcb.DocumentNo='$nokk' and pcb.Gross<>'0'
				group by
					so.SONumber, so.SODate, so.CustomerID, so.BuyerID, so.PONumber, so.PODate,jo.DocumentNo,
					sod.ID, sod.ProductID, sod.Quantity, sod.UnitID, sod.Weight, sod.WeightUnitID,
					soda.RefNo,pcb.DocumentNo,soda.HangerNo,
					pcb.ID, pcb.DocumentNo, pcb.Gross,soda.PONumber,pp.ProductCode,
					pcb.Quantity, pcb.UnitID, pcb.ScheduledDate, pcb.ProductionScheduledDate,
					pcblp.DepartmentID,pcb.LotNo,pcb.PCID,pcb.ChildLevel,pcb.RootID,sod.RequiredDate
				) x inner join
				ProductMaster pm on x.ProductID = pm.ID left join
				Departments dep on x.DepartmentID  = dep.ID left join
				Departments pdep on dep.RootID = pdep.ID left join				
				Partners cust on x.CustomerID = cust.ID left join
				Partners buy on x.BuyerID = buy.ID left join
				UnitDescription udq on x.UnitID = udq.ID left join
				UnitDescription udw on x.WeightUnitID = udw.ID left join
				UnitDescription udb on x.BatchUnitID = udb.ID
			order by
				x.SODID, x.PCBID");
		  $r=mssql_fetch_array($sql);
$sql1=mssql_query("select partnername from partners where id='$r[CustomerID]'");	
$r1=mssql_fetch_array($sql1);
$sql2=mssql_query("select partnername from partners where id='$r[BuyerID]'");	
$r2=mssql_fetch_array($sql2);
$pelanggan=$r1['partnername'];
$buyer=$r2['partnername'];
$ko=mssql_query("select  ko.KONo from
		ProcessControlJO pcjo inner join
		ProcessControl pc on pcjo.PCID = pc.ID left join
		KnittingOrders ko on pc.CID = ko.CID and pcjo.KONo = ko.KONo 
	where
		pcjo.PCID = '$r[PCID]'
group by ko.KONo",$conn);
					$rKO=mssql_fetch_array($ko);
					
$child=$r['ChildLevel'];
	if($nokk!=""){	
		if($child > 0){
			$sqlgetparent=mssql_query("select ID,LotNo from ProcessControlBatches where ID='$r[RootID]' and ChildLevel='0'");
			$rowgp=mssql_fetch_assoc($sqlgetparent);
			
			//$nomLot=substr("$row2[LotNo]",0,1);
			$nomLot=$rowgp['LotNo'];
			$nomorLot="$nomLot/K$r[ChildLevel]";				
								
		}else{
			$nomorLot=$r['LotNo'];
				
		}

		$sqlLot1="Select count(*) as TotalLot From ProcessControlBatches where PCID='$r[PCID]' and RootID='0' and LotNo < '1000'";
		$qryLot1 = mssql_query($sqlLot1) or die('A error occured : ');							
		$rowLot=mssql_fetch_assoc($qryLot1);
		$lotno=$rowLot['TotalLot']."-".$nomorLot;
		

}

?>	
<?php
$Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
$TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
$Item		= isset($_POST['item']) ? $_POST['item'] : '';
$Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
$Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';
$con1=mysql_connect("svr10","dit","4dm1n");
$db1=mysql_select_db("db_finishing",$con1)or die("Gagal Koneksi ke finishing");
$qryFin=mysql_query("SELECT *,DATE_FORMAT(tgl_proses_out,'%d-%m-%Y') as tgl_o FROM tbl_produksi WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
$dtFin=mysql_fetch_array($qryFin);

?>
<form class="form-horizontal" action="pages/cetak_label_new.php" method="post" enctype="multipart/form-data" name="form1">
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
                  <label for="nokk" class="col-sm-3 control-label">No KK</label>
                  <div class="col-sm-4">
				  <input name="nokk" type="text" class="form-control" id="nokk" 
                     onchange="window.location='InputData3-'+this.value" value="<?php echo $_GET[nokk];?>" placeholder="No KK" required >
		  </div>
		</div>
		<div class="form-group">
                  <label for="langganan" class="col-sm-3 control-label">Langganan</label>
                  <div class="col-sm-8">
                    <input name="langganan" type="text" class="form-control" id="langganan" 
                    value="<?php if($cek>0){echo $rcek[langganan];}else{echo $pelanggan;}?>" placeholder="Langganan">
                  </div>				   
                </div>
		<div class="form-group">
                  <label for="buyer" class="col-sm-3 control-label">Buyer</label>
                  <div class="col-sm-8">
                    <input name="buyer" type="text" class="form-control" id="buyer" 
                    value="<?php if($cek>0){echo $rcek[buyer];}else{echo $buyer;}?>" placeholder="Buyer">
                  </div>				   
                </div>
	    <div class="form-group">
                  <label for="no_order" class="col-sm-3 control-label">No Order</label>
                  <div class="col-sm-4">
                    <input name="no_order" type="text" class="form-control" id="no_order" 
                    value="<?php if($cek>0){echo $rcek[no_order];}else{if($r[NoOrder]!=""){echo $r[NoOrder];}else if($nokk!=""){echo $cekM[no_order];}} ?>" placeholder="No Order">
                  </div>				   
                </div>
	    <div class="form-group">
                  <label for="no_po" class="col-sm-3 control-label">PO</label>
                  <div class="col-sm-5">
                    <input name="no_po" type="text" class="form-control" id="no_po" 
                    value="<?php if($cek>0){echo $rcek[no_po];}else{if($r[PONumber]!=""){echo $r[PONumber];}else if($nokk!=""){echo $cekM[no_po];}} ?>" placeholder="PO" >
                  </div>				   
                </div>
		<div class="form-group">
                  <label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
                  <div class="col-sm-3">
                    <input name="no_hanger" type="text" class="form-control" id="no_hanger" 
                    value="<?php if($cek>0){echo $rcek[no_hanger];}else{if($r[HangerNo]){echo $r[HangerNo];}else if($nokk!=""){echo $cekM[no_item];}}?>" placeholder="No Hanger">  
                  </div>
				  <div class="col-sm-3">
				  <input name="no_item" type="text" class="form-control" id="no_item" 
                    value="<?php if($rcek[no_item]!=""){echo $rcek[no_item];}else if($r[ProductCode]!=""){echo $r[ProductCode];}else{if($r[HangerNo]){echo $r[HangerNo];}else if($nokk!=""){echo $cekM[no_item];}}?>" placeholder="No Item">
				  </div>	
                </div>
	    <div class="form-group">
                  <label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
                  <div class="col-sm-8">
					  <textarea name="jns_kain" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if($cek>0){echo $rcek[jenis_kain];}else{if($r[ProductDesc]!=""){echo $r[ProductDesc];}else if($nokk!=""){ echo $cekM[jenis_kain]; } }?></textarea>
					  </div>
                  </div>
	  <div class="form-group">
        <label for="tgl_delivery" class="col-sm-3 control-label">Tgl. Delivery</label>
        <div class="col-sm-4">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_delivery" type="text" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php if($cek>0){echo $rcek[tgl_delivery];}else{if($r[RequiredDate]!=""){echo date('Y-m-d', strtotime($r[RequiredDate]));}}?>"/>
          </div>
        </div>
	  </div>
	<div class="form-group">
			  <label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi</label>
			  <div class="col-sm-2">
				<input name="lebar" type="text" class="form-control" id="lebar" 
				value="<?php if($cek>0){echo $rcek[lebar];}else{echo round($r[Lebar]);} ?>" placeholder="0" >
			  </div>
			  <div class="col-sm-2">
				<input name="grms" type="text" class="form-control" id="grms" 
				value="<?php if($cek>0){echo $rcek[gramasi];}else{echo round($r[Gramasi]);} ?>" placeholder="0" >
			  </div>		
			</div>		

	  </div>
	  		<!-- col --> 
	  <div class="col-md-6">
		
		<div class="form-group">
			  <label for="warna" class="col-sm-3 control-label">Warna</label>
			  <div class="col-sm-8">
				<input name="warna" type="text" class="form-control" id="warna" 
				value="<?php if($cek>0){echo $rcek[warna];}else{if($r[Color]!=""){echo $r[Color];}else if($nokk!=""){ echo $cekM[warna];} }?>" placeholder="Warna">  
			  </div>				   
			</div>
		<div class="form-group">
			  <label for="no_warna" class="col-sm-3 control-label">No Warna</label>
			  <div class="col-sm-8">
				<input name="no_warna" type="text" class="form-control" id="no_warna" 
				value="<?php if($cek>0){echo $rcek[no_warna];}else{if($r[ColorNo]!=""){echo $r[ColorNo];}else if($nokk!=""){echo $cekM[no_warna];}}?>" placeholder="No Warna">  
			  </div>				   
			</div> 
		   
		<div class="form-group">
                  <label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
                  <div class="col-sm-3">
					<div class="input-group">  
                    <input name="qty1" type="text" class="form-control" id="qty1" 
                    value="<?php if($cek>0){echo $rcek[qty_order];}else{echo round($r[BatchQuantity],2);} ?>" placeholder="0.00" >
					  <span class="input-group-addon">KGs</span></div>  
                  </div>
				  <div class="col-sm-4">
					<div class="input-group">  
                    <input name="qty2" type="text" class="form-control" id="qty2" 
                    value="<?php if($cek>0){echo $rcek[pjng_order];}else{echo round($r[Quantity],2);} ?>" placeholder="0.00" style="text-align: right;" >
                    <span class="input-group-addon">
							  <select name="satuan1" style="font-size: 12px;">
								  <option value="Yard" <?php if($r[UnitID]=="21"){ echo "SELECTED"; }?>>Yard</option>
								  <option value="Meter" <?php if($r[UnitID]=="10"){ echo "SELECTED"; }?>>Meter</option>
								  <option value="PCS" <?php if($r[UnitID]=="1"){ echo "SELECTED"; }?>>PCS</option>
							  </select>
					    </span>
					</div>	
                  </div>		
                </div>
		<div class="form-group">
                  <label for="lot" class="col-sm-3 control-label">Lot</label>
                  <div class="col-sm-2">
                    <input name="lot" type="text" class="form-control" id="lot" 
                    value="<?php if($cek>0){echo $rcek[lot];}else{if($nomorLot!=""){echo $lotno;}else if($nokk!=""){echo $cekM[lot];} } ?>" placeholder="Lot" >
                  </div>				   
                </div>
		<div class="form-group">
                  <label for="loterp" class="col-sm-3 control-label">Lot ERP/Demand ERP</label>
                  <div class="col-sm-2">
                    <input name="loterp" type="text" class="form-control" id="loterp" 
                    value="" placeholder="Lot ERP" >
                  </div>
				  <div class="col-sm-2">
                    <input name="demanderp" type="text" class="form-control" id="demanderp" 
                    value="" placeholder="Demand ERP" >
                  </div>				   
                </div>
		<div class="form-group">
			  <label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
			  <div class="col-sm-2">
				<input name="qty3" type="text" class="form-control" id="qty3" 
				value="<?php if($cek>0){echo $rcek[rol];}else{if($r[RollCount]!=""){echo round($r[RollCount]);}else if($nokk!=""){echo $cekM[jml_roll];}} ?>" placeholder="0.00" >
			  </div>
			  <div class="col-sm-3">
				<div class="input-group">  
				<input name="qty4" type="text" class="form-control" id="qty4" 
				value="<?php if($cek>0){echo $rcek[bruto];}else{if($r[Weight]!=""){echo round($r[Weight],2);}else if($nokk!=""){echo $cekM[bruto];}} ?>" placeholder="0.00" style="text-align: right;" >
				<span class="input-group-addon">KGs</span>
				</div>	
			  </div>		
			</div>
		  <div class="form-group">
                  <label for="mc" class="col-sm-3 control-label">Mesin</label>
                  <div class="col-sm-3">
                    <input name="mc" type="text" class="form-control" id="mc" 
                    value="<?php echo $dtFin[no_mesin]; ?>" placeholder="Mesin" >
                  </div>
			  <div class="col-sm-3">
				<div class="input-group">  
				<input name="speed" type="text" class="form-control" id="speed" 
				value="<?php echo $dtFin[speed]; ?>" placeholder="0.00" style="text-align: right;">
				<span class="input-group-addon">speed</span>
				</div>	
			  </div>
			  <div class="col-sm-3">
				<div class="input-group">  
				<input name="suhu" type="text" class="form-control" id="suhu" 
				value="<?php echo $dtFin[suhu]; ?>" placeholder="0.00" style="text-align: right;" >
				<span class="input-group-addon">&deg;</span>
				</div>	
			  </div>	
                </div>
		  <div class="form-group">
                  <label for="proses" class="col-sm-3 control-label">Proses</label>
                  <div class="col-sm-6">
                    <input name="proses" type="text" class="form-control" id="proses" 
                    value="<?php echo $dtFin[proses]; ?>" placeholder="Proses" >
                  </div>				   
          </div>
		  <div class="form-group">
        <label for="tgl_finishing" class="col-sm-3 control-label">Tgl. Finishing</label>
        <div class="col-sm-4">
          <div class="input-group date">
            <div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
            <input name="tgl_finishing" type="text" class="form-control pull-right" id="datepicker3" placeholder="00-00-0000" value="<?php echo $dtFin[tgl_o]; ?>" />
          </div>
        </div>
	  </div>
<div class="form-group">
                  <label for="comment" class="col-sm-3 control-label">Comment</label>
                  <div class="col-sm-8">
					  <textarea name="comment" class="form-control" id="comment" placeholder="Comment.."></textarea>
					  </div>
                  </div>
	  
      </div>
	  		
	 
		  <input type="hidden" value="<?php if($cek>0){echo $rcek[no_ko];}else{echo $rKO[KONo];}?>" name="no_ko">
		  
 	</div>
   <div class="box-footer">
   <?php if($_GET[nokk]!=""){?>
   <button type="submit" class="btn btn-danger pull-right" name="cetak" value="cetak"><i class="fa fa-print"></i> Cetak</button>
   <?php } ?>
   </div>
    <!-- /.box-footer -->
 </div>
</form>
