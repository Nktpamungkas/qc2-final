<script>
	function aktif() {
		if (document.forms['form1']['manual'].checked == true) {
			document.form1.nokk.setAttribute("readonly", true);
			document.form1.nokk.removeAttribute("required");

		} else {
			document.form1.nokk.removeAttribute("readonly");
			document.form1.nokk.setAttribute("required", true);

		}
	}

	function rd() {
		if (document.forms['form1']['dyestuff'].value == "D" || document.forms['form1']['dyestuff'].value == "D+R") {
			document.forms['form1']['energi'].removeAttribute("disabled");
			document.forms['form1']['energi'].value = "";
		} else {
			document.forms['form1']['energi'].setAttribute("disabled", true);
			document.forms['form1']['energi'].value = "";
		}

	}

	function angka(e) {
		if (!/^[0-9 .]+$/.test(e.value)) {
			e.value = e.value.substring(0, e.value.length - 1);
		}
	}
</script>
<?php
	ini_set("error_reporting", 1);
	session_start();
	require_once "koneksi.php";
	$nodemand = $_GET['nodemand'];
	require_once 'now.php';
?>
<?php
	$Kapasitas	= isset($_POST['kapasitas']) ? $_POST['kapasitas'] : '';
	$TglMasuk	= isset($_POST['tglmsk']) ? $_POST['tglmsk'] : '';
	$Item		= isset($_POST['item']) ? $_POST['item'] : '';
	$Warna		= isset($_POST['warna']) ? $_POST['warna'] : '';
	$Langganan	= isset($_POST['langganan']) ? $_POST['langganan'] : '';
	$con1=mysqli_connect("10.0.0.10","dit","4dm1n","db_finishing");
	$qryFin=mysqli_query($con1,"SELECT *,DATE_FORMAT(tgl_proses_out,'%d-%m-%Y') as tgl_o FROM tbl_produksi WHERE demandno='$nodemand' ORDER BY id DESC LIMIT 1");
	$dtFin=mysqli_fetch_assoc($qryFin);
?>
<form class="form-horizontal" action="pages/detail_cetak_erp.php" method="post" enctype="multipart/form-data" name="form1">
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
						<input name="nokk" type="hidden" class="form-control" id="nokk" value="<?php if ($cek > 0) {
																									echo $rcek['nokk'];
																								} else {
																									echo $rowdb2['PRODUCTIONORDERCODE'];
																								} ?>" placeholder="Nokk ERP">
						<input name="nodemand" type="text" class="form-control" id="nodemand" onchange="window.location='InputDataERP-'+this.value" value="<?php echo $_GET['nodemand']; ?>" placeholder="No Demand" required autocomplete="off">
					</div>
				</div>
				<div class="form-group">
					<label for="langganan" class="col-sm-3 control-label">Langganan</label>
					<div class="col-sm-8">
						<input name="langganan" type="text" class="form-control" id="langganan" value="<?php if ($cek > 0) {
																											echo $rcek['langganan'];
																										} else {
																											echo $dt_pelanggan_buyer['PELANGGAN'];
																										} ?>" placeholder="Langganan">
					</div>
				</div>
				<div class="form-group">
					<label for="buyer" class="col-sm-3 control-label">Buyer</label>
					<div class="col-sm-8">
						<input name="buyer" type="text" class="form-control" id="buyer" value="<?php if ($cek > 0) {
																									echo $rcek['buyer'];
																								} else {
																									echo $dt_pelanggan_buyer['BUYER'];
																								} ?>" placeholder="Buyer">
					</div>
				</div>
				<div class="form-group">
					<label for="no_order" class="col-sm-3 control-label">No Order</label>
					<div class="col-sm-4">
						<input name="no_order" type="text" class="form-control" id="no_order" value="<?php if ($cek > 0) {
																											echo $rcek['no_order'];
																										} else {
																											echo $dt_ITXVIEWKK['PROJECTCODE'];
																										} ?>" placeholder="No Order">
					</div>
				</div>
				<div class="form-group">
					<label for="no_po" class="col-sm-3 control-label">PO</label>
					<div class="col-sm-5">
						<input name="no_po" type="text" class="form-control" id="no_po" value="<?php if ($cek > 0) {
																									echo $rcek['no_po'];
																								} else {
																									echo $dt_po['NO_PO'];
																								} ?>" placeholder="PO">
					</div>
				</div>
				<div class="form-group">
					<label for="no_hanger" class="col-sm-3 control-label">No Hanger / No Item</label>
					<div class="col-sm-3">
						<input name="no_hanger" type="text" class="form-control" id="no_hanger" value="<?php if ($cek > 0) {
																											echo $rcek['no_hanger'];
																										} else {
																											echo $dt_ITXVIEWKK['NO_HANGER'];
																										} ?>" placeholder="No Hanger">
					</div>
					<div class="col-sm-3">
						<input name="no_item" type="text" class="form-control" id="no_item" value="<?php if ($rcek['no_item'] != "") {
																										echo $rcek['no_item'];
																									} else {
																										echo $dt_item['EXTERNALITEMCODE'];
																									} ?>" placeholder="No Item">
					</div>
				</div>
				<div class="form-group">
					<label for="jns_kain" class="col-sm-3 control-label">Jenis Kain</label>
					<div class="col-sm-8">
						<textarea name="jns_kain" class="form-control" id="jns_kain" placeholder="Jenis Kain"><?php if ($cek > 0) {
																													echo $rcek['jenis_kain'];
																												} else {
																													echo stripslashes($dt_ITXVIEWKK['ITEMDESCRIPTION']);
																												} ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_delivery" class="col-sm-3 control-label">Tgl. Delivery</label>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="tgl_delivery" type="text" class="form-control pull-right" id="datepicker2" placeholder="0000-00-00" value="<?php if ($cek > 0) {
																																						echo $rcek['tgl_delivery'];
																																					} else {
																																						if ($dt_ITXVIEWKK['DELIVERYDATE'] != "") {
																																							echo date('Y-m-d', strtotime($dt_ITXVIEWKK['DELIVERYDATE']));
																																						}
																																					} ?>" />
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="l_g" class="col-sm-3 control-label">Lebar X Gramasi</label>
					<div class="col-sm-2">
						<input name="lebar" type="text" class="form-control" id="lebar" value="<?php if ($cek > 0) {
																									echo $rcek['lebar'];
																								} else {
																									echo number_format($dt_lg['LEBAR'], 2);
																								} ?>" placeholder="0">
					</div>
					<div class="col-sm-2">
						<input name="grms" type="text" class="form-control" id="grms" value="<?php if ($cek > 0) {
																									echo $rcek['gramasi'];
																								} else {
																									echo number_format($dt_lg['GRAMASI'], 2);
																								} ?>" placeholder="0">
					</div>
				</div>
				<div class="form-group">
					<label for="warna" class="col-sm-3 control-label">Warna</label>
					<div class="col-sm-8">
						<input name="warna" type="text" class="form-control" id="warna" value="<?php if ($cek > 0) {
																									echo $rcek['warna'];
																								} else {
																									echo $dt_warna['WARNA'];
																								} ?>" placeholder="Warna">
					</div>
				</div>
				<div class="form-group">
					<label for="no_warna" class="col-sm-3 control-label">No Warna</label>
					<div class="col-sm-8">
						<input name="no_warna" type="text" class="form-control" id="no_warna" value="<?php if ($cek > 0) {
																											echo $rcek['no_warna'];
																										} else {
																											echo $dt_ITXVIEWKK['NO_WARNA'];
																										} ?>" placeholder="No Warna">
					</div>
				</div>
			</div>
			<!-- col -->
			<div class="col-md-6">




				<div class="form-group">
					<label for="qty_order" class="col-sm-3 control-label">Qty Order</label>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty1" type="text" class="form-control" id="qty1" value="<?php if ($cek > 0) {
																										echo $rcek['qty_order'];
																									} else {
																										echo round($dt_qtyorder['QTY_ORDER'], 2);
																									} ?>" placeholder="0.00">
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="input-group">
							<input name="qty2" type="text" class="form-control" id="qty2" value="<?php if ($cek > 0) {
																										echo $rcek['pjng_order'];
																									} else {
																										echo round($dt_qtyorder['QTY_ORDER_YARD'], 2);
																									} ?>" placeholder="0.00" style="text-align: right;">
							<span class="input-group-addon">
								<select name="satuan1" style="font-size: 12px;">
									<option value="Yard" <?php if ($dt_qtyorder['SATUAN_QTY'] == "yd") {
																echo "SELECTED";
															} ?>>Yard</option>
									<option value="Meter" <?php if ($dt_qtyorder['SATUAN_QTY'] == "m") {
																echo "SELECTED";
															} ?>>Meter</option>
									<option value="PCS" <?php if ($dt_qtyorder['SATUAN_QTY'] == "un") {
															echo "SELECTED";
														} ?>>PCS</option>
								</select>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="lot" class="col-sm-3 control-label">Prod.Order / Lot</label>
					<div class="col-sm-2">
						<input name="lot" type="text" class="form-control" id="lot" value="<?php echo $dt_ITXVIEWKK['PRODUCTIONORDERCODE']; ?>" placeholder="Prod Order / Lot">
					</div>
				</div>
				<div class="form-group">
					<label for="loterp" class="col-sm-3 control-label">Lot Legacy</label>
					<!--<div class="col-sm-3">
                    <input name="loterp" type="text" class="form-control" id="loterp" 
                    value="" placeholder="No KK Legacy" >
                  </div>-->
					<div class="col-sm-2">
						<input name="demanderp" type="text" class="form-control" id="demanderp" value="<?= $dt_ITXVIEWKK['LOT']; ?>" placeholder="Lot Legacy">
					</div>
				</div>
				<div class="form-group">
					<label for="loterp" class="col-sm-3 control-label">Previous Order</label>
					<div class="col-sm-8">
						<input name="loterp" type="text" class="form-control" id="loterp" value="<?= $dt_stdcckwarna['STANDART_COCOK_WARNA']; ?>" placeholder="Previous Order">
					</div>
					<!--<div class="col-sm-2">
                    <input name="demanderp" type="text" class="form-control" id="demanderp" 
                    value="" placeholder="Lot Legacy" >
                  </div>-->
				</div>
				<div class="form-group">
					<label for="jml_bruto" class="col-sm-3 control-label">Rol &amp; Qty</label>
					<div class="col-sm-2">
						<input name="qty3" type="text" class="form-control" id="qty3" value="<?php if ($cek > 0) {
																									echo $rcek['rol'];
																								} else {
																									echo $dt_roll['ROLL'];
																								} ?>" placeholder="0.00">
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="qty4" type="text" class="form-control" id="qty4" value="<?php if ($cek > 0) {
																										echo $rcek['bruto'];
																									} else {
																										echo number_format($dt_po['QTY_BRUTO'], '2', '.', '');
																									} ?>" placeholder="0.00" style="text-align: right;">
							<span class="input-group-addon">KGs</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="mc" class="col-sm-3 control-label">Mesin</label>
					<div class="col-sm-3">
						<input name="mc" type="text" class="form-control" id="mc" value="<?php echo $dtFin['no_mesin']; ?>" placeholder="Mesin">
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="speed" type="text" class="form-control" id="speed" value="<?php if ($dtFin['speed'] != "") {
																										echo $dtFin['speed'];
																									} else {
																										echo round($rowSpeed['VALUEQUANTITY']);
																									} ?>" placeholder="0.00" style="text-align: right;">
							<span class="input-group-addon">speed</span>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<input name="suhu" type="text" class="form-control" id="suhu" value="<?php if ($dtFin['suhu'] != "") {
																										echo $dtFin['suhu'];
																									} else {
																										echo round($rowSuhu['VALUEQUANTITY']);
																									} ?>" placeholder="0.00" style="text-align: right;">
							<span class="input-group-addon">&deg;</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="proses" class="col-sm-3 control-label">Proses</label>
					<div class="col-sm-6">
						<input name="proses" type="text" class="form-control" id="proses" value="<?php echo $dtFin['proses']; ?>" placeholder="Proses">
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_finishing" class="col-sm-3 control-label">Tgl. Finishing</label>
					<div class="col-sm-4">
						<div class="input-group date">
							<div class="input-group-addon"> <i class="fa fa-calendar"></i> </div>
							<input name="tgl_finishing" type="text" class="form-control pull-right" id="datepicker3" placeholder="00-00-0000" value="<?php echo $dtFin['tgl_o']; ?>" autocomplete="off" />
						</div>
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
							<option value="6">6x</option>
							<option value="7">7x</option>
							<option value="8">8x</option>
							<option value="9">9x</option>
							<option value="10">10x</option>
						</select>
					</div>
				</div>
			</div>


			<input type="hidden" value="<?php if ($cek > 0) {
											echo $rcek['no_ko'];
										} else {
											echo $rKO['KONo'];
										} ?>" name="no_ko">

		</div>
		<div class="box-footer">
			<?php if ($_GET['nodemand'] != "") { ?>
				<button type="submit" class="btn btn-danger pull-right" name="cetak" value="cetak"><i class="fa fa-print"></i> Cetak</button>
			<?php } ?>
		</div>
		<!-- /.box-footer -->
	</div>
</form>