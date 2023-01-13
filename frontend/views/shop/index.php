<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
		<?= $this->render('sidebar'); ?>

		<?= $this->render('products', [
			'products' => $products,
			'pages' => $pages,
            ]); ?>
    </div>
</div>
<!-- Shop End -->
