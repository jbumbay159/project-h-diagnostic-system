<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

  <title>Hyatt | Dashboard</title>
  <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/jquery-ui/jquery-ui.css') ?>">
  <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/Hover/hover.css') ?>">
  <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/fontawesome/css/font-awesome.css') ?>">
  <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/weather-icons/css/weather-icons.css') ?>">
  <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/ionicons/css/ionicons.css') ?>">
  <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/jquery-toggles/toggles-full.css') ?>">
 <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/morrisjs/morris.css') ?>">

  <link rel="stylesheet" href="{{ asset('public/quirk/css/quirk.css') }}">

  <script src="{{ asset('public/quirk/lib/modernizr/modernizr.js') }}"></script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="../lib/html5shiv/html5shiv.js"></script>
  <script src="../lib/respond/respond.src.js"></script>
  <![endif]-->
</head>

<body>

<header>
            <div class="headerpanel">
                <div class="logopanel">
                    <small style="color:#fff;margin-top:-5px;margin-left:5px;"></small>
                </div>
                <div class="headerbar">
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>    
                    <div class="header-right">
                        <ul class="headermenu">              
                            <li>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-logged" data-toggle="dropdown">
                                        User<span class="caret"></span>
                                     </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

<section>
<section>]</section>
  <div class="leftpanel">
                <div class="leftpanelinner">
                    <div class="media leftpanel-profile">
                        <div class="media-left"></div>
                        <div class="media-body">
                            <h4 class="media-heading">User</h4>
                            <span>Administrator</span>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="mainmenu">
                            <h5 class="sidebar-title">Favorites</h5>
                            <ul class="nav nav-pills nav-stacked nav-quirk">
                                <li><a href="#" ><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                            </ul>
                            <h5 class="sidebar-title">Main Menu</h5>
                            <ul class="nav nav-pills nav-stacked nav-quirk">
                                <li class="nav-parent {{ Request::is('customer/*') || Request::is('customer') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>Registration</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('customer/*') || Request::is('customer') ? 'active' : '' }}"><a href="{{ url('customer') }}">Customer</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('lab-result/*') || Request::is('lab-result') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-pencil-square-o"></i> <span>LABORATORY RESULTS</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('lab-result/*') || Request::is('lab-result') ? 'active' : '' }}"><a href="{{ url('lab-result') }}">Search</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('transmittal/*') || Request::is('transmittal') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>TRANSMITTAL</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('transmittal/*') || Request::is('transmittal') ? 'active' : '' }}"><a href="{{ url('transmittal') }}">Search</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('sale/*') || Request::is('sale') || Request::is('transaction/*') || Request::is('transaction') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>Sales</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('sale/*') || Request::is('sale') ? 'active' : '' }}"><a href="{{ url('sale') }}">Search</a></li>
                                         <li class="{{ Request::is('transaction/*') || Request::is('transaction') ? 'active' : '' }}"><a href="{{ url('transaction') }}">Transaction</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('report/*') || Request::is('report') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>Reports</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('report/daily-sales/*') || Request::is('report/daily-sales') ? 'active' : '' }}"><a href="{{ url('report/daily-sales') }}">Daily Sales</a></li>
                                        <li class="{{ Request::is('report/agency-sales/*') || Request::is('report/agency-sales') ? 'active' : '' }}"><a href="{{ url('report/agency-sales') }}">Agency Sales</a></li>
                                        <li class="{{ Request::is('report/summary-sales/*') || Request::is('report/summary-sales') ? 'active' : '' }}"><a href="{{ url('report/summary-sales') }}">Sales Summary</a></li>
                                        <li class="{{ Request::is('report/transaction-summary/*') || Request::is('report/transaction-summary') ? 'active' : '' }}"><a href="{{ url('report/transaction-summary') }}">Transaction Summary</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('agency/*') || Request::is('agency') || Request::is('category') || Request::is('category/*') || Request::is('service/*') || Request::is('service') || Request::is('package/*') || Request::is('package') || Request::is('supply/*') || Request::is('supply') || Request::is('country/*') || Request::is('country') || Request::is('pricing-types/*') || Request::is('pricing-types') || Request::is('association/*') || Request::is('association') || Request::is('agency-pricing/*') || Request::is('agency-pricing') ? 'active' : '' }}" >    
                                    <a href=""><i class="fa fa-wrench"></i> <span>Utilities</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('agency/*') || Request::is('agency') ? 'active' : '' }}"><a href="{{ url('agency') }}">Agency</a></li>
                                        <li class="{{ Request::is('category/*') || Request::is('category') ? 'active' : '' }}"><a href="{{ url('category') }}">Categories</a></li>
                                        <li class="{{ Request::is('service/*') || Request::is('service') ? 'active' : '' }}"><a href="{{ url('service') }}">Services </a></li>
                                        <li class="{{ Request::is('package/*') || Request::is('package') ? 'active' : '' }}"><a href="{{ url('package') }}">Packages</a></li>
                                        <li class="{{ Request::is('association/*') || Request::is('association') ? 'active' : '' }}"><a href="{{ url('association') }}">Association</a></li>
                                        <li class="{{ Request::is('country/*') || Request::is('country') ? 'active' : '' }}"><a href="{{ url('country') }}">Countries</a></li>
                                        <li class="{{ Request::is('supply/*') || Request::is('supply') ? 'active' : '' }}"><a href="{{ url('supply') }}">Supplies</a></li>
                                        <li class="{{ Request::is('pricing-types/*') || Request::is('pricing-types') ? 'active' : '' }}"><a href="{{ url('pricing-types') }}">Pricing Type </a></li>
                                        <li class="{{ Request::is('agency-pricing/*') || Request::is('agency-pricing') ? 'active' : '' }}"><a href="{{ url('agency-pricing') }}">Agency Pricing </a></li>
                                    </ul>
                                </li>
                            </ul>
                            <h5 class="sidebar-title">Security</h5>
                            <ul class="nav nav-pills nav-stacked nav-quirk">
                                <li class="nav-parent">
                                    <a href=""><i class="fa fa-check-square"></i> <span>Password</span></a>
                                    <ul class="children">
                                        <li><a href="#">Change Password</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

  <div class="mainpanel">

    <!--<div class="pageheader">
      <h2><i class="fa fa-home"></i> Dashboard</h2>
    </div>-->

    <div class="contentpanel">

      <div class="row">
        <div class="col-md-9 col-lg-8 dash-left">
          <div class="panel panel-announcement">
            <ul class="panel-options">
              <li><a><i class="fa fa-refresh"></i></a></li>
              <li><a class="panel-remove"><i class="fa fa-remove"></i></a></li>
            </ul>
            <div class="panel-heading">
              <h4 class="panel-title">Latest Announcement</h4>
            </div>
            <div class="panel-body">
              <h2><br>
			  A new admin template has been released by <span class="text-primary">ThemePixels</span> with a name <span class="text-success">Quirk</span> is now live and available for purchase!</h2>
              <h4>Explore this new template and see the beauty of Quirk! <a href="">Take a Tour!</a></h4>
            </div>
          </div><!-- panel -->

          <div class="panel panel-site-traffic">
            <div class="panel-heading">
              <ul class="panel-options">
                <li><a><i class="fa fa-refresh"></i></a></li>
              </ul>
              <h4 class="panel-title text-success">How Engaged Our Users Daily</h4>
              <p class="nomargin">Past 30 Days — Last Updated July 14, 2015</p>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-6 col-sm-4">
                  <div class="pull-left">
                    <div class="icon icon ion-stats-bars"></div>
                  </div>
                  <div class="pull-left">
                    <h4 class="panel-title">Bounce Rate</h4>
                    <h3>23.30%</h3>
                    <h5 class="text-success">2.00% increased</h5>
                  </div>
                </div>
                <div class="col-xs-6 col-sm-4">
                  <div class="pull-left">
                    <div class="icon icon ion-eye"></div>
                  </div>
                  <h4 class="panel-title">Pageviews / Visitor</h4>
                  <h3>38.10</h3>
                  <h5 class="text-danger">5.70% decreased</h5>
                </div>
                <div class="col-xs-6 col-sm-4">
                  <div class="pull-left">
                    <div class="icon icon ion-clock"></div>
                  </div>
                  <h4 class="panel-title">Time on Site</h4>
                  <h3>4:45</h3>
                  <h5 class="text-success">5.00% increased</h5>
                </div>
              </div><!-- row -->

              <div class="mb20"></div>

              <div id="basicflot" style="height: 263px"></div>

            </div><!-- panel-body -->

            <div class="table-responsive">
              <table class="table table-bordered table-default table-striped nomargin">
                <thead class="success">
                  <tr>
                    <th>Country</th>
                    <th class="text-right">% of Visitors</th>
                    <th class="text-right">Bounce Rate</th>
                    <th class="text-right">Page View</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>United States</td>
                    <td class="text-right">61%</td>
                    <td class="text-right">25.87%</td>
                    <td class="text-right">55.23</td>
                  </tr>
                  <tr>
                    <td>Canada</td>
                    <td class="text-right">13%</td>
                    <td class="text-right">23.12%</td>
                    <td class="text-right">65.00</td>
                  </tr>
                  <tr>
                    <td>Great Britain</td>
                    <td class="text-right">10%</td>
                    <td class="text-right">20.43%</td>
                    <td class="text-right">67.99</td>
                  </tr>
                  <tr>
                    <td>Philippines</td>
                    <td class="text-right">7%</td>
                    <td class="text-right">18.17%</td>
                    <td class="text-right">55.13</td>
                  </tr>
                  <tr>
                    <td>Australia</td>
                    <td class="text-right">6.03%</td>
                    <td class="text-right">17.67%</td>
                    <td class="text-right">67.05</td>
                  </tr>
                </tbody>
              </table>
            </div><!-- table-responsive -->

          </div><!-- panel -->

          <div class="row panel-statistics">
            <div class="col-sm-6">
              <div class="panel panel-updates">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <h4 class="panel-title text-success">Products Added</h4>
                      <h3>75.7%</h3>
                      <div class="progress">
                        <div style="width: 75.7%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75.7" role="progressbar" class="progress-bar progress-bar-success">
                          <span class="sr-only">75.7% Complete (success)</span>
                        </div>
                      </div>
                      <p>Added products for this month: 75</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                      <input type="text" value="75" class="dial-success">
                    </div>
                  </div>
                </div>
              </div><!-- panel -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6">
              <div class="panel panel-danger-full panel-updates">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <h4 class="panel-title text-warning">Products Rejected</h4>
                      <h3>39.9%</h3>
                      <div class="progress">
                        <div style="width: 39.9%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="39.9" role="progressbar" class="progress-bar progress-bar-warning">
                          <span class="sr-only">39.9% Complete (success)</span>
                        </div>
                      </div>
                      <p>Rejected products for this month: 45</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                      <input type="text" value="45" class="dial-warning">
                    </div>
                  </div>
                </div>
              </div><!-- panel -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6">
              <div class="panel panel-success-full panel-updates">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <h4 class="panel-title text-success">Products Sold</h4>
                      <h3>55.4%</h3>
                      <div class="progress">
                        <div style="width: 55.4%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="55.4" role="progressbar" class="progress-bar progress-bar-info">
                          <span class="sr-only">55.4% Complete (success)</span>
                        </div>
                      </div>
                      <p>Sold products for this month: 1,203</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                      <input type="text" value="55" class="dial-info">
                    </div>
                  </div>
                </div>
              </div><!-- panel -->
            </div><!-- col-sm-6 -->

            <div class="col-sm-6">
              <div class="panel panel-updates">
                <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-7 col-lg-8">
                      <h4 class="panel-title text-danger">Products Returned</h4>
                      <h3>22.1%</h3>
                      <div class="progress">
                        <div style="width: 22.1%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="22.1" role="progressbar" class="progress-bar progress-bar-danger">
                          <span class="sr-only">22.1% Complete (success)</span>
                        </div>
                      </div>
                      <p>Returned products this month: 22</p>
                    </div>
                    <div class="col-xs-5 col-lg-4 text-right">
                      <input type="text" value="22" class="dial-danger">
                    </div>
                  </div>
                </div>
              </div><!-- panel -->
            </div><!-- col-sm-6 -->

          </div><!-- row -->

          <div class="row row-col-join panel-earnings">
            <div class="col-xs-3 col-sm-4 col-lg-3">
              <div class="panel">
                <ul class="panel-options">
                  <li><a><i class="glyphicon glyphicon-option-vertical"></i></a></li>
                </ul>
                <div class="panel-heading">
                  <h4 class="panel-title">Total Earnings</h4>
                </div>
                <div class="panel-body">
                  <h3 class="earning-amount">$1,543.03</h3>
                  <h4 class="earning-today">Today's Earnings</h4>

                  <ul class="list-group">
                    <li class="list-group-item">This Week <span class="pull-right">$12,320.34</span></li>
                    <li class="list-group-item">This Month <span class="pull-right">$37,520.34</span></li>
                  </ul>
                  <hr class="invisible">
                  <p>Total items sold this month: 325</p>
                </div>
              </div><!-- panel -->
            </div>
            <div class="col-xs-9 col-sm-8 col-lg-9">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Earnings Graph Overview</h4>
                </div>
                <div class="panel-body">
                  <div id="line-chart" class="body-chart"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="row panel-quick-page">
            <div class="col-xs-4 col-sm-5 col-md-4 page-user">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Manage Users</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-person-stalker"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 page-products">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Manage Products</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="fa fa-shopping-cart"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2 page-events">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Events</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-ios-calendar-outline"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-3 col-md-2 page-messages">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Messages</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-email"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-5 col-md-2 page-reports">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Reports</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-arrow-graph-up-right"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-2 page-statistics">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Statistics</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-ios-pulse-strong"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 page-support">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Manage Support</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-help-buoy"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-2 page-privacy">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Privacy</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-android-lock"></i></div>
                </div>
              </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-2 page-settings">
              <div class="panel">
                <div class="panel-heading">
                  <h4 class="panel-title">Settings</h4>
                </div>
                <div class="panel-body">
                  <div class="page-icon"><i class="icon ion-gear-a"></i></div>
                </div>
              </div>
            </div>
          </div><!-- row -->

        </div><!-- col-md-9 -->
        <div class="col-md-3 col-lg-4 dash-right">
          <div class="row">
            <div class="col-sm-5 col-md-12 col-lg-6">
              <div class="panel panel-danger panel-weather">
                <div class="panel-heading">
                  <h4 class="panel-title">Weather Forecast</h4>
                </div>
                <div class="panel-body inverse">
                  <div class="row mb10">
                    <div class="col-xs-6">
                      <h2 class="today-day">Monday</h2>
                      <h3 class="today-date">July 13, 2015</h3>
                    </div>
                    <div class="col-xs-6">
                      <i class="wi wi-hail today-cloud"></i>
                    </div>
                  </div>
                  <p class="nomargin">Thunderstorm in the area of responsibility this afternoon through this evening.</p>
                  <div class="row mt10">
                    <div class="col-xs-7">
                      <strong>Temperature:</strong> (Celcius) 19
                    </div>
                    <div class="col-xs-5">
                      <strong>Wind:</strong> 30+ mph
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- col-md-12 -->
            <div class="col-sm-5 col-md-12 col-lg-6">
              <div class="panel panel-primary list-announcement">
                <div class="panel-heading">
                  <h4 class="panel-title">Previous Announcements</h4>
                </div>
                <div class="panel-body">
                  <ul class="list-unstyled mb20">
                    <li>
                      <a href="">Testing Credit Card Payments on...</a>
                      <small>June 30, 2015 <a href="">7 shares</a></small>
                    </li>
                    <li>
                      <a href="">A Shopping Cart for New and...</a>
                      <small>June 15, 2015 &nbsp; <a href="">11 shares</a></small>
                    </li>
                    <li>
                      <a href="">A Shopping Cart for New and...</a>
                      <small>June 15, 2015 &nbsp; <a href="">2 shares</a></small>
                    </li>
                  </ul>
                </div>
                <div class="panel-footer">
                  <button class="btn btn-primary btn-block">View More Announcements <i class="fa fa-arrow-right"></i></button>
                </div>
              </div>
            </div><!-- col-md-12 -->
          </div><!-- row -->

          <div class="row">
            <div class="col-sm-5 col-md-12 col-lg-6">
              <div class="panel panel-success">
                <div class="panel-heading">
                  <h4 class="panel-title">Recent User Activity</h4>
                </div>
                <div class="panel-body">
                  <ul class="media-list user-list">
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user2.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading nomargin"><a href="">Floyd M. Romero</a></h4>
                        is now following <a href="">Christina R. Hill</a>
                        <small class="date"><i class="glyphicon glyphicon-time"></i> Just now</small>
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user10.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading nomargin"><a href="">Roberta F. Horn</a></h4>
                        commented on <a href="">HTML5 Tutorial</a>
                        <small class="date"><i class="glyphicon glyphicon-time"></i> Yesterday</small>
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user3.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading nomargin"><a href="">Jennie S. Gray</a></h4>
                        posted a video on <a href="">The Discovery</a>
                        <small class="date"><i class="glyphicon glyphicon-time"></i> June 25, 2015</small>
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user5.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading nomargin"><a href="">Nicholas T. Hinkle</a></h4>
                        liked your video on <a href="">The Discovery</a>
                        <small class="date"><i class="glyphicon glyphicon-time"></i> June 24, 2015</small>
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user2.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading nomargin"><a href="">Floyd M. Romero</a></h4>
                        liked your photo on <a href="">My Life Adventure</a>
                        <small class="date"><i class="glyphicon glyphicon-time"></i> June 24, 2015</small>
                      </div>
                    </li>
                  </ul>
                </div>
              </div><!-- panel -->
            </div>

            <div class="col-sm-5 col-md-12 col-lg-6">
              <div class="panel panel-inverse">
                <div class="panel-heading">
                  <h4 class="panel-title">Most Followed Users</h4>
                </div>
                <div class="panel-body">
                  <ul class="media-list user-list">
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user9.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="">Ashley T. Brewington</a></h4>
                        <span>5,323</span> Followers
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user10.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="">Roberta F. Horn</a></h4>
                        <span>4,100</span> Followers
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user3.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="">Jennie S. Gray</a></h4>
                        <span>3,508</span> Followers
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user4.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="">Alia J. Locher</a></h4>
                        <span>3,508</span> Followers
                      </div>
                    </li>
                    <li class="media">
                      <div class="media-left">
                        <a href="#">
                          <img class="media-object img-circle" src="../images/photos/user6.png" alt="">
                        </a>
                      </div>
                      <div class="media-body">
                        <h4 class="media-heading"><a href="">Jamie W. Bradford</a></h4>
                        <span>2,001</span> Followers
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div><!-- row -->

        </div><!-- col-md-3 -->
      </div><!-- row -->

    </div><!-- contentpanel -->

  </div><!-- mainpanel -->

</section>


<script src="{{ asset('public/quirk/lib/jquery/jquery.js') }}"></script>
<script src="{{ asset('public/quirk/lib/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('public/quirk/lib/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('public/quirk/lib/jquery-toggles/toggles.js') }}"></script>


<script src="{{ asset('public/quirk/lib/morrisjs/morris.js') }}"></script>
<script src="{{ asset('public/quirk/lib/raphael/raphael.js') }}"></script>

<script src="{{ asset('public/quirk/lib/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('public/quirk/lib/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('public/quirk/lib/flot-spline/jquery.flot.spline.js') }}"></script>

<script src="{{ asset('public/quirk/lib/jquery-knob/jquery.knob.js') }}"></script>

<script src="{{ asset('public/quirk/js/quirk.js') }}"></script>
<script src="{{ asset('public/quirk/js/dashboard.js') }}"></script>


</body>
</html>
