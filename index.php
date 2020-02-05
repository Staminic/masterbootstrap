<?php
/*------------------------------------------------------------------------
# author Gonzalo Suez
# copyright Copyright © 2013 gsuez.cl. All rights reserved.
# @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website http://www.gsuez.cl
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

include 'includes/params.php';

if ($params->get('compile_sass', '0') === '1')
{
	require_once "includes/sass.php";
}

$jparams = $app->getParams();
$pageclass = $jparams->get('pageclass_sfx');
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<?php include 'includes/head.php'; ?>
	<body class="<?php echo (($menu->getActive() == $menu->getDefault()) ? ('front') : ('site')).$pageclass.' '.$option; ?>">
	<?php if($layout == 'boxed') { ?>
	<?php  $path = JURI::base().'templates/'.$this->template."/images/elements/pattern".$pattern.".png"; ?>
	<style type="text/css">
		body { background: url("<?php echo $path ; ?>") repeat fixed center top rgba(0, 0, 0, 0); }
	</style>
	<div class="layout-boxed">
	<?php } ?>

		<div id="wrap">

			<!--Navigation-->
			<header id="header" class="header header--fixed hide-from-print" role="banner">
				<?php  if($this->countModules('top')) : ?>
				<!--top-->
				<div id="top" class="navbar-inverse">
					<div class="container">
						<div class="row">
							<jdoc:include type="modules" name="top" style="none" />
						</div>
					</div>
				</div>
				<!--top-->
				<?php  endif; ?>
				<div id="navigation">
					<div class="navbar navbar-default" role="navigation">
						<div class="container">
							<div class="row">
								<div class="flex">
									<div class="navbar-header flex" style="width: 100%; align-items: center; justify-content: space-between;">
										<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
											<span class="sr-only">Toggle navigation</span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
										</button>

										<div id="brand">
				              <a href="<?php echo $this->params->get('logo_link')   ?>">
												<img style="width:<?php  echo $this->params->get('logo_width') ?>px; height:<?php echo $this->params->get('logo_height') ?>px; " src="<?php  echo $this->params->get('logo_file')   ?>" alt="Logo de la SFGM-TC" />
			                </a>
				            </div>

										<?php  if ($this->countModules('calltoaction')) : ?>
											<nav class="calltoaction flex" style="flex: 1 0 auto; justify-Content: flex-end;" role="navigation">
												<jdoc:include type="modules" name="calltoaction" style="none" />
											</nav>
										<?php endif; ?>
									</div>

									<div class="navbar-menu" style="margin-top: 5px;">
										<div class="navbar-collapse collapse" style="padding-left: 0;">
										<?php  if ($this->countModules('navigation')) : ?>
					            <nav class="navigation" role="navigation">
												<jdoc:include type="modules" name="navigation" style="none" />
				              </nav>
					          <?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
			<div class="clearfix"></div>
			<!--Navigation-->

			<section style="-webkit-user-select: text; -moz-user-select: text; -ms-user-select: text; user-select: text; !important;">

				<?php  if($this->countModules('fullwidth')) : ?>
				<!--fullwidth-->
				<div id="fullwidth">
					<?php  if ($this->countModules('slogan')) : ?>
					<div class="slogan">
						<jdoc:include type="modules" name="slogan" style="none" />
					</div>
					<?php endif; ?>
					<jdoc:include type="modules" name="fullwidth" style="none"/>
				</div>
				<!--fullwidth-->
				<?php  endif; ?>

				<?php  if($this->countModules('feature')) : ?>
				<!--Feature-->
				<div id="feature">
					<div class="container">
						<div class="row">
							<jdoc:include type="modules" name="feature" style="block" />
						</div>
					</div>
				</div>
				<!--Feature-->
				<?php  endif; ?>

				<?php  if($this->countModules('breadcrumbs')) : ?>
				<!--Breadcrumbs-->
				<div id="breadcrumbs">
					<div class="container">
						<jdoc:include type="modules" name="breadcrumbs" style="raw" />
					</div>
				</div>
				<!--Breadcrumbs-->
				<?php  endif; ?>

				<!-- Content -->
				<div id="main-content">
					<div class="container">
						<div id="main" class="row show-grid">

							<?php  if($this->countModules('left')) : ?>
							<!-- Left -->
							<!-- <div id="sidebar" class="col-md-<?php  echo $leftcolgrid; ?> visible-md-block visible-lg-block"> -->
							<div id="sidebar" class="col-xs-12 col-md-3">
								<jdoc:include type="modules" name="left" style="block" />
							</div>
							<!-- Left -->
							<?php  endif; ?>

							<!-- Component -->
							<!-- <div id="container" class="col-md-<?php  echo (12-$leftcolgrid-$rightcolgrid); ?>"> -->
						<?php  if($this->countModules('left')) : ?>
							<div id="container" class="col-xs-12 col-md-9">
						<?php else : ?>
							<div id="container" class="col-xs-12">
						<?php endif; ?>

								<?php  if($this->countModules('content-top')) : ?>
								<!-- Content-top Module Position -->
								<div id="content-top">
									<jdoc:include type="modules" name="content-top" style="block" />
								</div>
								<!-- Content-top Module Position -->
								<?php  endif; ?>

								<!-- Front page show or hide -->
								<?php
								$app = JFactory::getApplication();
								$menu = $app->getMenu();

								if ($frontpageshow) {
								// show on all pages
								?>
								<div id="main-box">
									<jdoc:include type="message" />
									<jdoc:include type="component" />
								</div>

								<?php
								} else {
									if ($menu->getActive() !== $menu->getDefault()) {
									// show on all pages but the default page
									?>
									<div id="main-box">
										<jdoc:include type="message" />
										<jdoc:include type="component" />
									</div>
								<?php
								 	}
						 		}
								?>
								<!-- Front page show or hide -->

								<?php  if(($this->countModules('content-bottom-1')) || ($this->countModules('content-bottom-2'))) : ?>
								<!-- Below Content Module Position -->
								<div class="row">
								<?php  endif; ?>
									<?php  if($this->countModules('content-bottom-1')) : ?>
									<div id="content-bottom-1" class="col-md-6">
										<jdoc:include type="modules" name="content-bottom-1" style="none" />
									</div>
									<?php  endif; ?>
									<?php  if($this->countModules('content-bottom-2')) : ?>
									<div id="content-bottom-2" class="col-md-6">
										<jdoc:include type="modules" name="content-bottom-2" style="none" />
									</div>
									<?php  endif; ?>
									<?php  if($this->countModules('content-bottom-3')) : ?>
									<div id="content-bottom-3">
										<jdoc:include type="modules" name="content-bottom-3" style="block" />
									</div>
									<?php  endif; ?>
								<?php  if(($this->countModules('content-bottom-1')) || ($this->countModules('content-bottom-1'))) : ?>
								<!-- Below Content Module Position -->
								</div>
								<?php  endif; ?>

							</div>
							<!-- Component -->

							<?php  if($this->countModules('right')) : ?>
							<!-- Right -->
							<div id="sidebar-2" class="col-sm-<?php  echo $rightcolgrid; ?>">
								<jdoc:include type="modules" name="right" style="block" />
							</div>
							<!-- Right -->
							<?php  endif; ?>
						</div>
					</div>
				</div>
				<!-- Content -->

				<?php  if($this->countModules('showcase')) : ?>
				<!--Showcase-->
				<div id="showcase">
					<jdoc:include type="modules" name="showcase" style="none"/>
				</div>
				<!--Showcase-->
				<?php  endif; ?>

				<?php  if($this->countModules('bottom')) : ?>
				<!-- bottom -->
				<div id="bottom">
					<div class="container">
						<jdoc:include type="modules" name="bottom" style="none" />
					</div>
				</div>
				<!-- bottom -->
				<?php  endif; ?>

				<?php  if($this->countModules('footer')) : ?>
				<!-- footer -->
				<div id="footer">
					<div class="container">
						<div class="row">
							<jdoc:include type="modules" name="footer" style="raw" />
						</div>
					</div>
				</div>
				<!-- footer -->
				<?php  endif; ?>

				<!--<div id="push"></div>-->

				<?php  if($this->countModules('copy')) : ?>
				<!-- copy -->
				<div id="copy" class="well">
					<div class="container">
						<div class="row">
							<jdoc:include type="modules" name="copy" style="block" />
						</div>
					</div>
				</div>
				<!-- copy -->
				<?php  endif; ?>

				<?php  if($this->countModules('panelnav')): ?>
				<!-- panelnav -->
				<div id="panelnav">
				    <jdoc:include type="modules" name="panelnav" style="none" />
				</div>
				<!-- panelnav -->
				<?php endif; ?>

				<a href="#" class="back-to-top">Back to Top</a>

				<jdoc:include type="modules" name="debug" />

			</section>

		</div>
		<!-- #wrap -->

		<?php if($layout == 'boxed') : ?>
		</div>
		<?php endif; ?>

		<!-- JS -->
		<script type="text/javascript" src="<?php echo $tpath; ?>/js/template.min.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('map.centrescarte').imageMapResize();
				$('.item-140 a').removeAttr('data-toggle');
				$('.item-136 a').removeAttr('data-toggle');
			});
		</script>
		<!-- JS -->
	</body>
</html>
