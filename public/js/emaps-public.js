(function( $ ) {
$( window ).load(function() {
		$(document).ready(function() {
			$('#francemap').vectorMap({
				map: 'france_fr',
				backgroundColor: '#ffffff',
					borderColor: '#818181',
					borderOpacity: 0.25,
					borderWidth: 1,
					color: '#f4f3f0',
					enableZoom: true,
					hoverColor: '#c9dfaf',
					hoverOpacity: null,
					normalizeFunction: 'linear',
					scaleColors: ['#b6d6ff', '#005ace'],
					selectedColor: '#c9dfaf',
					selectedRegions: null,
					showTooltip: true,
							
				});
				

						jQuery('#francemap').on('load.jqvmap',
							function(event, map)
							{

							}
						);
						jQuery('#francemap').on('labelShow.jqvmap',
							function(event, label, code)
							{

							}
						);
						jQuery('#francemap').on('regionMouseOver.jqvmap',
							function(event, code, region)
							{
								//console.log(region);
							}
						);
						jQuery('#francemap').bind('regionMouseOut.jqvmap',
							function(event, code, region)
							{

							}
						);
						jQuery('#francemap').on('regionMouseOut.jqvmap',
							function(event, code, region)
							{	
								
							}
						);

						jQuery('#francemap').on('resize.jqvmap',
							function(event, width, height)
							{

							}
						); 
						jQuery('#francemap').on('regionClick.jqvmap', function(event, code, region)
						{
							
							
							$('#field_1_6').addClass("gfield_visibility_visible")
							$('#field_1_6').removeClass("gfield_visibility_hidden");
							$('#input_1_6').append(' '+ region + ' ');							
								$('.remove').click(function(){
									$(this).remove();
								});

									
							
								
						}
						); 	
						

									
			});

		
						

									
			});	


})( jQuery );


