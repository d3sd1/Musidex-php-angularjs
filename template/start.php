<?php
require('../kernel/core.php');
?>
<div class="page page-full page-dashboard two-column">

  <section class="inner-wrapper scrollable">

    <div class="inner-page">
	<?php
	if(USER_LOGGED_IN == false)
	{
      echo '<section class="dashboard-banner">

        <div class="dashboard-banner__content">
          <h2>
            '.$lang['index.title'].'
          </h2>

          <h5>
            '.$lang['index.subtitle'].'
          </h5>

          <a class="btn btn-primary" href="#/register">
            '.$lang['index.register'].'
          </a>

        </div>

      </section>';
	}
else
{
	echo '<section class="panel panel-default panel-default-clean" style="border-bottom: 5px solid #dedede;">

          <div class="panel-body">

            <h4>
              <i class="fa fa-heart color-primary"></i>&nbsp;&nbsp; '.$lang['index.friendsListenning'].'
            </h4>

            <div class="now-playing">
              <div class="row">
                <div class="col-md-3 now-playing__column">

                  <div class="now-playing__item">

                    <div class="now-playing__image">
                      <img src="'.URL.'/style/images/profile/default.png" alt="" class="img64_64 img-circle">
                      <div class="now-playing__music-icon">
                        <i class="fa fa-check">

                        </i>
                      </div>
                    </div>

                    <div class="now-playing__name">
                      <h6>
                        Kate Westeroz
                      </h6>
                    </div>

                    <div class="now-playing__song">
                      Sultains of swing - Dire Straights
                    </div>

                    <div class="now-playint__rating">

                      <h6>
                        <span class="rating-value">59</span>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                      </h6>
                    </div>

                  </div>

                </div>

                <div class="col-md-3 now-playing__column">

                  <div class="now-playing__item">

                    <div class="now-playing__image">
                      <img src="'.URL.'/style/images/profile/default.png" alt="" class="img64_64 img-circle">
                      <div class="now-playing__music-icon">
                        <i class="fa fa-check">

                        </i>
                      </div>
                    </div>

                    <div class="now-playing__name">
                      <h6>
                        George Steveland
                      </h6>
                    </div>

                    <div class="now-playing__song">
                      Tonight is the deal - Tot on fire
                    </div>

                    <div class="now-playint__rating">

                      <h6>
                        <span class="rating-value">35</span>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                      </h6>
                    </div>

                  </div>

                </div>

                <div class="col-md-3 now-playing__column">

                  <div class="now-playing__item">

                    <div class="now-playing__image">
                      <img src="'.URL.'/style/images/profile/default.png" alt="" class="img64_64 img-circle">
                      <div class="now-playing__music-icon">
                        <i class="fa fa-check">

                        </i>
                      </div>
                    </div>

                    <div class="now-playing__name">
                      <h6>
                        Steve Passeland
                      </h6>
                    </div>

                    <div class="now-playing__song">
                      On the spotlight - Kings of doom
                    </div>

                    <div class="now-playint__rating">

                      <h6>
                        <span class="rating-value">27</span>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                      </h6>
                    </div>

                  </div>

                </div>

                <div class="col-md-3 now-playing__column">

                  <div class="now-playing__item">

                    <div class="now-playing__image">
                      <img src="'.URL.'/style/images/profile/default.png" alt="" class="img64_64 img-circle">
                      <div class="now-playing__music-icon">
                        <i class="fa fa-check">

                        </i>
                      </div>
                    </div>

                    <div class="now-playing__name">
                      <h6>
                        Anthony Walsh
                      </h6>
                    </div>

                    <div class="now-playing__song">
                      Together we are - Legendaries
                    </div>

                    <div class="now-playint__rating">

                      <h6>
                        <span class="rating-value">28</span>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                        <i class="fa fa-star-o color-primary"></i>
                      </h6>
                    </div>

                  </div>

                </div>

              </div>
            </div>

            <br/>

          </div>

        </section>';
}	?>
      <section>
        <section class="panel panel-default panel-default-clean">
          <div class="panel-body panel-body--dashboard">

            <tabset class="ui-tab">
              <tab heading="New albums">

                <div class="divider"></div>

                <div data-ng-controller="SongsCtrl as songs">
                  <div class="row music-covers-listing minified">

                    <div data-ng-repeat="song in SongsSrv.songs" class="col-md-3">

                      <div class="list-item__wrap">

                        <div class="list-item__image">
                          <img ng-src="data/images/{{song.url_name}}/{{song.album}}/cover.jpg"/>
                          <div class="list-item__play">
                            <a class="list-item__play-button" ng-href="#/artist/{{song.url_name}}">
                              <i class="fa fa-2x fa-stumbleupon">

                              </i>
                            </a>
                          </div>
                        </div>

                        <div class="list-item__name">
                          <h6 class="color-primary">
                            {{song.artist}}
                          </h6>
                          <h6>
                            {{song.song}}
                          </h6>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>

              </tab>


            </tabset>

          </div>
        </section>
      </section>

    </div>

  </section>
</div>
  