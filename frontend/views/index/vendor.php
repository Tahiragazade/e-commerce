<!-- Vendor Start -->
<div class="container-fluid py-5">
	<div class="row px-xl-5">
		<div class="col">
			<div class="owl-carousel vendor-carousel">
                <?php foreach($vendors as $vendor){?>
				<div class="bg-light p-4">
					<img src="<?=$vendor->photo?>" alt="<?=$vendor->name?>">
				</div>
                <?php }?>
			</div>
		</div>
	</div>
</div>
<!-- Vendor End -->