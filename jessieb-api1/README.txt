The User Table plugin allows you to easily display a table of users from a 3rd-party API endpoint on your WordPress site. The plugin uses the JSONPlaceholder API (https://jsonplaceholder.typicode.com/) to retrieve user data and display it in an HTML table on the frontend of your site. The table includes columns for the user's ID, name, and username, and each row contains a link that, when clicked, shows additional details about the user.

The plugin uses object-oriented programming (OOP) and follows WordPress coding standards. It also includes features such as caching for HTTP requests and error handling for external HTTP requests, to ensure smooth navigation and avoid disruptions even if request fails.

== Installation ==

    Upload the 'jessieb-api1' folder to the '/wp-content/plugins/' directory
    Activate the plugin through the 'Plugins' menu in WordPress
    Use the shortcode [user_table] to display the user table anywhere on your site.


= What data does the plugin display? =

The plugin displays a table of users, including columns for the user's ID, name, and username. Each row also contains a link that, when clicked, shows additional details about the user. The data is retrieved from the JSONPlaceholder API (https://jsonplaceholder.typicode.com/).