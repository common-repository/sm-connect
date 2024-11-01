<?php
/**
 * Plugin Name: SmartMember Connector
 * Description: Smartmember Connector is a plugin that connects your blog with SmartMember and allows you to import
 * content to SmartMember as lessons, custom pages, or blog posts.
 * Version: 1.0.1
 * Author: Internet Marketing Bar
 * Author URI: http://internetmarketingbar.com
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/* No direct access. */
if( !function_exists( 'add_action' ) )
{
    exit( 0 );
}

add_action( 'admin_menu', 'sm_connector_admin_menu' );
add_action( 'admin_enqueue_scripts', 'sm_connector_enqueue_script' );
add_action( 'init', 'sm_init_options' );

function sm_connector_admin_menu()
{
    add_menu_page( 'SM Connector', 'SM Connector', 'activate_plugins', 'smconnector', 'sm_connector_page' );
}

function sm_connector_enqueue_script()
{
    $plugin_url = str_replace( 'WP_CONTENT_URL', WP_CONTENT_URL, plugin_dir_url( __FILE__ ) );

    wp_enqueue_style( 'dashboard-css', $plugin_url . 'css/dashboard.css', array(), '1.0' );
    wp_enqueue_style( 'nicer-settings-css', $plugin_url . 'css/nicer-settings.css', array(), '1.0' );
    wp_enqueue_style( 'bootstrap-css', $plugin_url . 'css/bootstrap.css', array(), '1.0' );
    wp_enqueue_script( 'bootstrap-js', $plugin_url . 'js/bootstrap.js', array( 'jquery' ), '1.0', false );
    wp_enqueue_script( 'zeroclipboard-js', $plugin_url . 'js/zeroclipboard-min.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'smartmember-js', $plugin_url . 'js/main.js', array( 'jquery', 'zeroclipboard-js' ), '1.0', true );
}

function sm_init_options()
{
    add_option( 'smc_hash', sha1( md5( microtime() ) ) );
    update_option( 'smc_connector', plugins_url( 'api/api.php', __FILE__ ) );
}

function sm_connector_page()
{
    if( !is_admin() )
    {
        wp_die( __( 'You do not have admin rights to perform this action. Please contact administrator' ) );
    }
    $hash    = get_option( 'smc_hash', '' );
    $api_url = str_replace( 'WP_CONTENT_URL', WP_CONTENT_URL, get_option( 'smc_connector', '' ) );

    ?>
    <div class="wrap smart_only_area">
    <h1 class="page-header">SmartMember Connector
        <small>version 1.0.0</small>
    </h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="sb_key">
                        Your SmartMember Connector Key<br/>
                        <small>
                            Please
                        </small>
                    </label>

                    <div class="input-group">
                        <input type="text" class="form-control input-lg" name="sm-key" id="sm-key" value="<?php echo $hash; ?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-lg btn=default zclip" data-method="direct" data-copy-type="value"
                                    data-target="input[name=sm-key]" type="button"
                                    style="background-color: #fff; border: 1px solid #ccc;">Copy
                            </button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="connector_url">
                        Your API Endpoint
                        <br/>
                        <small>This is the API endpoint you will need to connect to your blog with</small>
                    </label>

                    <div class="input-group">
                        <input type="text" class="form-control input-lg" name="connector_url" id="connector_url"
                               value="<?php echo $api_url; ?>"/>
                        <span class="input-group-btn">
                            <button class="btn btn-lg btn=default zclip" data-method="direct" data-copy-type="value"
                                    data-target="input[name=connector_url]" type="button"
                                    style="background-color: #fff; border: 1px solid #ccc;">Copy
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

}

function DebugIt()
{
    $args = func_get_args();

    if( count( $args ) > 0 )
    {
        echo "\n<pre>";

        foreach( $args as $key => $val )
        {
            echo "\n\n========== Degugging Item " . ( $key + 1 ) . " ==========\n\n";
            var_dump( $val );
        }

        echo "\n\n========== END OF DEBUGGING ==========";
        echo "\n</pre>\n\n";
    }
}