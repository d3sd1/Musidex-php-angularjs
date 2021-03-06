<?php
require('../kernel/core.php');
?>
<!-- Logo -->
<div class="logo" data-ng-controller="AdminAppCtrl">
  <a class="logo-link" href="#/">
    <i class="logo-icon fa fa-stumbleupon"></i>
    <!--<span>{{info.theme_name}}</span>-->
  </a>

  <div class="form-group logo-search">
    <div>
      <input type="text" class="form-control" placeholder="Search site">
      <span class="icon glyphicon glyphicon-search"></span>
    </div>
  </div>
</div>

<div id="nav-wrapper" data-ng-controller="NavCtrl as navigation">

  <div class="sidebar-nav-switch">

    <div class="btn-group switch">

      <a class="btn main-nav-link home" ng-class="{active:navigation.navigationState.menu}" data-nav-section="home" data-ng-click="navigation.SwitchToMenu()">
        <span class="label">BROWSE</span>
      </a>

      <a class="btn main-nav-link queue" ng-class="{active:navigation.navigationState.playlist}" data-nav-section="queue" data-ng-click="navigation.SwitchToPlaylist()">
        <span class="label queue-label">
            <span>QUEUE</span><span class="songs" ng-show="mediaPlayer.tracks > 0"> <span class="badge badge-primary">{{mediaPlayer.tracks}}</span></span>
        </span>
      </a>

    </div>

  </div>

  <div class="sidebar-nav-main navigation-menu-container" data-slim-scroll data-ng-class="{minified:mediaPlayer.currentTrack}">

    <div class="menu-navigation-menus" ng-show="navigation.navigationState.menu" id="navigationHeaderCtrl">
        <?php
		if(USER_LOGGED_IN === true)
		{
			echo $musidexTemplate::loggedInUserMenu($userImage,$userName,$userId);
		}
	?>
      <div class="nav-user-menu sidebar-nav-content">

        <ul class="sidebar-nav-menu" data-highlight-active data-collapse-nav>

          <li id="user-menu" class="nav-item">
            <a class="nav-link profile" href="#/artist-list">
              <i class="icon fa fa-headphones"></i>
              <span class="label helper-tooltip-measured">Artists</span>
            </a>

          </li>

          <li id="user-menu" class="nav-item">
            <a class="nav-link profile" href="#/albums">
              <i class="icon fa fa-bar-chart"></i>
              <span class="label helper-tooltip-measured">Albums</span>
            </a>

          </li>

          <li id="user-menu" class="nav-item">
            <a class="nav-link profile" href="#/genres">
              <i class="icon musicicon-radio42"></i>
              <span class="label helper-tooltip-measured">Genres</span>
            </a>

          </li>

          <li id="user-menu" class="nav-item">
            <a class="nav-link profile" href="javascript:;">
              <i class="icon fa fa-magic"></i>
              <span class="label helper-tooltip-measured">Ui elements</span>
            </a>
            <ul>
              <li class="nav-item">
                <a class="nav-link profile" href="#/ui/buttons">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Buttons</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile" href="#/ui/components">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Components</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile" href="#/ui/widgets">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Widgets</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile" href="#/ui/grids">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Grids</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile" href="#/ui/icons">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Icons</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile" href="#/ui/nested-lists">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Nested Lists</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link profile" href="#/ui/timeline">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Timeline</span>
                </a>
              </li>
            </ul>

          </li>

          <li id="user-menu" class="nav-item">
            <a class="nav-link profile" href="javascript:;">
              <i class="icon fa fa-file"></i>
              <span class="label helper-tooltip-measured">Pages</span>
            </a>
            <ul>
              <li class="nav-item">
                <a class="nav-link profile" href="#/front">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Frontpage</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link profile" href="#/pages/signin">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Sign in</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link profile" href="#/pages/signup">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Sign up</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link profile" href="#/pages/forgot">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Forgot password</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link profile" href="#/pages/contact">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">Contact</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link profile" href="#/pages/404">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">404</span>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link profile" href="#/pages/500">
                  <i class="icon fa fa-angle-right"></i>
                  <span class="label helper-tooltip-measured">500</span>
                </a>
              </li>s
            </ul>

          </li>

        </ul>

      </div>

      <div class="nav-user-menu sidebar-nav-content">

        <div class="sidebar-nav-content__header">
        <span>
          Your playlists
        </span>
        </div>

        <ul class="sidebar-nav-menu" data-highlight-active data-ng-controller="UserPlayListCtrl as userplaylist">
          <li id="user-menu" class="nav-item">
            <a class="nav-link profile" href="javascript:;" data-ng-click="generalPlaylist.createNewPlaylist()">
              <i class="icon fa fa-plus-circle"></i>
              <span class="label helper-tooltip-measured">Create a playlist</span>
            </a>

          </li>
          <!--<li id="user-menu" class="nav-item">
            <a class="nav-link profile" href="#/artist/enya">
              <i class="icon fa fa-book"></i>
              <span class="label helper-tooltip-measured">Enya</span>
            </a>

          </li>

          <li id="user-menu" class="nav-item">
            <a class="nav-link profile" href="#/artist/beatles">
              <i class="icon fa fa-book"></i>
              <span class="label helper-tooltip-measured">Beatles</span>
            </a>

          </li>-->

          <li id="user-menu" class="nav-item" ng-repeat="playlist in generalPlaylist.userPlaylists track by $index">
            <a class="nav-link profile" href="#/playlist/{{playlist.url_name}}">
              <i class="icon fa fa-book"></i>
              <span class="label helper-tooltip-measured">{{playlist.name}}</span>
            </a>
          </li>

        </ul>

      </div>

    </div>

    <div class="playlist-item-list music-listing--queue" ng-show="navigation.navigationState.playlist">

      <div class="music-listing__songs">

        <div class="music-listing__row" ng-repeat="song in generalPlaylist.audioPlaylist" ng-class="{ active: mediaPlayer.playing && mediaPlayer.currentTrack-1 === $index }"
             ui-draggable="true" drag="song" on-drop-success="generalPlaylist.removeSong($index)" ui-on-drop="generalPlaylist.dropSong($data, $index)">

          <div class="music-listing__number">
            {{ $index+1 }}
          </div>

          <div class="music-listing__row-actions">
            <i class="fa fa-times action" ng-click="generalPlaylist.removeSong($index)" title="Remove song"></i>
            <i class="fa fa-list action" title="More Options..."></i>
          </div>

          <div class="music-listing__name">

            <div class="music-listing__thumbnail" ng-click="mediaPlayer.playPause($index)">
              <img ng-src="{{song.image}}" alt="song__image"/>
            </div>

            <div class="music-listing__artist-name" ng-click="mediaPlayer.playPause($index)">
              {{ song.artist }}
            </div>
            <div class="music-listing__song-name" ng-click="mediaPlayer.playPause($index)">
              {{ song.title }}
            </div>

          </div>

        </div>

        <div class="empty-listing" ng-hide="generalPlaylist.audioPlaylist.length">

          <div class="empty-listing-icon">
            <i class="musicicon-dj4">

            </i>
          </div>
          <div class="empty-listing-message">
            You dont have any item in the playlist
          </div>

          <div class="empty-listing-message">
            <a ng-href="#/artist-list" class="btn btn-primary btn-block btn-sm">Search</a>
          </div>

        </div>

      </div>

    </div>

  </div>

  <div class="player-image-region" ng-show="mediaPlayer.currentTrack" style="background:url({{generalPlaylist.getSongImage(mediaPlayer.currentTrack)}}) no-repeat;">
    <div class="song-info">
      <div class="song-info__text">
        <div class="song-info__title">{{generalPlaylist.getSongArtist(mediaPlayer.currentTrack)}}</div>
        <div>{{generalPlaylist.getSongName(mediaPlayer.currentTrack)}}</div>
      </div>
    </div>
  </div>


</div>
