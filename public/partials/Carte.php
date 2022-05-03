<?php



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
        ob_start();?>
<style>
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
    grid-gap: 20px;
}

.card {
    display: grid;
    grid-template-rows: max-content 200px 1fr;
}

.card img {
    object-fit: cover;
    width: 100%;
    height: 100%;
}
</style>
<?php    
        $code_html = '<figure class="card-data">
			  <figcaption><i class="ion-ios-rose-outline"></i>
             
				<h3>Cliquez sur votre région pour découvrir les chiffres</h3>
                				
			  </figcaption>';
        $code_html .= '<div class="cards">';
        $code_html .= '<div class="contenuDeLaCarte card"></div>';
        $code_html .= '</div>';

                
    
            
        $output = ob_get_clean();
        return $code_html . $output;
    }
}