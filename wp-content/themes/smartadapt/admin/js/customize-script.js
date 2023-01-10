jQuery(document).ready(function ($) {


	$(".smartadapt_theme_options_smartadapt_layout_width").noUiSlider({

		range:[1000, 1280], slide:triggerChange, start:$("#smartadapt_theme_options_smartadapt_layout_width").val(), handles:1, step: 1, serialization:{
			to:$("#smartadapt_theme_options_smartadapt_layout_width"),  resolution: 1
		}

	});
});

function triggerChange() {
	jQuery('input').change();






}