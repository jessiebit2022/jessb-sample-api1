<?php  
/*
 *	Plugin Name: JessieB API-1 Plugin
 *	Plugin URI: http://jessieb.site
 *	Description: Displays a table of users from a 3rd-party API
 *	Version: 1.0
 *	Author: Jessie Borras
 *	Author URI: http://jessieb.site
 *	License: GPL2
 *
*/

if( ! defined( 'ABSPATH') ){
    exit;
}

class JessieB_User_Table_Plugin {

    /**
     * The endpoint for the user data
     */
    const USER_ENDPOINT = 'https://jsonplaceholder.typicode.com/users';

    /**
     * The endpoint for user details
     */
    const USER_DETAILS_ENDPOINT = 'https://jsonplaceholder.typicode.com/users/';

    /**
     * The name of the transient used for caching HTTP requests
     */
    const TRANSIENT_NAME = 'user_table_data';

    /**
     * The lifetime of the transient, in seconds
     */
    const TRANSIENT_LIFETIME = 3600;

    /**
     * The plugin's constructor
     */
    public function __construct() {
        add_shortcode('user_table', array($this, 'user_table_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    /**
     * Displays the user table
     */
    public function user_table_shortcode() {

        // Try to get the data from the transient
        $data = get_transient(self::TRANSIENT_NAME);
        // If the transient has expired or is not set
        if (false === $data) {
            // Make an HTTP request to the user data endpoint
            $response = wp_remote_get(self::USER_ENDPOINT);
            // If the request was successful
            if (!is_wp_error($response)) {
                // Get the response body
                $data = json_decode(wp_remote_retrieve_body($response));
                // Set the transient with the response data
                set_transient(self::TRANSIENT_NAME, $data, self::TRANSIENT_LIFETIME);
            } else {
                return 'An error occurred: ' . $response->get_error_message();
            }
        }
        // Begin building the HTML table
        $html = '<table>';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Name</th>';
        $html .= '<th>Username</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        // Loop through the user data
        foreach ($data as $user) {
            $html .= '<tr>';
            // Add the ID column
            $html .= '<td><a href="#" data-user-id="' . $user->id . '" class="user-details-link">' . $user->id . '</a></td>';
            // Add the name column
            $html .= '<td>' . $user->name . '</td>';
            // Add the username column
            $html .= '<td>' . $user->username . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
    $html .= '</table>';
    // Add a container for the user details
    $html .= '<div id="user-details"></div>';
    // Return the HTML
    return $html;
}

/**
 * Enqueues the plugin's scripts and styles
 */
public function enqueue_scripts() {
    // Enqueue the plugin's stylesheet
    wp_enqueue_style('user-table-css', plugin_dir_url(__FILE__) . 'user-table.css');
    // Enqueue the plugin's JavaScript
    wp_enqueue_script('user-table-js', plugin_dir_url(__FILE__) . 'user-table.js', array('jquery'), false, true);
    // Localize the script with the plugin's data
    wp_localize_script(
        'user-table-js',
        'user_table_data',
        array(
            'user_details_endpoint' => self::USER_DETAILS_ENDPOINT,
        )
    );
}

}

// Create an instance of the plugin
$user_table_plugin = new JessieB_User_Table_Plugin();