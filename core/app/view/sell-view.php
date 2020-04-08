<!DOCTYPE html>
<html lang="en">
<head>
  <!-- <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="js/venta.js"></script> -->
  <link rel="stylesheet" href="print.css" type="text/css" media="print" />
</head>
<div class="row">
	<div class="col-md-12">
	<h1>Venta</h1>
	<p><b>Buscar producto por nombre o por codigo:</b></p>
		<form id="searchp">
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" name="view" value="sell">
				<input type="text" id="product_code" name="product" class="form-control">
			</div>
			<div class="col-md-3">
			<button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Buscar</button>
			</div>
		</div>
		</form>
	</div>
<div id="show_search_results"></div>
<script>
//jQuery.noConflict();

$(document).ready(function(){
	$("#searchp").on("submit",function(e){
		e.preventDefault();
		
		$.get("./?action=searchproduct",$("#searchp").serialize(),function(data){
			$("#show_search_results").html(data);
		});
		$("#product_code").val("");

	});
	});

$(document).ready(function(){
    $("#product_code").keydown(function(e){
        if(e.which==17 || e.which==74){
            e.preventDefault();
        }else{
            console.log(e.which);
        }
    })
});
</script>

<?php if(isset($_SESSION["errors"])):?>
<h2>Errores</h2>
<p></p>
<table class="table table-bordered table-hover">
<tr class="danger">
	<th>Codigo</th>
	<th>Producto</th>
	<th>Mensaje</th>
</tr>
<?php foreach ($_SESSION["errors"]  as $error):
$product = ProductData::getById($error["product_id"]);
?>
<tr class="danger">
	<td><?php echo $product->barcode; ?></td>
	<td><?php echo $product->name; ?></td>
	<td><b><?php echo $error["message"]; ?></b></td>
</tr>

<?php endforeach; ?>
</table>
<?php
unset($_SESSION["errors"]);
 endif; ?>


<!--- Carrito de compras :) -->
<?php if(isset($_SESSION["cart"])):
$total = 0;
?>
<h2>Lista de venta</h2>
<table class="table table-bordered table-hover">
<thead>
	<th style="width:30px;">Codigo</th>
	<th style="width:30px;">Cantidad</th>
	<th style="width:30px;">Unidad</th>
	<th>Producto</th>
	<th style="width:30px;">Precio Unitario</th>
	<th style="width:30px;">Precio Total</th>
	<th ></th>
</thead>
<?php foreach($_SESSION["cart"] as $p):
$product = ProductData::getById($p["product_id"]);
?>
<tr >
	<td><?php echo $product->barcode; ?></td>
	<td ><?php echo $p["q"]; ?></td>
	<td><?php echo $product->unit; ?></td>
	<td><?php echo $product->name; ?></td>
	<td><b>$ <?php echo number_format($product->price_out); ?></b></td>
	<td><b>$ <?php  $pt = $product->price_out*$p["q"]; $total +=$pt; echo number_format($pt); ?></b></td>
	<td style="width:30px;"><a href="index.php?view=clearcart&product_id=<?php echo $product->id; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a></td>
</tr>

<?php endforeach; ?>
</table>
<form method="post" class="form-horizontal" id="processsell" action="index.php?view=processsell">
<h2>Resumen</h2>
<div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Cliente</label>
    <div class="col-lg-10">
    <?php	$clients = PersonData::getClients();    ?>
    <select name="client_id" class="form-control">
    <option value="">-- NINGUNO --</option>
    <?php foreach($clients as $client):?>
    	<option value="<?php echo $client->id;?>"><?php echo $client->name." ".$client->lastname;?></option>
    <?php endforeach;?>
    	</select>
    </div>
  </div>
<div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Descuento</label>
    <div class="col-lg-10">
      <input type="text" name="discount" class="form-control" required value="0" id="discount" placeholder="Descuento">
    </div>
  </div>
 <div class="form-group">
    <label for="inputEmail1" class="col-lg-2 control-label">Efectivo</label>
    <div class="col-lg-10">
      <input type="text" name="money" min="1" max="99999999" required class="form-control" id="money" placeholder="Efectivo">
    </div>
  </div>
  <div class="form-group">
	<label for="inputEmail1" class="col-lg-2 control-label">Imei</label>
	<div class="col-lg-10">
		<input type="text" name="number" min="1" max="99999999" required class="form-control" id="number" placeholder="Imei 1 y 2" >
	</div>
  </div>
      <input type="hidden" name="total" value="<?php echo $total; ?>" class="form-control" placeholder="Total">

  <div class="row">
<div class="col-md-6 col-md-offset-6">
<table class="table table-bordered">
<tr>
	<td><p>Subtotal</p></td>
	<td><p><b>$ <?php echo number_format($total*.84); ?></b></p></td>
</tr>
<tr>
	<td><p>IVA</p></td>
	<td><p><b>$ <?php echo number_format($total*.16); ?></b></p></td>
</tr>
<tr>
	<td><p>Total</p></td>
	<td><p><b>$ <?php echo number_format($total); ?></b></p></td>
</tr>

</table>
  <div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
          <input name="is_oficial" type="hidden" value="1">
        </label>
      </div>
    </div>
  </div>
<div class="form-group">
    <div class="col-lg-offset-2 col-lg-10">
      <div class="checkbox">
        <label>
		<a href="index.php?view=clearcart" class="btn btn-lg btn-danger"><i class="glyphicon glyphicon-remove"></i> Cancelar</a>
        <button onclick="window.print();" class="btn btn-lg btn-primary" id="btn" ><i class="glyphicon glyphicon-usd"></i><i class="glyphicon glyphicon-usd"></i> Finalizar Venta</button>
				<style type="text/css">
		@media print {
			#printbtn {
				display :  none;
			}
		}
		</style>
		<!-- <input id ="printbtn" type="button" value="Print this page" onclick="window.print();" >
		</label>
		<input id="printpagebutton" type="button" value="Print this page" onclick="printpage()"/>` -->
		<!-- <script>
			let product = <?php //echo $product;?>
		</script> -->
      </div>
    </div>
  </div>
</form>
<script>
	$("#processsell").submit(function(e){
		discount = $("#discount").val();
		money = $("#money").val();
		if(money<(<?php echo $total;?>-discount)){
			alert("No se puede efectuar la operacion");
			e.preventDefault();
		}else{
			if(discount==""){ discount=0;}
			go = confirm("Cambio: $"+(money-(<?php echo $total;?>-discount ) ) );
			if(go){}
				else{e.preventDefault();}
		}
	});
</script>
<script type="text/javascript">
    function printpage() {
        //Get the print button and put it into a variable
        var printButton = document.getElementById("printpagebutton");
        //Set the print button visibility to 'hidden' 
        printButton.style.visibility = 'hidden';
        //Print the page content
        window.print()
        //Set the print button to 'visible' again 
        //[Delete this line if you want it to stay hidden after printing]
        printButton.style.visibility = 'visible';
    }
</script>
</div>
</div>

<br><br><br><br><br>
<?php endif; ?>

</div>