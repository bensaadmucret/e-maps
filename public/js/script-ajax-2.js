(function( $ ) {
    $( window ).load(function() {
            $(document).ready(function() {
                $('#francemap').vectorMap({
                    map: 'france_fr',
                    backgroundColor: '#ffffff',
                        borderColor: '#333333',
                        borderOpacity: 0.25,
                        borderWidth: 1,
                        color: '#6BBF98',
                        enableZoom: true,
                        hoverColor: '#FF8B4C',
                        hoverOpacity: null,
                        normalizeFunction: 'linear',
                        scaleColors: ['#b6d6ff', '#005ace'],
                        selectedColor: '#FF7E38',
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
                                    var res = region.valueOf();
                                    jQuery.post(
                                        ajaxurl,
                                        {
                                            'action': 'mon_action',
                                            'param':res,
                                        },
                                        function(response){
                                                jQuery('.contenuDeLaCarte').html(response);
                                            }
                                    );
                                            
                                    
                                        
                                }
                            ); 	
                            
    
                                        
                });
    
            
                            
    
                                        
                });	
    
    
    })( jQuery );
    
    
    