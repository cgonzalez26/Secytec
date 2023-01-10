<style>
#divNavegacion{
	position: relative;
	background:#52658C;
	height:auto;
	overflow: hidden;
	min-height: 20%;
	padding: 10px 20px 10px 20px;
}
.g-grid {
	/*max-width: 1080px;
	padding:20px;*/	
	/*margin-left: auto;
	margin-right: auto;*/
}
.l-padded-v-5{
	padding-top:20px;
	padding-bottom:20px;
	margin: 0;
	padding: 0;
}
.g-cell{
	font-size: 13px;
	font-weight: 400;
	line-height: 18px;
	color: #666;
	-webkit-font-smoothing: subpixel-antialiased;
	/*padding-left: 5px;
	padding-right: 5px;*/
	width:240px;
	text-align:left;
}
.g-cell-12-12 {
	width: 25%;
	list-style:none;
}
.footer-links a {
	color: #ccc!important;
	font-weight: 300;
}
.footer-text-heading-primary {
	color: #FFF!important;
	text-transform: uppercase;
	font-weight: 500;
	margin-bottom: 6px;
	font-size: 18px;
}
.footer-text-heading-primary a{
	color: #FFF!important;
	text-transform: uppercase;
	font-weight: 500;
	margin-bottom: 6px;
	font-size: 18px;
}
.footer-text-heading-primary a:hover{
	text-decoration:underline;
}

div.wp_bannerize div {
	padding:5px 5px 10px 10px;
	float:left;
}

#main-footer{
	position: relative;
	background-color:#333;
	width:100%;
	/*height: auto;
	position: absolute;*/
}
#main-footer #divLogoMinisterio{
	width:50%;
	float:left;
	padding-top:20px;
	padding-left:20px;
	background-color:#333;
	position: relative;
}
#main-footer #divSocial{
	width:50%;
	float:left;
	padding-top:20px;
	padding-right:40px;
	text-align:right;
	background-color:#333;
	position: relative;
	height:100%;
}
@media only screen and (max-width: 520px){
	#divNavegacion{
		height:20em;
	}
	#main-footer #divLogoMinisterio{
		width:100%;
	}
	#main-footer #divSocial{
		width:100%;
	}
	.g-cell-12-12{
		width:50%;
	}
}

@media only screen and (max-width: 420px){
	#divNavegacion{
		height:30em;
	}
	.g-cell-12-12{
		width:100%;
	}
}
</style>

<script defer="" src="wp-content/plugins/flexslider-master/jquery.flexslider.js"></script>
<script src="wp-includes/js/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="wp-content/plugins/flexslider-master/flexslider.css" type="text/css" media="screen">
<script src="wp-content/plugins/flexslider-master/demo/js/modernizr.js"></script> 
<script>
$(window).load(function() {
	  $('#main-slider').flexslider({
	    animation: "slide",
	    animationLoop: false,
	    controlNav: false,
	    slideshow: false,
	    itemWidth: 290,
	    itemMargin: 15
        
	  });
	});
</script>
	<div id="divBanners" style="background:#E6E7E8;text-align:center"> <!-- #banners -->	
	   <div class="site-banner" style="width:100%;padding:5px 0px 5px 0px">	
	   <?php
		//if(function_exists( 'wp_bannerize' )){			
			//wp_bannerize( 'group=inicio' ); //} ?>	
	     <section class="slider">
		 <div id="main-slider" class="flexslider carousel">
			 <ul class="slides">		   
			    <?php
			    global $wpdb;
			    	$q    = "SELECT * FROM wp_bannerize WHERE wp_bannerize.group='inicio' ";
					$rows = $wpdb->get_results( $q ); 
					foreach ( $rows as $row ) {
						echo "<li>
							<a href='".$row->url."' target='_black'>
					      		<img src='".$row->filename."' />
					      	</a>	
					    </li>";
					}				
			    ?>
			  </ul>
		  </div>
          </section>	 
	  </div>	  
	</div>

	<div id="divNavegacion" style="height:180px;background:#52658C;text-align:center"> <!-- #links -->
    <div class="g-grid">
        <div class="l-padded-v-5 g-group hide-small hide-medium">
            <ul class="footer-links g-cell g-cell-12-12 g-cell-md-6-12 g-cell-lg-3-12" style="float:left">
                <h6 class="footer-text-heading-primary text-body-medium">Principal</h6>
                 <li>
				        <a href="http://localhost/SecyTec/">Inicio</a>
				</li>               
                <li>
				        <a href="http://localhost/SecyTec/?page_id=9">Institucional</a>
				</li>            
                <li>
				        <a href="http://localhost/SecyTec/?page_id=13">Autoridades</a>
				</li>              
                <li>
				        <a href="http://localhost/SecyTec/?page_id=94">Contacto</a>
				</li>         
                                                      
            </ul>
            <ul class="footer-links g-cell g-cell-12-12 g-cell-md-6-12 g-cell-lg-3-12" style="float:left">
                <h6 class="footer-text-heading-primary text-body-medium">
                	<a href="http://localhost/SecyTec/?page_id=35&eje=1">Vocacion Cientifica</a></h6>
                 <li>
				        <a href="http://localhost/SecyTec/?page_id=194&eje=1">Feria de Ciencia</a>
				</li>               
                <li>
				        <a href="http://localhost/SecyTec/?page_id=196&eje=1">Olimpiadas</a>
				</li>            
                <li>
				        <a href="http://localhost/SecyTec/?page_id=198&eje=1">Cursos</a>
				</li>              
                <li>
				        <a href="http://localhost/SecyTec/?page_id=200&eje=1">Divulgacion Cientifica</a>
				</li>
                <li>
				        <a href="http://localhost/SecyTec/?page_id=202&eje=1">Noticias</a>
				</li>                                            
            </ul>
             <ul class="footer-links g-cell g-cell-12-12 g-cell-md-6-12 g-cell-lg-3-12" style="float:left">
                <h6 class="footer-text-heading-primary text-body-medium">
                <a href="http://localhost/SecyTec/?page_id=50&eje=2">Tecnologia e Inovacion</a></h6>
                <li>
				        <a href="http://localhost/SecyTec/?page_id=159&eje=2">Asesoramiento y Asistencia Técnica</a>
				</li>               
                <li>
				        <a href="http://localhost/SecyTec/?page_id=213&eje=2">Casos de Exitos</a>
				</li>            
                <li>
				        <a href="http://localhost/SecyTec/?page_id=217&eje=2">Acciones</a>
				</li>              
                <li>
				        <a href="http://localhost/SecyTec/?page_id=140&eje=2">Unidades de Vinculacion Cientifica</a>
				</li>
                <li>
				        <a href="http://localhost/SecyTec/?page_id=219&eje=2">Noticias</a>
				</li>                                                                         
            </ul>
            <ul class="footer-links g-cell g-cell-12-12 g-cell-md-6-12 g-cell-lg-3-12" style="float:left">
                <h6 class="footer-text-heading-primary text-body-medium">
                <a href="http://localhost/SecyTec/?page_id=52&eje=3">Desarrollo Cientifico</a></h6>
                <li>
				        <a href="http://localhost/SecyTec/?page_id=225&eje=3">Astronomia</a>
				</li>               
                <li>
				        <a href="http://localhost/SecyTec/?page_id=227&eje=3">Noticias</a>
				</li>                                                                    
            </ul>
        </div>
        
    	</div>
	</div>

	<footer id="main-footer" class="main-footer" role="contentinfo">
		<?php //get_sidebar( 'main' ); ?>

		<!--<div class="site-info" >
			<?php //do_action( 'twentythirteen_credits' );cristian ?>
			  <a href="<?php //echo esc_url( __( 'http://wordpress.org/', 'twentythirteen' ) ); ?>" title="<?php //esc_attr_e( 'Semantic Personal Publishing Platform', 'twentythirteen' ); ?>"><?php //printf( __( 'Proudly powered by %s', 'twentythirteen' ), 'WordPress' ); ?></a>-->
			
			<div id="divLogoMinisterio">
    			<a href="http://www.edusalta.gov.ar" target="_blank">
    			<img src="<?php echo esc_url( home_url( '/' ) )."/wp-content/uploads/2014/10/logo_MECyT.png"; ?>" alt="" style="height: auto;max-width: 100%;"/></a>
			</div>
			<div id="divSocial"> <!-- redes sociales-->
				<div style="width:100px;float:right">
				<a href="www.facebook.com" target="_blank">
				<img alt="" src="<?php echo esc_url( home_url( '/' ) )."/wp-content/uploads/2014/11/facebook_logo_detail.gif"; ?>" style="width:90px;height:90px" /></a>
				</div>
				<div style="width:100px;float:right">
				<a href="www.twitter.com" target="_blank">
				<img alt="" src="<?php echo esc_url( home_url( '/' ) )."/wp-content/uploads/2014/11/Twitter_logo_blue.png"; ?>" style="width:90px;height:90px"/></a>
				</div>
			</div>
		
	</footer>
    <?php wp_footer(); ?>
</body>
</html>
