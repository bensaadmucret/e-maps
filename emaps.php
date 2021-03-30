<?php

use App\Carte;

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://fr.linkedin.com/in/mohammed-bensaad-developpeur
 * @since             1.0.0
 * @package           Emaps
 *
 * @wordpress-plugin
 * Plugin Name:       emaps
 * Plugin URI:        https://fr.linkedin.com/in/mohammed-bensaad-developpeur
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mohammed Bensaad
 * Author URI:        https://fr.linkedin.com/in/mohammed-bensaad-developpeur
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       emaps
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('EMAPS_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-emaps-activator.php
 */
function activate_emaps()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-emaps-activator.php';
    Emaps_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-emaps-deactivator.php
 */
function deactivate_emaps()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-emaps-deactivator.php';
    Emaps_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_emaps');
register_deactivation_hook(__FILE__, 'deactivate_emaps');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-emaps.php';
require_once(dirname(__FILE__) . '/vendor/autoload.php');

function empas_scripts()
{
    wp_enqueue_script('vmapColor', plugin_dir_url(__FILE__)  . 'public/js/jquery.vmap.colorsFrance.js', array('jquery'), null, false);
    wp_enqueue_script('vmap', plugin_dir_url(__FILE__)  . 'public/js/jquery.vmap.js', array('jquery'), null, false);
    wp_enqueue_script('vmapFrance', plugin_dir_url(__FILE__)  . 'public/js/jquery.vmap.france.js', array('jquery'), null, false);
    wp_enqueue_style('myStyle', plugin_dir_url(__FILE__)  . 'public/css/style.css');
}
add_action('wp_enqueue_scripts', 'empas_scripts');



function add_js_scripts()
{
    wp_enqueue_script('script-ajax', plugin_dir_url(__FILE__)  . 'public/js/script-ajax.js', array('jquery'), '1.0', false);

    // pass Ajax Url to script.js
    wp_localize_script('script-ajax', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'add_js_scripts');
add_action('wp_ajax_mon_action', 'mon_action');
add_action('wp_ajax_nopriv_mon_action', 'mon_action');

function mon_action()
{
    global $post;

    
    $slug = $_POST['param'];
    $slug = stripslashes($slug);
    
    $args = array(
        'category_name' => $slug,
        'posts_per_page' => 10,
        'orderby' => 'title',
        'order'   => 'ASC',
    );
    
    $ajax_query = new WP_Query($args);

    ob_start(); ?>
 
	<?php if ($ajax_query->have_posts()) : while ($ajax_query->have_posts()) : $ajax_query->the_post(); ?>
	
	   		
			<?php if (has_post_thumbnail()) : ?>
			 <a  href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>
			<?php the_post_thumbnail(array(180, 100)); ?>
			</a> 
		    <?php endif; ?>				    
	         <h3 style="color:red; padding:10px;"><?php the_title(); ?></h3>
				<h4> Nombre de Diagnostiqueurs certifiés présent dans cette zone : </h4>					   
			<strong style="color:red; font-size:18px;"><?php	echo get_field("diagnostiqueurs_certifies", get_the_ID()); ?></strong>
			<hr><br>
			<h4> Nombre de vente immobilière présent dans cette zone : </h4>					   
			<strong style="color:red; font-size:18px;"><?php	echo get_field("nombre_de_vente_immobiliere", get_the_ID()); ?></strong>
	
		<?php
    endwhile; ?>		
	
	<?php
    else: echo' <h2>Pas de donnée pour : <span style="color:#FF7E38;">'. $slug . '</span></h2>';
    endif;
    
    ob_end_flush();
    

    die();
}

/**
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_emaps()
{
    $actions = array(
  
   new Carte(),
  
);

    $plugin = new Emaps($actions);
    $plugin->run();
}
run_emaps();
