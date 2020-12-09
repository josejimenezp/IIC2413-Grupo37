<body>
	<div class="container">
		<h1>Mensaje Enviado!</h1>
	</div>
	<div class="container">
		<div class="card">
			<div class="card-body">
				<div class="card-title"><h2><?php echo $nombre_receptant?></h2></div>
				<div class="row">
					<div class="col-3">
						<span>
							<img src="../images/perfil.jpg" alt="AVATAR" height=250px>
						</span>
					</div>
					<div class="col-9">
						<h4><?php echo $mensaje?></h4>
					</div>
				</div>
				<div class="row">
					<div class="col-9"></div>
					<div class="col-3">
					<h6><?php $fecha?></h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
