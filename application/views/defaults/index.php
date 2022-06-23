<div class="content">
	<div class="container">
		<div class="row animated fadeIn">
			<div class="col-xs-12">
				<div class="page-title-box">
					<h4 class="page-title">Selamat datang, <?php echo empty($user_name) ? "" : $user_name; ?></h4>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="<?php echo site_url('defaults') ?>">Dashboard </a>
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<!-- end row -->
		<div class="row animated fadeInUp">
			<div class="col-md-12">
				<div class="card-box">
					<h4 class="header-title m-t-0 m-b-30">Laporan Gaji Satu Bulan Terakhir</h4>
					<div class="table-responsive">
						<table class="table table table-hover m-0">
							<?php
							if (count($report_last_month) > 0) {
								?>
								<thead>
								<tr>
									<th></th>
									<th>Nama Karyawan</th>
									<th>Gaji Kotor</th>
									<th>Total Potongan</th>
									<th>Total Tambahan</th>
									<th>Gaji Bersih</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($report_last_month as $rlm) { ?>
									<tr>
										<th>
                                                        <span class="avatar-sm-box bg-primary">
                                                            <i class="fa fa-user"></i>
                                                        </span>
										</th>
										<td>
											<h5 class="m-0"><?php echo $rlm->name ?></h5>
											<p class="m-0 text-muted font-13">
												<small><?php echo $rlm->position ?></small>
											</p>
										</td>
										<td>Rp. <?php echo number_format($rlm->gross_salary) ?> ,-</td>
										<td>Rp. <?php echo number_format($rlm->salary_decrease) ?> ,-</td>
										<td>Rp. <?php echo number_format($rlm->salary_increase) ?> ,-</td>
										<td>
											Rp. <?php echo number_format($rlm->gross_salary + $rlm->salary_increase - $rlm->salary_decrease) ?>
											,-
										</td>
									</tr>
								<?php } ?>
								</tbody>
								<?php
							} else {
								?>
								<p><center>Laporan Gaji Belum Tersedia..</center></p>
							<?php } ?>
						</table>
					</div> <!-- table-responsive -->
				</div> <!-- end card -->
			</div>
			<!-- end col -->
		</div>
		<!-- end row -->
	</div> <!-- container -->
</div> <!-- content -->
