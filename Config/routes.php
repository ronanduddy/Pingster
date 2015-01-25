<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
// pingster/ and pingster/home -> Pages/home.ctp
Router::connect('/', array('controller' => 'home', 'action' => 'index'));
Router::connect('/:home', array('controller' => 'home', 'action' => 'index'), array("home" => "[hH]ome"));

// pingster/dashboard -> profiles/index
Router::connect('/:dashboard', array('controller' => 'users', 'action' => 'dashboard'), array("dashboard" => "[dD]ashboard"));

// pingster/signup -> users/signup
Router::connect('/:register', array('controller' => 'users', 'action' => 'register'), array("register" => "[rR]egister"));

// pingster/login -> users/login
Router::connect('/:login', array('controller' => 'users', 'action' => 'login'), array("login" => "[lL]ogin"));

// pingster/logout -> users/logout
Router::connect('/:logout', array('controller' => 'users', 'action' => 'logout'), array("login" => "[lL]ogout"));

// admin routes:
//Router::connect('/:projects/', array('controller' => 'projects', 'action' => 'index', 'admin' => true), array("projects" => "[pP]rojects"));
//Router::connect('/:projects/:index', array('controller' => 'projects', 'action' => 'index', 'admin' => true), array("projects" => "[pP]rojects", "index" => "[iI]ndex"));
//Router::connect('/:projects/:edit/*', array('controller' => 'projects', 'action' => 'edit', 'admin' => true), array("edit" => "[eE]dit"));
//Router::connect('/:projects/:view/*', array('controller' => 'projects', 'action' => 'view', 'admin' => true), array("view" => "[vV]iew"));
//Router::connect('/:projects/:add', array('controller' => 'projects', 'action' => 'add', 'admin' => true), array("add" => "[aA]dd"));
//Router::connect('/:projects/:addPing', array('controller' => 'projects', 'action' => 'add', 'admin' => true), array("addPing" => "[aA]ddPing"));
//
//Router::connect('/:projects/', array('controller' => 'projects', 'action' => 'index', 'admin' => false), array("projects" => "[pP]rojects"));
//Router::connect('/:projects/:index', array('controller' => 'projects', 'action' => 'index', 'admin' => false), array("projects" => "[pP]rojects", "index" => "[iI]ndex"));
//Router::connect('/:projects/:edit/*', array('controller' => 'projects', 'action' => 'edit', 'admin' => false), array("edit" => "[eE]dit"));
//Router::connect('/:projects/:view/*', array('controller' => 'projects', 'action' => 'view', 'admin' => false), array("view" => "[vV]iew"));
//Router::connect('/:projects/:add', array('controller' => 'projects', 'action' => 'add', 'admin' => false), array("add" => "[aA]dd"));
//Router::connect('/:projects/:addPing', array('controller' => 'projects', 'action' => 'add', 'admin' => false), array("addPing" => "[aA]ddPing"));
//
//Router::connect('/:users/:view/*', array('controller' => 'users', 'action' => 'view', 'admin' => true), array("users" => "[uU]sers", "view" => "[vV]iew"));





/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
