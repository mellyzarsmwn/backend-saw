<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
	<meta name="author" content="Coderthemes">

	<!-- App favicon -->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
	<!-- App title -->
	<title>KoProll</title>

	<?php $this->load->view('default_css/' . $this->css_default) ?>
</head>
<body class="fixed-left">
<!-- Begin page -->
<div id="wrapper">
	<!-- Top Bar Start -->
	<div class="topbar">
		<!-- LOGO -->
		<div class="topbar-left">
			<!-- <a href="index.html" class="logo"><span>Ko<span>Proll</span></span><i class="mdi mdi-layers"></i></a> -->
			<!-- Image logo -->
			<a href="index.html" class="logo">
                        <span>
                            <img src="<?php echo base_url(); ?>assets/images/KoProll-logo-inv.png" alt="" height="50">
                        </span>
				<i>
					<img src="<?php echo base_url(); ?>assets/images/KoProll.png" alt="" height="40">
				</i>
			</a>
		</div>
		<!-- Button mobile view to collapse sidebar menu -->
		<div class="navbar navbar-default" role="navigation">
			<div class="container">

				<!-- Navbar-left -->
				<ul class="nav navbar-nav navbar-left">
					<li>
						<button class="button-menu-mobile open-left waves-effect">
							<i class="mdi mdi-menu"></i>
						</button>
					</li>
				</ul>
				<!-- Right(Notification) -->
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown user-box">
						<a class="waves-effect user-link" aria-expanded="true">
							<h5>Hi, <?php echo empty($user_name) ? "" : $user_name; ?></h5>
						</a>
					</li>

				</ul>
				<!-- end navbar-right -->
			</div><!-- end container -->
		</div><!-- end navbar -->
	</div>
	<!-- Top Bar End -->

	<!-- ========== Left Sidebar Start ========== -->
	<div class="left side-menu">
		<div class="sidebar-inner slimscrollleft">

			<!--- Sidemenu -->
			<div id="sidebar-menu">
				<ul>
					<li class="menu-title">Menu</li>

					<li class="has_sub">
						<a href="<?php echo site_url('defaults') ?>" class="waves-effect"><i
									class="mdi mdi-view-dashboard"></i><span> Dashboard </span> </a>
					</li>
					<?php
					// 4: akses admin, 3: akses bendahara
					if ($access == 4 || $access == 3) { ?>
						<li class="has_sub">
							<a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-clipboard-text"></i>
								<span> Master Data </span>
								<span class="menu-arrow"></span></a>
							<ul class="list-unstyled">
								<?php
								// 4: akses admin
								if ($access == 4) { ?>
									<li><a href="<?php echo site_url('user') ?>">Pengguna</a></li>
									<li><a href="<?php echo site_url('employee') ?>">Karyawan</a></li>
								<?php } elseif ($access == 3) { ?> <!-- 3: akses bendahara -->
									<li><a href="<?php echo site_url('salarytype') ?>">Potongan/Tambahan</a></li>
								<?php } ?>
							</ul>
						</li>
					<?php } ?>
					<?php
					// 1: akses ketua, 2: akses wakil ketua, 3: akses bendahara
					if ($access == 1 || $access == 2 || $access == 3) { ?>
						<li class="has_sub">
							<a href="<?php echo site_url('salaryreport') ?>" class="waves-effect"><i
										class="mdi mdi-cash-multiple"></i><span> Laporan Gaji </span> </a>
						</li>
					<?php } ?>
					<li class="has_sub">
						<a href="<?php echo site_url('login/out') ?>" class="waves-effect"><i class="mdi mdi-power"></i><span> Logout </span>
						</a>
					</li>
				</ul>
			</div>
			<!-- Sidebar -->
			<div class="clearfix"></div>
		</div>
		<!-- Sidebar -left -->
	</div>
	<!-- Left Sidebar End -->

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<?= $content ?>

		<footer class="footer text-right">
		</footer>
	</div>
	<!-- ============================================================== -->
	<!-- End Right content here -->
	<!-- ============================================================== -->
	<!-- Right Sidebar -->
	<!-- /Right-bar -->
</div>
<!-- END wrapper -->
<?php $this->load->view('default_js/' . $this->js_default) ?>
<!-- /#wrapper -->
</body>
</html>
