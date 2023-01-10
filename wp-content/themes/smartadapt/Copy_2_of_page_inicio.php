<!--?php /* Template Name: page_inicio */ ?-->
<?php
get_header('inicio');
?>

<div id="contenido" style="background:#7190C9;height:100%" >
<center>
	<div id="" style="background:#7190C9;width:90%;height:580px;padding:10px;">
		<div style="background:#7190C9;width:100%;height:250px;padding-bottom:10px">
			<?php echo do_shortcode('[advps-slideshow optset="1"]');?>
		</div>
		<div style="background:#7190C9;width:80%;height:290px;margin-top:10px">
			<div style="background:#FFF;padding:10px;width:32%;height:290px;float:left;">
				<center>
				    <img src="./wp-includes/images/no_image.gif" alt="" border="1" style="height:80px;width:100%;" /><br />
				    Vocacion Cientifica<br />
				    <div style="font-size:10pt;text-align: justify;height:90px">Introducimos conocimiento cientifico y tecnologico en todos los niveles educativos 
				    de la Provincia de Salta</div><br />
				    <a href="<?php echo esc_url( home_url( '/' ) )."?page_id=35&eje=1"; ?>"
							 title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
							 rel="home"
							 class="menu-eje1" style="width:100%">Participa</a>
				 </center>
			</div>
			<div style="width:2%;height:270px;float:left;"></div>
			<div style="background:#FFF;padding:10px;width:32%;height:290px;float:left;">
				<center>
					<img src="./wp-includes/images/no_image.gif"  alt="" border="1" style="height:80px;width:100%;" /><br />
					Tecnologia e Inovacion<br />
					<div style="font-size:10pt;text-align: justify;height:90px">Favorecemos la transferencia y la innovacion tecnologica, articulando el sistema
					 cientifico y tecnologico y distintos sectores de la sociedad</div><br />
				    <a href="<?php echo esc_url( home_url( '/' ) )."?page_id=50&eje=2"; ?>"
						 title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
						 rel="home"
						 class="menu-eje2" style="width:100%">Colabora</a>
				</center>
			</div>
			<div style="width:2%;height:270px;float:left;"></div>
			<div style="background:#FFF;padding:10px;width:32%;height:290px;float:right;">
				<center>
					<img src="./wp-includes/images/no_image.gif"  alt="" border="1" style="height:80px;width:100%;" /><br />
					Desarrollo Cientifico<br />
					<div style="font-size:10pt;text-align: justify;height:90px">Impulsamos todas las iniciativas que fomenten el desarrollo cientifico en toda la provincia 
					de Salta y la Region</div><br />
					<a href="<?php echo esc_url( home_url( '/' ) )."?page_id=52&eje=3"; ?>"
						 title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
						 rel="home"
						 class="menu-eje3" style="width:100%">Enterate</a>
				</center>
			</div>
		</div>
	</div>
</center>
</div>
<?php get_footer('inicio'); ?>

