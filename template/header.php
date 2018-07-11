<?php
require('../kernel/core.php');
?>
<!-- Logo -->

<header class="clearfix">

<div class="top-nav">
<ul class="nav-left list-unstyled">
    <li>
        <!-- needs to be put after logo to make it working-->
        <div class="menu-button" toggle-off-canvas>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </div>

    </li>
    <!--<li>
        <a href="#/" data-toggle-min-nav
           class="toggle-min"
                ><i class="fa fa-list color-white"></i></a>
    </li>-->


</ul>

<ul class="nav-left pull-left list-unstyled list-notifications">
    <li class="dropdown list-notifications__item">
        <a href="javascript:;" class="dropdown-toggle bg-primary" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-inbox color-white"></i>
        </a>

        <div class="dropdown-menu pull-left with-arrow panel panel-default">
            <div class="panel-heading">
                You have 2 messages.
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                    <span class="pull-left media-icon">
                                        <span class="circle-icon sm bg-info"><i class="fa fa-comment-o"></i></span>
                                    </span>

                        <div class="media-body">
                            <span class="block">Jane sent you a message</span>
                            <span class="text-muted">3 hours ago</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                    <span class="pull-left media-icon">
                                        <span class="circle-icon sm bg-danger"><i class="fa fa-comment-o"></i></span>
                                    </span>

                        <div class="media-body">
                            <span class="block">Lynda sent you a mail</span>
                            <span class="text-muted">9 hours ago</span>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="panel-footer">
                <a href="javascript:;">Show all messages.</a>
            </div>
        </div>
    </li>
    <li class="dropdown list-notifications__item">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="musicicon-radio43 nav-icon color-white"></i>
        </a>

        <div class="dropdown-menu pull-left with-arrow panel panel-default">
            <div class="panel-heading">
                You have 3 music suggestions
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                    <span class="pull-left media-icon">
                                        <span class="circle-icon sm bg-success"><i class="musicicon-music201"></i></span>
                                    </span>

                        <div class="media-body">
                            <span class="block">The kingdom of fire</span>
                            <span class="text-muted block">Jane Doe - 2min ago</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                    <span class="pull-left media-icon">
                                        <span class="circle-icon sm bg-info"><i class="musicicon-dj4"></i></span>
                                    </span>

                        <div class="media-body">
                            <span class="block">The Lunatics</span>
                            <span class="text-muted">John Doe - 3 hours ago</span>
                        </div>
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="javascript:;" class="media">
                                    <span class="pull-left media-icon">
                                        <span class="circle-icon sm bg-danger"><i class="musicicon-cymbals2"></i></span>
                                    </span>

                        <div class="media-body">
                            <span class="block">The Crookers</span>
                            <span class="text-muted">John Doe - 9 hours ago</span>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="panel-footer">
                <a href="javascript:;">Show all notifications.</a>
            </div>
        </div>
    </li>
    <!--<li class="list-notifications__item">
        <a href="#/tasks" class="">
            <i class="icon-checkmark color-white"></i>
        </a>
    </li>-->
</ul>



<ul data-ng-controller="ActionsCtrl as actions" class="nav-button pull-right list-unstyled header-actions" id="headerActionsSign">
    
  <?php
if(USER_LOGGED_IN == true)
{
	echo $musidexTemplate::loggedInHeaderContent();
}
else
{
	echo $musidexTemplate::loggedOutHeaderSignIn();
}
?>
</ul>

</div>

</header>


