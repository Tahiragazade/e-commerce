<?php

use kartik\range\RangeInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii2mod\rating\StarRating;

?>
<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
	<div class="row px-xl-5">
		<div class="col-lg-5 mb-30">
			<div id="product-carousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner bg-light">
					<?php
					$images=explode(',',$product->photo);
					foreach($images as $key=> $image){
                        if($key==0){
					?>
					<div class="carousel-item active">
						<img class="w-100 h-100" src="<?=$image?>" alt="Image">
					</div>
                        <?php }else{ ?>
                            <div class="carousel-item">
                            <img class="w-100 h-100" src="<?=$image?>" alt="Image">
                        </div>
					<?php }} ?>
				</div>
				<a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
					<i class="fa fa-2x fa-angle-left text-dark"></i>
				</a>
				<a class="carousel-control-next" href="#product-carousel" data-slide="next">
					<i class="fa fa-2x fa-angle-right text-dark"></i>
				</a>
			</div>
		</div>

		<div class="col-lg-7 h-auto mb-30">
			<div class="h-100 bg-light p-30">
				<h3><?=$product->{'title_'.Yii::$app->language}?></h3>
				<div class="d-flex mb-3">
					<div class="text-primary mr-2">
						<small class="fas fa-star"></small>
						<small class="fas fa-star"></small>
						<small class="fas fa-star"></small>
						<small class="fas fa-star-half-alt"></small>
						<small class="far fa-star"></small>
					</div>
					<small class="pt-1">(99 Reviews)</small>
				</div>
				<h3 class="font-weight-semi-bold mb-4">$<?=$product->price?></h3>
				<p class="mb-4"><?=$product->{'small_description_'.Yii::$app->language}?></p>
                <?php $form = ActiveForm::begin([
	                'fieldConfig' => [
		                'template' => "{input}",
		                'options' => ['tag' => false], // remove wrapper tag
	                ],
	                'action' =>['cart/create'],
                    'method' => 'post',
	                'options' => [],
                ]) ?>
               <?= $form->field($model, 'product_id')->hiddenInput(['value'=> $product->id])->label(false);?>

                <div class="d-flex mb-3">
					<strong class="text-dark mr-3">Sizes:</strong>
						<div class="custom-control custom-radio custom-control-inline">
                            <?= $form->field($model, 'size_id')->radioList( $size_map,['labelOptions'=>['class'=>'custom-control-input']] )->label(false);?>
						</div>

				</div>
				<div class="d-flex mb-4">
					<strong class="text-dark mr-3">Colors:</strong>
						<div class="custom-control custom-radio custom-control-inline">
							<?= $form->field($model, 'color_id')->radioList( $color_map,['labelOptions'=>['class'=>'custom-control-input']] )->label(false);?>
						</div>
				</div>
				<div class="d-flex align-items-center mb-4 pt-2">
					<div class="input-group quantity mr-3" style="width: 130px;">
						<div class="input-group-btn">
							<button type="button" class="btn btn-primary btn-minus">
								<i class="fa fa-minus"></i>
							</button>
						</div>
                            <?= $form->field($model, 'count')->textInput(['class'=>'form-control bg-secondary border-0 text-center','value' =>1,'tag' => false])->label(false) ?>

						<div class="input-group-btn">
							<button type="button" class="btn btn-primary btn-plus">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
						Cart</button>
				</div>
				<?php ActiveForm::end() ?>
				<div class="d-flex pt-2">
					<strong class="text-dark mr-2">Share on:</strong>
					<div class="d-inline-flex">
						<a class="text-dark px-2" href="">
							<i class="fab fa-facebook-f"></i>
						</a>
						<a class="text-dark px-2" href="">
							<i class="fab fa-twitter"></i>
						</a>
						<a class="text-dark px-2" href="">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<a class="text-dark px-2" href="">
							<i class="fab fa-pinterest"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row px-xl-5">
		<div class="col">
			<div class="bg-light p-30">
				<div class="nav nav-tabs mb-4">
					<a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
					<a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
					<a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
				</div>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="tab-pane-1">
						<h4 class="mb-3">Product Description</h4>
						<?=$product->{'description_'.Yii::$app->language}?>
						</div>
					<div class="tab-pane fade" id="tab-pane-2">
						<h4 class="mb-3">Additional Information</h4>
						<?=$product->{'information_'.Yii::$app->language}?>
					</div>
					<div class="tab-pane fade" id="tab-pane-3">
						<div class="row">
							<div class="col-md-6">
								<h4 class="mb-4">1 review for "Product Name"</h4>
                                <?php foreach($comments as $comm){?>
								<div class="media mb-4">
									<img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
									<div class="media-body">
										<h6><?=$comm->name?><small> - <i><?=date('d.m.Y H:i', $comm->created_at)?></i></small></h6>
										<div class="text-primary mb-2">
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star-half-alt"></i>
											<i class="far fa-star"></i>
										</div>
										<p><?=$comm->note?></p>
									</div>
								</div>
                                <?php }?>
							</div>
							<div class="col-md-6">

								<h4 class="mb-4">Leave a review</h4>
								<small>Your email address will not be published. Required fields are marked *</small>
								<div class="d-flex my-3">
									<p class="mb-0 mr-2">Your Rating * :</p>
									<div class="text-primary">
										<i class="far fa-star"></i>
										<i class="far fa-star"></i>
										<i class="far fa-star"></i>
										<i class="far fa-star"></i>
										<i class="far fa-star"></i>
									</div>
								</div>
								<?php $form = ActiveForm::begin(['action' => ['comment/create'],'options' => ['method' => 'post']]) ?>
                                <?=$form->field($comment,'product_id')->hiddenInput(['value'=>$product->id])->label(false)?>
								<?= $form->field($comment, 'star')->radioList( [1=>'',2=>'',3=>'',4=>'',5=>''],['labelOptions'=>['class'=>'custom-control-input']] )->label(false);?>

                                <div class="form-group">
										<label for="message">Your Review *</label>
                                        <?=$form->field($comment,'note')->textarea(['class'=>'form-control','cols'=>30,'rows'=>5])->label(false)?>
									</div>
									<div class="form-group">
										<label for="name">Your Name *</label>
										<?=$form->field($comment,'name')->textInput(['class'=>'form-control'])->label(false)?>
									</div>
									<div class="form-group">
										<label for="email">Your Email *</label>
										<?=$form->field($comment,'email')->textInput(['class'=>'form-control'])->label(false)?>
									</div>
									<div class="form-group mb-0">
										<?= Html::submitButton(Yii::t('app', 'Leave Your Review'), ['class' => 'btn btn-primary px-3']) ?>
									</div>
								<?php ActiveForm::end()?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Shop Detail End -->
<?= $this->render('you_like');?>
