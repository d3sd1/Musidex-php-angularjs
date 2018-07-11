<?php
require('kernel/core.php');
?><!doctype html>
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $lang['title'] ?></title>
  <meta name="description" content="">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Include Jquery in the vendor folder -->
  <script src="style/js/jquery.min.js"></script>

  <!-- Theme's own CSS file -->
  <link rel="stylesheet" href="style/css/font-awesome.min.css">
  <link rel="stylesheet" href="style/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="style/css/main.css">
</head>
<noscript>
  <meta http-equiv="Refresh" content="0;URL=no-js">
</noscript>
<body data-ng-app="app" id="app" data-custom-background="" data-off-canvas-nav="" data-ng-controller="AdminAppCtrl">

<div class="" data-ng-controller="PlayListCtrl as generalPlaylist">

  <audio media-player="mediaPlayer" playlist="generalPlaylist.audioPlaylist"></audio>

  <div data-ng-hide="checkIfOwnPage()" data-ng-cloak="" class="no-print">
    <aside data-ng-include=" 'template/navigation.php' " id="nav-container"></aside>
  </div>

  <div class="view-container" id="headerContent">

    <div data-ng-hide="checkIfOwnPage()" data-ng-cloak="" class="no-print">
      <section data-ng-include=" 'template/header.php' " id="header" class="top-header"></section>
    </div>
    <section data-ng-view id="content" class="animate-fade-up" ng-class="{fixed:checkIfFixedPage()}" style="background:#121212;background-image:url(<?php echo URL ?>/style/images/background.jpg);background-size:100% auto;background-attachment:fixed;background-position:center top;background-repeat:no-repeat;"></section>
  </div>

  <div class="player-region" ng-show="mediaPlayer.currentTrack">
    <div>

      <div class="player-control">

        <div class="player-control-bottom">

          <div class="controlling-options">
            <div class="btn" ng-click="mediaPlayer.prev()">
              <i class="fa fa-step-backward"></i>
            </div>
            <div class="btn" ng-click="mediaPlayer.playPause()">
              <i class="fa" ng-class="{ 'fa-pause': mediaPlayer.playing, 'fa-play': !mediaPlayer.playing }"></i>
            </div>
            <div class="btn" ng-click="mediaPlayer.next()">
              <i class="fa fa-step-forward"></i>
            </div>
            <!--<div class="btn btn-noclick">
              <span>currentTrack: <span class="badge">{{ mediaPlayer.currentTrack }}</span></span>
            </div>-->
            <!--<div class="btn btn-noclick">
              <span><i class="fa fa-clock-o"></i>: <span class="badge">{{ mediaPlayer.formatTime }}</span></span>
            </div>-->
            <div class="btn btn-noclick">
              <span><span class="badge">{{ mediaPlayer.volume * 100 | number:0 }}%</span></span>
            </div>
            <div class="btn" ng-click="mediaPlayer.setVolume(mediaPlayer.volume - 0.1)">
              <span><i class="fa fa-volume-down"></i></span>
            </div>
            <div class="btn" ng-click="mediaPlayer.setVolume(mediaPlayer.volume + 0.1)">
              <span><i class="fa fa-volume-up"></i></span>
            </div>
          </div>

          <div class="song-duration">
            <span class="song-duration-beg">{{ mediaPlayer.formatTime }}</span>
            <div class="progress" ng-click="mediaPlayer.seek(mediaPlayer.duration * generalPlaylist.seekPercentage($event))">
              <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" ng-style="{ width: mediaPlayer.currentTime*100/mediaPlayer.duration + '%' }"></div>
            </div>
            <span class="song-duration-end">{{ mediaPlayer.formatDuration }}</span>
          </div>

        </div>

      </div>

    </div>

  </div>
</div>

<div class="page-loading-overlay">
  <div class="loader-2"></div>
</div>

<div class="load_circle_wrapper">

  <div class="loading_spinner">
    <div id="wrap_spinner">
      <div class="loading outer">
        <div class="loading inner"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript" src="style/js/app.js"></script>
<script>var socket = new WebSocket('ws://localhost/send.php');</script>
</body>
</html>