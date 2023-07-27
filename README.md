
# WP Data Table View

The **WP Data Table View** is a WordPress plugin designed to display a dynamic HTML table on custom endpoint on the frontend of a WordPress website. This table lists users, each represented as a row, along with their specific characteristics such as ID, name, username, etc.

## Features

-   Fetches user data from a 3rd-party API endpoint (https://jsonplaceholder.typicode.com/users).
-   Displays a clean and interactive table with user information.
-   Each row contains links that provide additional details about the user when clicked.

## Plugin Settings

You can customize the plugin behavior by accessing the **WP Data Table View** settings in your WordPress admin dashboard:

1.  **Set Custom Endpoint:** Enter the slug of the WP frontend endpoint. This allows you to decide what URL of your website will display the users table. (default is `wp-data-table-view`)
2.  **Disable Plugin frontend JS:** Check this option if you want to disable the plugin's JavaScript on the frontend. This might be useful if you have conflicts with other scripts or if you prefer to replace the view template.
3.  **Disable Plugin frontend CSS:** Check this option if you want to disable the plugin's CSS styles on the frontend. This gives you full control over the table's appearance, allowing you to apply your own custom styles.

## Requirements
-   PHP 8.0+
-   [WordPress](http://wordpress.org/)  6.0+

## Installation

This plugin is a Composer package that will be installed as a `wordpress-plugin`.

For WP to pick up WP Data Table View, you have to do one of the following:

### Composer


1. Update your "repositories":
```
"repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:MaksVeter/wp-data-table-view.git"
    }
  ]
```
2. Simply require the package via composer   
```
composer require maksveter/wp-data-table-view
```

### Without Composer

#### Direct upload

You can technically use WP Data Table View by simply extracting all files into the `wp-content/plugins/` folder and installing composer dependencies running the following command in plugin folder:

```
composer install
```

## Development

### Available Hooks

1. Data Cache expiration hook to set the `$expiration` in seconds :
```
add_filter(  
    'mvwp_wp_data_table_view_cache_expiration',  
    function (int $expiration): int {  
        return $expiration; // default is 15min (60*15) 
    }  
);
```

2. Set up your own render template (we recommend disabling plugin JavaScript and CSS via admin settings if you are going to make a totally different template):
```
add_filter(  
    'mvwp_wp_data_table_view_render_template_path',  
    function (string $template_path): string {  
        return $template_path;  
    }  
);
```
3. If you are ok with template just want to add something before or after the table - just use those hooks:
```
add_action(  
    'mvwp_wp_data_table_view_template_render_before',  
    function (){  
        // print some awesome html before
    }  
);
```
```
add_action(  
    'mvwp_wp_data_table_view_template_render_after',  
    function (){  
        // print some awesome html after
    }  
);
```
4. Set up your own frontend endpoint programatically ( and rewrite admin setting ):
```
add_filter(  
    'mvwp_wp_data_table_view_render_display_endpoint',  
    function (string $endpoint): string {  
        return $endpoint;  
    } 
);
```
### Development details: Backend
The backend of the **WP Data Table View** plugin is responsible for handling data retrieval from the 3rd-party API endpoint, caching and preparing it for display on the frontend. It consists of the following components:

1. **PHP-DI (Dependency Injection):** The **WP Data Table View** plugin utilizes PHP-DI, a powerful dependency injection container for PHP. PHP-DI allows for the management of object dependencies, promoting decoupling of components, and making the codebase more maintainable and testable. It provides an elegant way to resolve and inject dependencies into classes, reducing tight coupling and enhancing flexibility in the code architecture. (check `di-config.php` for details and updates)

2.  **API Data Fetching:** The plugin makes HTTP requests to the specified 3rd-party API endpoint using WordPress HTTP API functions. The retrieved data is cached, processed and sanitized before sending it to the frontend.

3.  **Settings Page:** The plugin provides a settings page in the WordPress admin dashboard. Here, users can enter the custom API endpoint URL and configure other options, like disabling the plugin's JavaScript and CSS. ( the `jeffreyvanrossum/wp-settings` composer package is used to simplify the process of defining and retrieving plugin settings )

4. **REST API Integration:** The plugin provides a RESTful API to deliver data to the frontend. The data fetched from the 3rd-party API is processed and served through custom REST API endpoints.

5. **PHP Unit tests** To ensure the reliability and stability of the **WP Data Table View** plugin, several PHPUnit unit tests have been implemented. These tests validate the functionality of individual code units, such as functions and methods, in isolation. The unit tests cover critical parts of the backend codebase and help catch potential bugs and regressions early in the development process. (the `brain/monkey` composer package is used for mocking WordPress-specific functions). To run the PHP Unit tests, run the following command: `composer run test`

6. **PHP CodeSniffer (PHPCS)** To adhere to standardized coding practices, the **WP Data Table View** plugin utilizes PHP CodeSniffer (PHPCS). This tool automatically checks the PHP code against specified coding standards and provides feedback on any deviations. (the [code style](https://github.com/inpsyde/php-coding-standards) is used for PHPCS rules). To run the PHP CodeSniffer check, run the following command: `composer run check-cs`

7. **Usage of Composer:** Composer plays a crucial role in managing dependencies for the plugin. It simplifies the inclusion of external libraries, facilitates development and deployment, and enforces coding best practices. By running `composer install`, all necessary dependencies specified in the `composer.json` file are automatically installed, streamlining setup for developers and environments.

### Development details: Frontend

The frontend of the **WP Data Table View** plugin is built using modern web technologies like React TypeScript and Sass. It aims to provide a simple, interactive, and responsive user interface. The main components of the frontend are as follows:

1.  **React Components:** The frontend is developed using React, a popular JavaScript library for building user interfaces. TypeScript is utilized along with React to add static typing to the codebase, ensuring improved code quality, better developer tooling, and enhanced code scalability.

2.  **Styling with Sass:** Styling of the table and its components is done using Sass (Syntactically Awesome Style Sheets). Sass provides a more organized and maintainable way to manage CSS styles, making the plugin more customizable and easier to update.

3. **Dynamic Table Generation:** The plugin's frontend dynamically generates the table rows and columns based on the data received from the backend.

4. **NPM for Package Management:** NPM (Node Package Manager) is used to manage the project's dependencies and packages. All the necessary packages, including React, TypeScript, and Sass, are listed in the `package.json` file. To install the project dependencies, run the following command:  `npm install`

5.  **Webpack:** Webpack is utilized to bundle the JavaScript and CSS files, optimizing them for production. This helps reduce the plugin's file size and enhances loading speed on the frontend. To re-build the frontend assets, use the following command: `npm run build`


### License

This plugin is released under the GPL-2.0+ license. For more details, see the `LICENSE.md` file included with this plugin.