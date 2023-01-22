<?php
use yii\widgets\ActiveForm;
?>
<!-- Checkout Start -->
<div class="container-fluid">
	<div class="row px-xl-5">
		<div class="col-lg-8">
			<h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
			<?php $form = ActiveForm::begin(['action' => ['order/create'],'options' => ['method' => 'post']]) ?>
            <?= $form->field($model1,'total_price')->hiddenInput(['value'=>$total_price])->label(false)?>
            <?= $form->field($model1,'shipping_price')->hiddenInput(['value'=>$shipping_price])->label(false)?>
            <?= $form->field($model1,'payment_type')->hiddenInput(['value'=>1])->label(false)?>
            <?= $form->field($model1,'country_id')->hiddenInput(['value'=>1])->label(false)?>

            <div class="bg-light p-30 mb-5">
				<div class="row">
					<div class="col-md-6 form-group">
						<label>First Name</label>
                        <?= $form->field($model,'first_name')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>
					<div class="col-md-6 form-group">
						<label>Last Name</label>
						<?= $form->field($model,'last_name')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>
					<div class="col-md-6 form-group">
						<label>E-mail</label>
						<?= $form->field($model,'email')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>
					<div class="col-md-6 form-group">
						<label>Mobile No</label>
						<?= $form->field($model,'phone')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>
					<div class="col-md-6 form-group">
						<label>Address Line 1</label>
						<?= $form->field($model,'address_1')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>
					<div class="col-md-6 form-group">
						<label>Address Line 2</label>
						<?= $form->field($model,'address_2')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>
					<div class="col-md-6 form-group">
						<label>Country</label>
						<select class="custom-select">
							<option selected>United States</option>
							<option>Afghanistan</option>
							<option>Albania</option>
							<option>Algeria</option>
						</select>
					</div>
					<div class="col-md-6 form-group">
						<label>City</label>
						<?= $form->field($model,'city')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>
					<div class="col-md-6 form-group">
						<label>State</label>
						<?= $form->field($model,'state')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>
					<div class="col-md-6 form-group">
						<label>ZIP Code</label>
						<?= $form->field($model,'zip_code')->textInput(['class'=>'form-control','value'=>''])->label(false);?>
					</div>

                    <?php if(Yii::$app->user->isGuest){?>
					<div class="col-md-12 form-group">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="newaccount">
							<label class="custom-control-label" for="newaccount">Create an account</label>
						</div>
					</div>
                    <?php }?>
					<div class="col-md-12">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="shipto">
							<label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">Ship to different address</label>
						</div>
					</div>
				</div>
			</div>
			<div class="collapse mb-5" id="shipping-address">
				<h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Shipping Address</span></h5>
				<div class="bg-light p-30">
					<div class="row">
						<div class="col-md-6 form-group">
							<label>First Name</label>
							<input class="form-control" type="text" placeholder="John">
						</div>
						<div class="col-md-6 form-group">
							<label>Last Name</label>
							<input class="form-control" type="text" placeholder="Doe">
						</div>
						<div class="col-md-6 form-group">
							<label>E-mail</label>
							<input class="form-control" type="text" placeholder="example@email.com">
						</div>
						<div class="col-md-6 form-group">
							<label>Mobile No</label>
							<input class="form-control" type="text" placeholder="+123 456 789">
						</div>
						<div class="col-md-6 form-group">
							<label>Address Line 1</label>
							<input class="form-control" type="text" placeholder="123 Street">
						</div>
						<div class="col-md-6 form-group">
							<label>Address Line 2</label>
							<input class="form-control" type="text" placeholder="123 Street">
						</div>
						<div class="col-md-6 form-group">
							<label>Country</label>
							<select class="custom-select">
								<option selected>United States</option>
								<option>Afghanistan</option>
								<option>Albania</option>
								<option>Algeria</option>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<label>City</label>
							<input class="form-control" type="text" placeholder="New York">
						</div>
						<div class="col-md-6 form-group">
							<label>State</label>
							<input class="form-control" type="text" placeholder="New York">
						</div>
						<div class="col-md-6 form-group">
							<label>ZIP Code</label>
							<input class="form-control" type="text" placeholder="123">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
			<div class="bg-light p-30 mb-5">
				<div class="border-bottom">
					<h6 class="mb-3">Products</h6>
                    <?php foreach($products as $product){?>
					<div class="d-flex justify-content-between">
						<p><?=$product->product->title?></p>
						<p><?=$product->count?></p>
						<p>$<?=$product->product->price*$product->count?></p>
					</div>
                    <?php }?>

				</div>
				<div class="border-bottom pt-3 pb-2">
					<div class="d-flex justify-content-between mb-3">
						<h6>Subtotal</h6>
						<h6>$<?=$total_price?></h6>
					</div>
					<div class="d-flex justify-content-between">
						<h6 class="font-weight-medium">Shipping</h6>
						<h6 class="font-weight-medium">$<?=$shipping_price?></h6>
					</div>
				</div>
				<div class="pt-2">
					<div class="d-flex justify-content-between mt-2">
						<h5>Total</h5>
						<h5>$<?=$total_price+$shipping_price?></h5>
					</div>
				</div>
			</div>
			<div class="mb-5">
				<h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
				<div class="bg-light p-30">
					<div class="form-group">
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" name="payment" id="paypal">
							<label class="custom-control-label" for="paypal">Paypal</label>
						</div>
					</div>
					<div class="form-group">
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" name="payment" id="directcheck">
							<label class="custom-control-label" for="directcheck">Direct Check</label>
						</div>
					</div>
					<div class="form-group mb-4">
						<div class="custom-control custom-radio">
							<input type="radio" class="custom-control-input" name="payment" id="banktransfer">
							<label class="custom-control-label" for="banktransfer">Bank Transfer</label>
						</div>
					</div>
					<button class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
				</div>
			</div>
		</div>
		<?php ActiveForm::end()?>
	</div>
</div>
<!-- Checkout End -->