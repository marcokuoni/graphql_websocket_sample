<?php
defined('C5_EXECUTE') or die("Access Denied.");

echo $this->inc('elements/header.php');
?>
<main>
	<div class="container">
		<div class="row">
			<div id="main-content" class="col-12">
				<?php
				View::element(
					'system_errors',
					array(
						'format' => 'block',
						'error' => isset($error) ? $error : null,
						'success' => isset($success) ? $success : null,
						'message' => isset($message) ? $message : null,
					)
				);
				?>

				<?php
				$a = new Area('Main');
				$a->display($c);
				?>
				<?php echo $innerContent ?>
			</div>
		</div>
	</div>
</main>

<?php
echo $this->inc('elements/footer.php');

