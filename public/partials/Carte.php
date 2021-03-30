<?php

namespace App;

class Carte
{
    public function __construct()
    {
        add_shortcode('carte_partenaires', [ $this, 'carte_partenaires']);
        add_shortcode('liste_partenaires', [ $this, 'liste_partenaires']);
    }

       

    public function carte_partenaires()
    {
        ob_start();
                
    
        $code_html .= '<section class="contenuC">';
            
        $code_html .= '<div id="contenuDeLaCarte" style="width: 780px; height: 620px;"></div>';
                    
        $code_html .= '</section>';
             
             
            
        $output = ob_get_clean();
        return $code_html . $output;
    }
    public function liste_partenaires()
    {
        ob_start();
            
        $code_html = '<figure class="card-data">
			  <figcaption><i class="ion-ios-rose-outline"></i>
				<h3>Cliquez sur votre région pour découvrir les chiffres</h3>				
			  </figcaption>';
                
    
            
        $output = ob_get_clean();
        return $code_html . $output;
    }
}
