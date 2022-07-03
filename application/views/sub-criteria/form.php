<div class="content">
	<div class="container">
		<div class="row animated fadeIn">
			<div class="col-xs-12">
				<div class="page-title-box">
					<?php
					$id = "";
					if (!empty($data)) {
						$id = $data['id'];
					}
					if ($id == "") {
						?>
						<h4 class="page-title">Tambah Data Sub Kriteria</h4>
					<?php } else { ?>
						<h4 class="page-title">Ubah Data Sub Kriteria</h4>
					<?php } ?>
					<ol class="breadcrumb p-0 m-0">
						<li>
							<a href="#">Master Data</a>
						</li>
						<li>
							<a href="<?php echo site_url('/subcriteria'); ?>">Sub Kriteria </a>
						</li>
						<li class="active">
							Tambah Data Sub Kriteria
						</li>
					</ol>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<!-- end row -->
		<div class="row animated fadeInUp">
			<div class="col-sm-12">
				<div class="card-box">
					<div class="row">
						<div class="col-md-12">
							<?php echo $alert; ?>
							<form method="post" class="form-horizontal">
								<div class="form-group">
									<label class="control-label col-md-2">Nama <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="name" class="form-control"
											   value="<?php echo empty($data['name']) ? "" : $data['name']; ?>">
										<?php echo form_error('name', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Bobot <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="weight" class="form-control"
											   value="<?php echo empty($data['weight']) ? "" : $data['weight']; ?>">
										<?php echo form_error('weight', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Tipe <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<?php echo form_dropdown('type', $type, empty($data['type']) ? "" : $data['type'], 'class="form-control"'); ?>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-2">Keterangan <span
												class="text-danger">*</span></label>
									<div class="col-md-10">
										<input type="text" name="description" class="form-control"
											   value="<?php echo empty($data['description']) ? "" : $data['description']; ?>">
										<?php echo form_error('description', '<div class="error">', '</div>'); ?>
									</div>
								</div>
								<div class="form-group text-right m-b-0">
									<div class="col-md-2">
										<input type="hidden" name="id"
											   value="<?php echo empty($data['id']) ? '' : $data['id']; ?>">
									</div>
									<div class="col-md-10">
										<a href="<?php echo site_url('/criteria'); ?>" class="btn btn-danger">Back</a>
										<input type="submit" name="save" class="btn btn-success" value="Simpan">
									</div>
								</div>
							</form>
						</div>
					</div>
					<!-- end row -->
				</div>
			</div>
		</div>
		<!-- end row -->
	</div> <!-- container -->
</div>
