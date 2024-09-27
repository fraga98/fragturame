<!--Al usar el extract puedo acceder a la claves del array y usarla como una variable-->
<?php
//Head
cargarArchivo('views/templates/head.php');
?>
</head>
<body>
	<div class="container-fluid">
	    <div class="row vh-100">
	    	<!--Aside-->
	        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2 aside">
	        	<?php cargarArchivo('views/templates/aside.php'); ?>
	       	</div>
	       	<!--Body-->
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
				<section class="row ms-1 me-1">
					<h4 class="pt-4 pb-4"><?php echo $titulo ?></h4>
				</section>
				<?php cargarArchivo("views/$vista"); ?>
			</div>
	    </div>
	</div>
</body>
</html>
