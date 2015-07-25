<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($this->params['action']))) . ' &middot; Pingster'; ?>
        </title>

        <?php
        // get header styles, scripts and meta
        echo $this->element('headerStylesScripts');
        echo $this->Html->css('notifications');
        ?>
        <style>
            /*Fix for user dropdown on header navbar (uptodate bootstrap overrides this)*/
            .navbar-nav .open .dropdown-menu {
                background: none repeat scroll 0 0 #ffffff;
                border-bottom: 1px solid #dddddd;
                border-left: 1px solid #dddddd;
                border-right: 1px solid #dddddd;
                left: auto;
                position: absolute;
                right: 0;
                top: 100%;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.176);
                min-width: 160px;
                border-radius: 0;
                border-top-width: 0;
                padding: 1px 0 0;
                width: 280px;
            }
            form .required label:after {
                color: #e32;
                content: '*';
                display:inline;
            }
        </style>

        <script src="//code.jquery.com/jquery-1.10.2.js"></script>

        <script>
        $(document).ready(function() {
            $('#notification_url').click(function(){
                $.ajax({
                    url: "/Notifications/markAllRead"
                });
            });
        });
        </script>
    </head>

    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <?php echo $this->Html->link('Pingster!', array('controller' => 'Users', 'action' => 'dashboard'), array('title' => 'Pingster!', 'class' => 'logo')); ?>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                  <form class="navbar-form navbar-left" action="/Search/explore" role="search" method="get">
                    <div class="form-group">
                        <input type="text" name="term" class="form-control" id="navbar-search-input" placeholder="Search">
                      <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                  </form>

                <div class="navbar-right">

                    <ul class="nav navbar-nav">
                         <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label <?php if (count($Notifications) > 0) { echo "label-warning"; }?>"><?php echo count($Notifications); ?></span>
                          </a>
                          <ul class="dropdown-menu notifications">
                            <div class="notification-heading">
                                <h4 class="menu-title">Notifications</h4>
                            </div>
                            <li class="divider"></li>
                            <li>
                              <!-- inner menu: contains the actual data -->
                                <li>
                                <?php foreach($Notifications as $Notification): ?>
                                   <li class="box box-warning notification-item">
                                    <h4 class="item-title"><i class="ion ion-ios-people info"></i><?php echo $Notification['Notification']['message'];?></h4>
                                    <p class="item-info"><?php echo $Notification['Notification']['created']; ?></p>
                                  </li>
                                  <?php endforeach;?>
                                </li>
                            </li>
                          </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php printf('%s', h($current_user['username'])); ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'view', $current_user['id'], 'admin' => false), array('title' => 'Go to your profile', 'class' => 'btn btn-default btn-flat')); ?>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false), array('title' => 'Logout of Pingster', 'class' => 'btn btn-default btn-flat')); ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu nav nav-pills nav-stacked">
                        <li><?php echo $this->SideNav->LinkIcon('Dashboard', 'fa fa-dashboard', array('controller' => 'Users', 'action' => 'dashboard', 'admin' => false)); ?></li>
                        <li><?php echo $this->SideNav->LinkIcon('Explore', 'fa fa-search', array('controller' => 'Search', 'action' => 'explore', 'admin' => false)); ?></li>
                        <li><?php echo $this->SideNav->LinkIcon('My Pings', 'fa fa-bolt', array('controller' => 'Projects', 'action' => 'myPings', 'admin' => false)); ?></li>
                        <li><?php echo $this->SideNav->LinkIcon('My Team-ups', 'fa fa-rocket', array('controller' => 'Projects', 'action' => 'myTeamUps', 'admin' => false)); ?></li>
                        <li><?php echo $this->SideNav->LinkIcon('My Communities', 'fa fa-globe', array('controller' => 'Communities', 'action' => 'index', 'admin' => false)); ?></li>
                        <?php if ($current_user['Group']['name'] == 'admins') : ?>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-gears"></i>
                                    <span>Admin Tools</span>
                                    <i class="fa pull-right fa-angle-down"></i>
                                </a>
                                <ul class="treeview-menu" style="display: block;">
                                    <li><?php echo $this->SideNav->LinkIcon('Users', 'fa fa-users', array('controller' => 'Users', 'action' => 'index', 'admin' => true)); ?></li>
                                    <li><?php echo $this->SideNav->LinkIcon('Groups/Roles', 'fa fa-lemon-o', array('controller' => 'Groups', 'action' => 'index', 'admin' => true)); ?></li>
                                    <li><?php echo $this->SideNav->LinkIcon('Projects', 'fa fa-archive', array('controller' => 'Projects', 'action' => 'index', 'admin' => true)); ?></li>
                                    <li><?php echo $this->SideNav->LinkIcon('Comments', 'fa fa-comments', array('controller' => 'Comments', 'action' => 'index', 'admin' => true)); ?></li>
                                    <li><?php echo $this->SideNav->LinkIcon('Assets', 'fa fa-cloud', array('controller' => 'Assets', 'action' => 'index', 'admin' => true)); ?></li>
                                    <li><?php echo $this->SideNav->LinkIcon('Communities', 'fa fa-globe', array('controller' => 'Communities', 'action' => 'index', 'admin' => true)); ?></li>
                                    <li><?php echo $this->SideNav->LinkIcon('iACL', 'fa fa-gear', array('controller' => 'i_acl', 'action' => 'static_pages', 'admin' => false)); ?></li>                                                                                                    
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?php echo h(preg_replace('/(\w+)([A-Z])/U', '\\1 \\2', ucfirst($this->params['action']))); ?>
                        <small><?php echo isset($title) ? h($title) : ''; ?></small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <?php echo $this->Session->flash('auth', array('element' => 'Flashes/warning')); ?>
                        <?php echo $this->Session->flash(); ?>

                        <?php echo $this->fetch('content'); ?>

                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <?php //echo $this->element('sql_dump');   ?>
    </body>
    <?php echo $this->element('scripts') ?>
</html>
