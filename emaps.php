<?php

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
 * Description:       Plugin créer pour afficher les données en fonction d'une cartographie
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

function create_post_type_centre_vaccination()
{
    register_post_type('centre_vaccination',
        array(
            'labels' => array(
                'name' => __('Centre de vaccination'),
                'singular_name' => __('Centre de vaccination')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'centre_vaccination'),
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', 'author', 'trackbacks', 'tags', 'categories'),
            'taxonomies' => array('category', 'post_tag'),
            'menu_icon' => 'dashicons-admin-multisite',
        )
    );
}
add_action('init', 'create_post_type_centre_vaccination');

// create custom plugin settings menu with two submenus for settings and documentation pages
add_action('admin_menu', 'emaps_plugin_menu');


function emaps_plugin_menu()
{
    //create custom top-level menu
    add_menu_page('emaps', 'emaps', 'administrator', __FILE__, 'emaps_settings_page', 'dashicons-admin-multisite');

    //call register settings function
    add_action('admin_init', 'register_emaps_settings');
}


function register_emaps_settings()
{
    //register our settings
    register_setting('emaps-settings-group', 'emaps_adresse_centre_vaccination');
    register_setting('emaps-settings-group', 'emaps_numero_centre_vaccination');
    
}


function emaps_settings_page()
{
    ?>
    <div class="wrap">
        <h2>Merci de rentrer vos identifiants ACF</h2>
        <form method="post" action="options.php">
            <?php settings_fields('emaps-settings-group'); ?>
            <?php do_settings_sections('emaps-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Adresse centre de vaccination</th>
                    <td><input type="text" name="emaps_adresse_centre_vaccination" value="<?php echo esc_attr(get_option('emaps_adresse_centre_vaccination')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Numero centre de vaccination</th>
                    <td><input type="text" name="emaps_numero_centre_vaccination" value="<?php echo esc_attr(get_option('emaps_numero_centre_vaccination')); ?>" /></td>
                </tr>
            </table>
  
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}






function get_adress()
{
    $adresse = get_option('emaps_adresse_centre_vaccination');
    return $adresse;
  
}

function get_numero()
{
    $numero = get_option('emaps_numero_centre_vaccination');
    return $numero;
}






















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
        'post_type' => 'centre_vaccination',
        'category_name' => $slug,
        'posts_per_page' => 10,
        'orderby' => 'title',
        'order'   => 'ASC',
    );
    
    $ajax_query = new WP_Query($args);
 
   

    ob_start(); ?>


<?php if ($ajax_query->have_posts()) : while ($ajax_query->have_posts()) : $ajax_query->the_post(); ?>


<?php if (has_post_thumbnail()) : ?>

<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>
			<?php the_post_thumbnail(array(180, 100)); ?>
			</a> 
		    <?php endif; ?>				    
	         <h2 style=" color:red; padding:18px;"><?php the_title(); ?></h2>

           <h4> <?php echo get_field( get_adress(), get_the_ID()); ?></h4>
    
  

    <h4> Numéro de téléphone: <?php echo get_field(get_numero(), get_the_ID()); ?> </h4>
   
    
            
 
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
    require plugin_dir_path(__FILE__) . 'public/partials/Carte.php';
    $actions = array(
  
   new Carte(),

  
);

    $plugin = new Emaps($actions);
    $plugin->run();
}
run_emaps();