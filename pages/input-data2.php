<script>
function roundToTwo(num) {    
    return +(Math.round(num + "e+2")  + "e-2");
}	
function jumlah(){
	var netto = document.forms['form1']['berat'].value;
	var lebar = document.forms['form1']['lebar'].value;
	var grms  = document.forms['form1']['grms'].value;
	var satuan= document.forms['form1']['satuan'].value;
	var plus3 = document.forms['form1']['plus3'].value;
	var x,x1,yard,meter;
	
	if(document.forms['form1']['plus3'].checked == true){
	   x=((parseInt(lebar)+3)*parseInt(grms))/43.05;
	   }else{
	   x=((parseInt(lebar)+2)*parseInt(grms))/43.05;   
	   }
	if(netto==null || netto==""){
		document.form1.panjang.value='0';}
	else{
		x1=roundToTwo(1000/x);
		yard=x1*parseFloat(netto);
		meter=yard*(768/840);
		if(satuan=="Yard"){
		document.form1.panjang.value=roundToTwo(yard).toFixed(2);}
		else if(satuan=="Meter"){
		document.form1.panjang.value=roundToTwo(meter).toFixed(2);} 
		}
	}
	function aktif(){
		if(document.forms['form1']['manual'].checked == true){
		document.form1.panjang.removeAttribute("readonly");}
		else{
		document.form1.panjang.setAttribute("readonly",true);}
	}
</script>
<?php
$nokk=$_GET[nokk];
$sql=mssql_query("select top 1
			x.*,dbo.fn_StockMovementDetails_GetTotalWeightPCC(0, x.PCBID) as Weight, 
			pm.Weight as Gramasi,pm.CuttableWidth as Lebar, pm.Description as ProductDesc, pm.ColorNo, pm.Color,
      dbo.fn_StockMovementDetails_GetTotalRollPCC(0, x.PCBID) as RollCount
		from
			(
			select
				so.SONumber, convert(char(10),so.SODate,103) as TglSO, so.CustomerID, so.BuyerID, so.PODate,
				sod.ID as SODID, sod.ProductID, sod.Quantity, sod.UnitID, sod.WeightUnitID, 
				soda.RefNo as DetailRefNo, jo.DocumentNo as NoOrder,soda.PONumber,
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
					soda.RefNo,pcb.DocumentNo,soda.HangerNo,pp.ProductCode,
					pcb.ID, pcb.DocumentNo, pcb.Gross,soda.PONumber,
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
$pelanggan=$r1[partnername]."/".$r2[partnername];
$ko=mssql_query("select  ko.KONo from
		ProcessControlJO pcjo inner join
		ProcessControl pc on pcjo.PCID = pc.ID left join
		KnittingOrders ko on pc.CID = ko.CID and pcjo.KONo = ko.KONo 
	where
		pcjo.PCID = '$r[PCID]'
group by ko.KONo",$conn);
					$rKO=mssql_fetch_array($ko);
					
$child=$r[ChildLevel];
	if($nokk!=""){	
		if($child > 0){
			$sqlgetparent=mssql_query("select ID,LotNo from ProcessControlBatches where ID='$r[RootID]' and ChildLevel='0'");
			$rowgp=mssql_fetch_assoc($sqlgetparent);
			
			//$nomLot=substr("$row2[LotNo]",0,1);
			$nomLot=$rowgp[LotNo];
			$nomorLot="$nomLot/K$r[ChildLevel]&nbsp;";				
								
		}else{
			$nomorLot=$r[LotNo];
				
		}

		$sqlLot1="Select count(*) as TotalLot From ProcessControlBatches where PCID='$r[PCID]' and RootID='0' and LotNo < '1000'";
		$qryLot1 = mssql_query($sqlLot1) or die('A error occured : ');							
		$rowLot=mssql_fetch_assoc($qryLot1);
		$lotno=$rowLot[TotalLot]."-".$nomorLot;
		

}
$sqlCek=mysql_query("SELECT * FROM tbl_tembakqty WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
$cek=mysql_num_rows($sqlCek);
$rcek=mysql_fetch_array($sqlCek);
?>	
<form class="form-horizontal" action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
 <div class="box box-info">
   <div class="box-header with-border">
    <h3 class="box-title">Input Data Kartu Kerja</h3>
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body"> 
	 <div class="col-md-4"> 
      <div class="form-group">
                  <label for="no_po" class="col-sm-4 control-label">No KK</label>
                  <div class="col-sm-5">
				  <input name="nokk" type="text" class="form-control" id="nokk" 
                     onchange="window.location='InputData-'+this.value" value="<?php echo $_GET[nokk];?>" placeholder="No KK" required>
		          </div>
		  		  <div class="col-sm-3">
                    <input type="checkbox" name="manual" id="manual" onClick="aktif();"> Manual
                    </div>
                </div>
	  <div class="form-group">
                  <label for="l_g" class="col-sm-4 control-label">Lebar X Gramasi</label>
                  <div class="col-sm-3">
                    <input name="lebar" type="text" class="form-control" id="lebar" 
                    value="<?php if($cek>0){echo number_format($rcek[lebar]);}else if($nokk!=""){echo round($r[Lebar]);}else{} ?>" placeholder="0" required>
                  </div>
				  <div class="col-sm-3">
                    <input name="grms" type="text" class="form-control" id="grms" 
                    value="<?php if($cek>0){echo number_format($rcek[berat]);}else if($nokk!=""){echo round($r[Gramasi]);}else{} ?>" placeholder="0" required>
					  
                  </div>
		  		  <div class="col-sm-2">
                    <input type="checkbox" value="1" id="plus3" name="plus3" class="minimal" <?php if($nokk!=""){if($rcek[plus3]=='1'){ echo "Checked";}}?> onClick="jumlah();" disabled>
                  </div> 	
                </div>         
	 </div>
	 <?php 
	  $sqlSUM=mysql_query("SELECT sum(net_wight) as kg,sum(yard_) as panjang, b.satuan,count(a.id) as jml FROM tbl_tembakqty a
INNER JOIN detail_tembakqty b ON a.id=b.id_kite WHERE a.nokk='$nokk'");
		$rSUM=mysql_fetch_array($sqlSUM);
	  ?> 
	  		<!-- col --> 
	 <div class="col-md-4"> 
	  <div class="form-group">
                  <label for="berat" class="col-sm-3 control-label">Berat</label>
                  <div class="col-sm-4">
					<div class="input-group">  
                    <input name="berat" type="text" class="form-control" id="berat" 
                    value="" placeholder="0.00"  style="text-align: right;" onChange="jumlah();" onKeyUp="angka(this);">
					<span class="input-group-addon">KGs</span>	
					</div>	
                  </div>
		      </div>
	  <div class="form-group">
                  <label for="no_roll" class="col-sm-3 control-label">No Roll</label>
                  <div class="col-sm-3">
                  <input name="no_roll" type="text" class="form-control" id="no_roll" placeholder="No Roll" value="" >
                  </div>
		  		  <div class="col-sm-4">
		          <select name="jns_pack" class="form-control">
					<option value="Rolls" <?php if($rcek[jns_pack]=="Rolls"){ echo "SELECTED"; }?>>Rolls</option>
					<option value="Bales" <?php if($rcek[jns_pack]=="Bales"){ echo "SELECTED"; }?>>Bales</option>
				  </select>
		          </div>		          
                </div>  		
	 </div>
	 <div class="col-md-4">
	  <div class="form-group">
                  <label for="panjang" class="col-sm-3 control-label">Panjang</label>
                  <div class="col-sm-6">
					  <div class="input-group">
                    <input name="panjang" type="text" class="form-control" id="panjang" 
                    value="" placeholder="0.00" style="text-align: right;" readonly>
						  <span class="input-group-addon">
							  <select name="satuan" style="font-size: 12px;" onChange="jumlah();">
								  <option value="Yard" <?php if($rSUM[satuan]=="Yard"){ echo "SELECTED"; }?>>Yard</option>
								  <option value="Meter" <?php if($rSUM[satuan]=="Meter"){ echo "SELECTED"; }?>>Meter</option>
							  </select>
					    </span></div>
					  
					  </div>		  			
                </div>
	  <div class="form-group">
                  <label for="grd" class="col-sm-3 control-label">Grade</label>
                  <div class="col-sm-4">
					  <div class="input-group">
							  <select name="grd"class="form-control">
								  <option value="A">A</option>
								  <option value="B">B</option>
								  <option value="C">C</option>
							  </select>
					  </div>
					  </div>
                </div>		
	 </div>
	  <input name="no_order" type="hidden" value="<?php if($cek>0){echo $rcek[no_order];}else{echo $r[NoOrder];} ?>">
	  <input name="pelanggan" type="hidden" value="<?php if($cek>0){echo $rcek[pelanggan];}else if($r1[partnername]!=""){echo $pelanggan;}else{}?>">
	  <input name="no_po" type="hidden" value="<?php if($cek>0){echo $rcek[no_po];}else{echo $r[PONumber];} ?>">
	  <input name="no_hanger" type="hidden" value="<?php if($cek>0){echo $rcek[no_hanger];}else{echo $r[HangerNo];}?>">
	  <input name="no_item" type="hidden" value="<?php if($rcek[no_item]!=""){echo $rcek[no_item];}else{echo $r[ProductCode];}?>">
	  <input name="jns_kain" type="hidden" value="<?php if($cek>0){echo $rcek[jenis_kain];}else{echo $r[ProductDesc];}?>">
	  <input name="lot" type="hidden" value="<?php if($cek>0){echo $rcek[no_lot];}else{echo $lotno;} ?>">
	  <input name="warna" type="hidden" value="<?php if($cek>0){echo $rcek[warna];}else{echo $r[Color];}?>">
	  <input name="no_warna" type="hidden" value="<?php if($cek>0){echo $rcek[no_warna];}else{echo $r[ColorNo];}?>">
</div>	 
   <div class="box-footer">
   <?php 
       $sqlCek1=mysql_query("SELECT * FROM detail_tembakqty WHERE nokkkite='$nokk' ORDER BY ROUND(no_roll) ASC ");
	   $cek1=mysql_num_rows($sqlCek1);
	   if($cek1>0){ 
   ?>
   <a href="#" data-toggle="modal" data-target="#CopyData"><span class="btn btn-warning pull-left"><i class="fa fa-save"></i> Copy Data</span></a>
   	   
   <?php } ?>	   
   <?php if($_GET['nokk']!=""){ ?> 	
   <button type="submit" class="btn btn-primary pull-right" name="save" value="save"><i class="fa fa-save"></i> Simpan</button> 
   <?php } ?>	   
   </div>
    <!-- /.box-footer -->
</div>
	<!-- POP UP -->
<div class="modal fade" id="CopyData">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Copy Data</h4>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                  <label for="jmlcpy" class="col-md-4 control-label">Jumlah</label>
                  <div class="col-md-3">
                  <input type="text" class="form-control" id="jmlcpy" name="jmlcpy" placeholder="0">
                  <span class="help-block with-errors"></span>
                  </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary pull-right" name="save_copy" value="save"><i class="fa fa-save"></i> Simpan</button>
              </div>
            
            </div>
            <!-- /.modal-content -->
  </div>
          <!-- /.modal-dialog -->
</div>	
</form>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Detail Kartu Kerja</h3>
		<?php if($nokk!=""){ ?>		
		<br>  
		<a href='pages/detail_cetak.php?id=<?php echo $nokk; ?>' ><span class="btn btn-danger pull-right"><i class="fa fa-print"></i> Cetak</span></a>
		<br>
		<strong><font color="red">Total Berat: <?php echo $rSUM[kg];?> Kgs<br>
		Total Panjang: <?php echo $rSUM[panjang]." ".$rSUM[satuan]."s";?><br>
		Jumlah Roll: <?php echo $rSUM[jml];?> 
        <?php } ?></font></strong>          
      </div>
<div class="box-body">
<table id="example3" class="table table-bordered table-hover table-striped display nowrap" width="100%">
<thead class="bg-green">
   <tr>
      <th width="55"><div align="center">No</div></th>
      <th width="251"><div align="center">Aksi</div></th>
      <th width="277"><div align="center">No Roll</div></th>
      <th width="206"><div align="center">Berat(Kgs)</div></th>
      <th width="199"><div align="center">Panjang</div></th>
      <th width="180"><div align="center">Satuan</div></th>
      <th width="180"><div align="center">Grade</div></th>
      </tr>
</thead>
<tbody>
  <?php
	$no=1;
	$sql=mysql_query("SELECT * FROM detail_tembakqty WHERE nokkkite='$nokk' ORDER BY no_roll ASC ");
	
	while($r=mysql_fetch_array($sql)){
	?>
   <tr>
     <td align="center"><?php echo $no; ?></td>
     <td align="center">
	 <a href="#" class="btn btn-danger btn-sm <?php if($_SESSION['akses1']=='biasa'){ echo "disabled"; } ?>" onclick="confirm_delete('./HapusData-<?php echo $r[id] ?>');"><i class="fa fa-trash"></i> </a>
     </td>
     <td align="center"><?php echo $r[no_roll];?></td>
     <td align="right"><?php echo $r[net_wight];?></td>
     <td align="right"><?php echo $r[yard_];?></td>
     <td align="center"><?php echo $r[satuan];?></td>
     <td align="center"><?php echo $r[grade];?></td>
     </tr>
   <?php $no++; } ?>
   </tbody>
   <tfoot class="bg-green">
   <tr>
     <td align="center"><div align="center">No</div></td>
     <td align="center"><div align="center">Aksi</div></td>
     <td align="center"><div align="center">No Roll</div></td>
     <td align="center"><div align="center">Berat(Kgs)</div></td>
     <td align="center"><div align="center">Panjang</div></td>
     <td align="center"><div align="center">Satuan</div></td>
     <td align="center"><div align="center">Grade</div></td>
     </tr>
   </tfoot>
</table>
</form>

      </div>
    </div>
  </div>
</div>
    
						
                    
<?php
if($_POST[save]=="save"){
	  $warna=str_replace("'","''",$_POST[warna]);
	  $nowarna=str_replace("'","''",$_POST[no_warna]);	
	  $jns=str_replace("'","''",$_POST[jns_kain]);
	  $po=str_replace("'","''",$_POST[no_po]);
	  $lot=trim($_POST[lot]);
	if($cek>0){
		$sqlKK=mysql_query("SELECT id FROM tbl_tembakqty WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
        $cekKK=mysql_num_rows($sqlKK);
        $rcekKK=mysql_fetch_array($sqlKK);
		if(strlen($_POST[no_roll])=="1"){$roll="0".$_POST[no_roll];}else{$roll=$_POST[no_roll];}
		$sqlDataD=mysql_query("INSERT INTO detail_tembakqty SET 
		  id_kite='$rcekKK[id]',	
		  nokkkite='$_POST[nokk]',
		  grade='$_POST[grd]',
		  no_roll='$roll',
		  net_wight='$_POST[berat]',
		  yard_='$_POST[panjang]',
		  satuan='$_POST[satuan]'
		  ")or die("Gagal Simpan Detail");
		if($sqlDataD){
		echo "<script>window.location.href='InputData-$nokk';</script>";	
			/* echo "<script>swal({
  title: 'Data Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='InputData-$nokk'; 
  }
});</script>"; */
		}
		
	}else{
  	  $sqlData=mysql_query("INSERT INTO tbl_tembakqty SET 
		  nokk='$_POST[nokk]',
		  pelanggan='$_POST[pelanggan]',
		  no_order='$_POST[no_order]',
		  no_hanger='$_POST[no_hanger]',
		  no_item='$_POST[no_item]',
		  no_po='$po',
		  jenis_kain='$jns',
		  lebar='$_POST[lebar]',
		  berat='$_POST[grms]',
		  jns_pack='$_POST[jns_pack]',
		  no_lot='$lot',
		  warna='$warna',
		  no_warna='$nowarna',
		  paket=now(),
		  tgl_update=now()");
		$sqlKK=mysql_query("SELECT id FROM tbl_tembakqty WHERE nokk='$nokk' ORDER BY id DESC LIMIT 1");
        $cekKK=mysql_num_rows($sqlKK);
        $rcekKK=mysql_fetch_array($sqlKK);
		if(strlen($_POST[no_roll])=="1"){$roll="0".$_POST[no_roll];}else{$roll=$_POST[no_roll];}
		$sqlDataD=mysql_query("INSERT INTO detail_tembakqty SET 
		  id_kite='$rcekKK[id]',	
		  nokkkite='$_POST[nokk]',
		  grade='$_POST[grd]',
		  no_roll='$roll',
		  net_wight='$_POST[berat]',
		  yard_='$_POST[panjang]',
		  satuan='$_POST[satuan]'
		  ")or die("Gagal Simpan Detail");
	}

		if($sqlData){
			echo "<script>window.location.href='InputData-$nokk';</script>";
			/* echo "<script>swal({
  title: 'Data Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='InputData-$nokk'; 
  }
});</script>"; */
		}
				
	}
if($_POST[save_copy]=="save"){
	    $sqlKD=mysql_query("SELECT * FROM detail_tembakqty WHERE nokkKite='$nokk' ORDER BY id DESC LIMIT 1");
        $rcekKD=mysql_fetch_array($sqlKD);
		$ulangi = 1;
		if($_POST[jmlcpy]>0){$jml=$_POST[jmlcpy];}else{$jml=0;}		
	    while($ulangi <= $jml){
		$rol= $rcekKD[no_roll]+$ulangi;
		if(strlen($rol)=="1"){$roll="0".$rol;}else{$roll=$rol;}
		$sqlDataDk=mysql_query("INSERT INTO detail_tembakqty SET 
		  id_kite='$rcekKD[id_kite]',	
		  nokkKite='$rcekKD[nokkKite]',
		  grade='$rcekKD[grade]',
		  no_roll='$roll',
		  net_wight='$rcekKD[net_wight]',
		  yard_='$rcekKD[yard_]',
		  satuan='$rcekKD[satuan]'
		  ")or die("Gagal Simpan Detail");			
			$ulangi++;
		}
	echo "<script>window.location.href='InputData-$nokk';</script>";
	
	/* echo "<script>swal({
  title: 'Data Tersimpan',   
  text: 'Klik Ok untuk input data kembali',
  type: 'success',
  }).then((result) => {
  if (result.value) {
    
	 window.location.href='InputData-$nokk'; 
  }
});</script>";
*/
}
?>
<!-- Modal Popup untuk delete-->
<div class="modal fade" id="modal_delete" tabindex="-1" >
  <div class="modal-dialog modal-sm" >
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Are you sure to delete this information ?</h4>
      </div>

      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger" id="delete_link">Delete</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    function confirm_delete(delete_url)
    {
      $('#modal_delete').modal('show', {backdrop: 'static'});
      document.getElementById('delete_link').setAttribute('href' , delete_url);
    }

</script>