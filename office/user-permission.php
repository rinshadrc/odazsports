<?php
include("template.php");
head("Odaz Sports | Update User Permissions");
main_nav();
$typ = $_GET["uid"] ? $_GET["uid"] : "";
?>
<style type="text/css">
	.irwrp li {
		list-style: none;
		clear: both;
	}

	.irwrp li div {
		float: left;
	}
</style>
<?php
$empobj = new MysqliDb(HOST, USER, PWD, DB);
//$empobj->where('ut_id',1,">");
$emparr = $empobj->get("mv_utype", null, "ut_id,ut_name");
?>

<div class="content-wrapper">
	<!-- Content -->
	<div class="container-xxl flex-grow-1 container-p-y">
		<!-- Hoverable Table rows -->
		<div class="row" style="margin-top: 30px;">
			<!-- Form controls -->
			<div class="col-xl-12">
				<!-- HTML5 Inputs -->
				<div class="card mb-6">
					<h5 class="card-header">User Permissions</h5><br>
					<div class="card-body">

						<form class="frmSeltyp" id="frmSeltyp" method="POST">
							<div class="col-xl-4">
								<div class="form-floating form-floating-outline mb-6">
									<select class="form-select" id="selType" name="selType">
										<option selected="">Select</option>
										<?php foreach ($emparr as $key => $etyp) {
											if ($typ == $etyp["ut_id"]) {
												echo "<option value='$etyp[ut_id]' selected='selected' >$etyp[ut_name]</option>";
											} else {
												echo "<option value='$etyp[ut_id]'>$etyp[ut_name]</option>";
											}
										} ?>

									</select>
									<label for="selType">User Type</label>
								</div>
							</div>
						</form>

						<form id="frmemPrmsn" method="POST">
							<input type="hidden" name="action" value="accPrmsn">
							<div class="irwrp">
								<?php
								//ini_set('display_errors', 1);
								$mnubj = new MysqliDb(HOST, USER, PWD, DB);
								$mtypstr = $typ ? "AND up.u_type=$typ" : "";
								$mnubj->groupBy("mm.mm_id,md.md_id");
								$mnubj->orderBy("mm.mm_order,md.md_order", "ASC");
								$mnubj->join("mv_menudetail md", "md.mm_id=mm.mm_id", "LEFT");
								$menuar = $mnubj->get("mv_menumaster mm", null, "mm.mm_id,mm.mm_title,md_titile,md.md_id");
								$mnubj->where("u_type", $typ);
								$prmar = $mnubj->get("mv_upermit", null, "mm_id,up_id,md_id");

								foreach ($prmar as $key => $prm) {
									if ($prm["md_id"])
										$permdt[$prm["md_id"]] = $prm["up_id"];
									else
										$permst[$prm["mm_id"]] = $prm["up_id"];
								}
								foreach ($menuar as $key => $menu) {
									$maimarr[$menu['mm_id']] = array("mmttl" => $menu['mm_title']);
									$sbmenarr[$menu['mm_id']][$menu['md_id']] = array("mdttl" => $menu['md_titile']);
								}
								//print_r($sbmenarr);
								foreach ($maimarr as $mindex => $mentt) {
									$chkmm = $permst[$mindex] ? "checked='checked'" : "";
								?>
									<ul>

										<li>
											<div class="form-check form-check-success">
											<div class='ircchk '>
												<input type='checkbox' <?php echo $chkmm; ?> class='chkRep chkPrnt form-check-input' name='chkPrnt[<?php echo $mindex ?>]' value='<?php echo $permst[$mindex] ? $permst[$mindex] : 'NULL' ?>'>
											</div>
											<label class='irname form-check-label'> &nbsp;<?php echo $mentt['mmttl'] ?></label>
											</div>
											<ul>
												<?php
												//print_r($sbmenarr[$upid]);
												foreach ($sbmenarr[$mindex] as $key => $sbmenu) {
													if ($key) {
														$chksb = $permdt[$key] ? "checked='checked'" : "";
												?>
														<li>
															<div class="form-check form-check-success">
															<div class='ircchk '>
																<input type='checkbox' <?php echo $chksb ?> class='chkRep chkchld form-check-input' name='chkchld[<?php echo $mindex ?>][<?php echo $key; ?>]' data-id='' value='<?php echo $permdt[$key] ? $permdt[$key] : 'NULL' ?>'>
															</div>
															<label class='irname form-check-label'> &nbsp;<?php echo $sbmenu['mdttl'] ?>
															</label>
															</div>
														</li>
												<?php
													}
												} ?>
											</ul>
										</li>
									</ul>


								<?php } ?>
							</div>
							<br>
							<div class="row mt-6">
								<div class="col-12">
									<button class="btn btn-primary me-4 waves-effect waves-light">Save</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- / Content -->

<?php footer();
scripts();
?>
	<script>
	$(document).ready(function() {
		$(document).on("change", "#selType", function(evt) {
		console.log("selected");
			qs = $(this).val();
			qs = encodeURIComponent(qs);
			changeUrl("<?php echo ADMINROOT ?>user-permission/" + qs);

			$("#frmSeltyp").submit();
		});

		$(document).on("click", ".chkRep", function() {
			sts = $(this).is(":checked");
			if (sts) {
				$(this).parentsUntil(".irwrp").each(function(index, prt) {
					if (prt.tagName.toLowerCase() == "li") {
						$(this).find(".ircchk:first .chkRep").attr("checked", true).prop("checked", true);
					}
				});
			} else {
				li = $(this).closest('li');
				$(li).find(".chkRep").each(function(index, chk) {
					$(chk).removeAttr("checked");
					if ($(chk).val()) {

						$("<input type='hidden' name='delids[]' value='" + $(chk).val() + "'>").appendTo("#frmemPrmsn");
					}
				});
			}
		});
		$(document).on("submit", "#frmemPrmsn", function(event) {
			event.preventDefault();
			$("<input type='hidden' name='etype' value='" + $("#selType").val() + "'>").appendTo("#frmemPrmsn");
			$.ajax({
					url: '<?php echo ROOT ?>ajax/user-ajax.php',
					type: 'POST',
					data: $("#frmemPrmsn").serialize(),
				})
				.done(function(response) {
					console.log(response);
					jsnres = $.parseJSON(response);
					if (jsnres.status == 'done') {
						$("#frmSeltyp").submit();
					}

				})
				.fail(function() {
					console.log("error");
				})
				.always(function() {
					console.log("complete");
				});

		});
	});
</script>
</body>
</html>
