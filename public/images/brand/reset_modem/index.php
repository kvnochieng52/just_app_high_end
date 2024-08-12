<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css" />
<div class="page-header">

	<h1>

		Reset Wifi

		<small>

			<i class="ace-icon fa fa-angle-double-right"></i>

			Reset your Wifi.

		</small>
		<?php if (isset($auto_refresh_page) && $auto_refresh_page) { ?>
			<button class="btn btn-sm btn-danger pull-right" id="cancel-auto-refresh">
				<i class="fa fa-close"></i>
				Cancel refresh
			</button>
		<?php } ?>

	</h1>

</div>


<div class="col-md-12" style="padding:0px">


	<table class="table table-bordered table-striped" id="table-eqp">


		<thead class="thin-border-bottom">


			<tr>
				<th>

					<i class="ace-icon fa fa-caret-right blue"></i>Acct No

				</th>

				<th class="hidden-480">

					<i class="ace-icon fa fa-caret-right blue"></i>Mac Address

				</th>

				<th class="hidden-480">

					<i class="ace-icon fa fa-caret-right blue"></i>SSID

				</th>

				<th class="hidden-480">
					<i class="ace-icon fa fa-caret-right blue"></i>Password
				</th>

				<th class="hidden-480">

					<i class="ace-icon fa fa-caret-right blue"></i>Reset

				</th>

			</tr>

		</thead>


		<tbody>




			<?php foreach ($gponModems as $gponModem) { ?>
				<tr>
					<td><a href=""><strong><?php echo $gponModem->esubs ?></strong></a></td>
					<td>
						<?php echo $gponModem->ecvtid ?>
					</td>

					<td>
						<?php echo $gponModem->ssidname ?>
					</td>


					<td>
						<?php
						if (!empty($gponModem->password)) {
						?>
							<button class="btn btn-success btn-sm show-eq-password" id="show-eq-password-<?php echo $gponModem->ecvtid; ?>" data-row='<?php echo json_encode(array('mac' => $gponModem->ecvtid)) ?>'>
								<i class="fa fa-eye"></i>
							</button>
							<button class="btn btn-warning btn-sm hide-eq-password" id="hide-eq-password-<?php echo $gponModem->ecvtid; ?>" data-row='<?php echo json_encode(array('mac' => $gponModem->ecvtid)) ?>'>
								<i class="fa fa-eye-slash"></i>
							</button>
						<?php
						}
						?>

					</td>

					<td>


						<a href="#" class="reset-password" data-row='<?php echo json_encode(array('ssid' => $gponModem->ssidname, 'mac' => $gponModem->ecvtid, 'subs' => $gponModem->esubs, 'device_type' => 'gpon', 'equipgpn_eid' => $gponModem->id)) ?>'>
							Reset Password
						</a>


					</td>
				</tr>
			<?php } ?>



			<?php foreach ($huaweiModems as $hmodem) { ?>
				<!-- <tr>


					<td><a href=""><strong><?php echo $hmodem->esubs ?></strong></a></td>
					<td><?php echo $hmodem->onu_id ?></td>
					<td><?php echo $hmodem->ssid_name ?></td>
					<td></td>
					<td>
						<a href="#" class="reset-password" data-row='<?php echo json_encode(array('ssid' => $hmodem->ssid_name, 'mac' => $hmodem->onu_id, 'subs' => $hmodem->esubs, 'device_type' => 'huawei', 'equipgpn_eid' => $hmodem->id)) ?>'>
							Reset Password
						</a>
					</td>
				</tr> -->

			<?php } ?>
		</tbody>

	</table>

	<div id="wifi-reset-form-modal" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<form name="wifi-reset-form" id="wifi-reset-form" action="<?php echo site_url() ?>dashboard/reset_modem_action" method="post">
					<div class="modal-header no-padding">
						<div class="table-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="white">&times;</span>
							</button>
							Reset Wifi: <b id="wifi-reset-form-active-eqp-mac">Mac Address: </b>
						</div>
					</div>
					<div class="modal-body">
						<input type="hidden" id="subs" name="subs">
						<input type="hidden" id="mac" name="mac">
						<input type="hidden" id="old-ssid" name="old_ssid">
						<input type="hidden" id="device-type" name="device_type">
						<input type="hidden" id="equipgpn-eid" name="equipgpn_eid">

						<div class="form-group">
							<label class="block clearfix">SSID</label>
							<span class="block input-icon">
								<input type="text" class="form-control" placeholder="SSID" name="ssid" id="ssid" />
								<i class="ace-icon fa fa-key"></i>
							</span>
						</div>
						<div class="form-group">
							<label class="block clearfix">Password</label>
							<span class="block input-icon">
								<input type="password" class="form-control" placeholder="Password" id="password" name="password" />
								<i class="ace-icon fa fa-lock"></i>
							</span>
						</div>
						<div class="form-group">
							<label class="block clearfix">Confirm Password</label>
							<span class="block input-icon">
								<input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" id="confirm-password" />
								<i class="ace-icon fa fa-lock"></i>
							</span>
						</div>
					</div>
					<div class="modal-footer no-margin-top">
						<button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
							<i class="ace-icon fa fa-times"></i> Close
						</button>
						<button class="btn btn-sm btn-success pull-right" type="submit" id="btn-submit-wifi-reset-form">
							<i class="ace-icon fa fa-save"></i> Reset
						</button>
					</div>
				</form>
			</div><!-- /.modal-content -->

		</div><!-- /.modal-dialog -->

	</div>
	<script src="<?php echo base_url(); ?>components/jquery/dist/jquery.js"></script>
	<script>
		var cancelRefresh = false;

		function refreshPage(timeout) {
			setTimeout(function() {
				if (!cancelRefresh) {
					window.location.reload(true);
				}
			}, timeout)
		}

		$(document).ready(function() {
			<?php
			if (isset($auto_refresh_page) && $auto_refresh_page) {
				echo "refreshPage(120000);";
			}
			?>
			$("#table-eqp").on('click', '.reset-password', function(e) {
				var eqp = JSON.parse($(this).attr("data-row"));
				$("#wifi-reset-form-active-eqp-mac").html(eqp.mac);
				$("#subs").val(eqp.subs);
				$("#mac").val(eqp.mac);
				$("#ssid").val(eqp.ssid);
				$("#old-ssid").val(eqp.ssid);
				$("#device-type").val(eqp.device_type);
				$("#equipgpn-eid").val(eqp.equipgpn_eid);

				$("#password").val("");
				$("#confirm-password").val("");

				$("#wifi-reset-form-modal").modal('show');
			});

			$("#cancel-auto-refresh").on('click', function(e) {
				cancelRefresh = true;
				$(".notices").html("");
				$("#cancel-auto-refresh").hide();
			});

			/*$("#allow-auto-refresh").on('click', function (e) {
				refreshPage(0);
				$("#allow-auto-refresh").hide();
				$("#cancel-auto-refresh").show();
			});*/


			$("#table-eqp").on('click', '.show-eq-password', function(e) {
				var eqp = JSON.parse($(this).attr("data-row"));
				$("#eqp-password-" + eqp.mac).show();
				$("#show-eq-password-" + eqp.mac).hide();
				$("#hide-eq-password-" + eqp.mac).show();
			});

			$("#table-eqp").on('click', '.hide-eq-password', function(e) {
				var eqp = JSON.parse($(this).attr("data-row"));
				$("#eqp-password-" + eqp.mac).hide();
				$("#hide-eq-password-" + eqp.mac).hide();
				$("#show-eq-password-" + eqp.mac).show();
			});

			$(".hide-eq-password").hide();

			// $("#btn-submit-wifi-reset-form").prop("disabled", true);

			$("#wifi-reset-form").bootstrapValidator({
				feedbackIcons: {
					valid: 'fa fa-check',
					invalid: 'fa fa-close',
					validating: 'fa fa-refresh'
				},
				live: 'enabled',
				message: 'This value is not valid',
				submitButtons: 'button[type="submit"]',
				trigger: null,
				fields: {
					ssid: {
						validators: {
							notEmpty: {
								message: 'Enter network SSID'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'Enter Wifi Password'
							},
							stringLength: {
								min: 8,
								message: 'Password should be at least 8 characters'
							}
						}
					},
					confirm_password: {
						validators: {
							notEmpty: {
								message: 'Confirm Wifi Password'
							},
							identical: {
								field: 'password',
								message: 'Passwords do not match'
							},
							stringLength: {
								min: 8,
								message: 'Password should be at least 8 characters'
							}
						}
					}
				}
			}).on('error.form.bv', function(e) {}).on('success.form.bv', function(e) {
				$("#btn-submit-wifi-reset-form").html("Resetting password. Please wait...")
			}).on('error.field.bv', function(e, data) {}).on('success.field.bv', function(e, data) {}).on('status.field.bv', function(e, data) {});
		})
	</script>