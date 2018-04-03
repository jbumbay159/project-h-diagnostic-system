
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

        <title>Hyatt Diagnostic System Inc</title>


        <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('public/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('public/quirk/css/quirk.css') }}">

        <script src="<?php echo asset('quirk/lib/modernizr/modernizr.js') ?>"></script>
        <style type="text/css">
            .spacing{margin-top: 15px;}
            .select2-dropdown {z-index: 9001;}
            .select2-container {width: 100% !important;padding: 0;}
            .carousel-content {color:black;display:flex;align-items:center;}
            .btn-others {color: #ffffff;background-color: #8e44ad;border-color: transparent;}
            .app{width: 100%;position: relative;}
            .app #start-camera{display: none;border-radius: 3px;max-width: 400px;color: #fff;background-color: #448AFF;text-decoration: none;padding: 15px;opacity: 0.8;margin: 50px auto;text-align: center;}
            .app video#camera-stream{display: none;width: 100%;}
            .app img#snap{position: absolute;top: 0;left: 0;width: 100%;z-index: 10;display: none;}
            .app #error-message{width: 100%;background-color: #ccc;color: #9b9b9b;font-size: 28px;padding: 200px 100px;text-align: center;display: none;}
            .app .controls{position: absolute;top: 0;left: 0;width: 100%;height: 100%;z-index: 20;display: flex;align-items: flex-end;justify-content: space-between;padding: 30px;display: none;}
            .app .controls a{border-radius: 50%;color: #fff;background-color: #111;text-decoration: none;padding: 15px;line-height: 0;opacity: 0.7;outline: none;-webkit-tap-highlight-color: transparent;}
            .app .controls a:hover{opacity: 1;}
            .app .controls a.disabled{background-color: #555;opacity: 0.5;cursor: default;pointer-events: none;}
            .app .controls a.disabled:hover{opacity: 0.5;}
            .app .controls a i{font-size: 18px;}
            .app .controls #take-photo i{font-size: 32px;}
            .app canvas{display: none;}
            .app video#camera-stream.visible,.app img#snap.visible,.app #error-message.visible{display: block;}
            .app .controls.visible{display: flex;}
            @media(max-width: 1000px){
                .app #start-camera.visible{display: block;}
                .app .controls a i{font-size: 16px;}
                .app .controls #take-photo i{font-size: 24px;}
            }
            @media(max-width: 600px){
                .app #error-message{padding: 80px 50px;font-size: 18px;}
                .app .controls a i{font-size: 12px;}
                .app .controls #take-photo i{font-size: 18px;}
            }
            .round {display: inline-block;height: 30px;width: 30px;line-height: 30px;-moz-border-radius: 15px;border-radius: 15px;background-color: #222;color: #FFF;text-align: center;  }
            .round.hollow {display: inline-block;height: 30px;width: 30px;line-height: 30px;-moz-border-radius: 15px;border-radius: 15px;background-color: #FFF;color: #222;text-align: center;-webkit-box-shadow: 0px 0px 0px 3px rgba(0,0,0,0.75);-moz-box-shadow: 0px 0px 0px 3px rgba(0,0,0,0.75);box-shadow: 0px 0px 0px 3px rgba(0,0,0,0.75);}
            .round.round-sm {height: 10px;width: 10px;line-height: 10px;-moz-border-radius: 10px;border-radius: 10px;font-size: 0.7em;}
            .round.blue {background-color: #3EA6CE;}
            .round.orange {background-color: #FF6701;}
           
            #loader{
                    display: block;
                    z-index: 9999;
                    color: #fff;
                    
                    margin-top: 16px;
                    margin-left: 289px;
                    position: fixed;
            }
        </style>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="../lib/html5shiv/html5shiv.js"></script>
        <script src="../lib/respond/respond.src.js"></script>
        <![endif]-->
        
        
    </head>
    <body>
        <div id="loader">
            <h4 style="color: #fff;">Please Wait...</h4>
        </div>
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
                                        {{ Auth::user()->fullName }}<span class="caret"></span>
                                     </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <section>
            <div class="leftpanel">
                <div class="leftpanelinner">
                    <div class="media leftpanel-profile">
                        <div class="media-left"></div>
                        <div class="media-body">
                            <h4 class="media-heading">{{ Auth::user()->fullName }}</h4>
                            <span>{{ Auth::user()->position }}</span>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="mainmenu">
                            <h5 class="sidebar-title">Favorites</h5>
                            <ul class="nav nav-pills nav-stacked nav-quirk">
                                <li><a href="#" rel='tab' ><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
                            </ul>
                            <h5 class="sidebar-title">Main Menu</h5>
                            <ul class="nav nav-pills nav-stacked nav-quirk">
                                <li class="nav-parent {{ Request::is('customer/*') || Request::is('customer') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>Registration</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('customer/*') || Request::is('customer') ? 'active' : '' }}"><a rel='tab' href="{{ url('customer') }}">Customer</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('lab-result/*') || Request::is('lab-result') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-pencil-square-o"></i> <span>LABORATORY RESULT</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('lab-result/*') || Request::is('lab-result') ? 'active' : '' }}"><a rel='tab' href="{{ url('lab-result') }}">Search</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('vaccine/*') || Request::is('vaccine') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-pencil-square-o"></i> <span>VACCINE</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('vaccine/*') || Request::is('vaccine') ? 'active' : '' }}"><a rel='tab' href="{{ url('vaccine') }}">Search</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('xray-result/*') || Request::is('xray-result') || Request::is('xray-result-radiologist/*') || Request::is('xray-result-radiologist') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-pencil-square-o"></i> <span>X-RAY RESULT</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('xray-result/*') || Request::is('xray-result') ? 'active' : '' }}"><a href="{{ url('xray-result') }}">Search</a></li>
                                        <li class="{{ Request::is('xray-result-radiologist/*') || Request::is('xray-result-radiologist') ? 'active' : '' }}"><a href="{{ url('xray-result-radiologist') }}">Radiologist</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('transmittal/*') || Request::is('transmittal') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>TRANSMITTAL</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('transmittal') ? 'active' : '' }}"><a href="{{ url('transmittal') }}">Search</a></li>
                                        <li class="{{ Request::is('transmittal/list') ? 'active' : '' }}"><a href="{{ url('transmittal/list') }}">List</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('sale/*') || Request::is('sale') || Request::is('transaction/*') || Request::is('transaction') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>Sales</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('sale/*') || Request::is('sale') ? 'active' : '' }}"><a href="{{ url('sale') }}">Search</a></li>
                                         <li class="{{ Request::is('transaction/*') || Request::is('transaction') ? 'active' : '' }}"><a href="{{ url('transaction') }}">Transaction</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('inventory/*') || Request::is('inventory') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>Inventory</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('inventory') ? 'active' : '' }}"><a href="{{ url('inventory') }}">Item List</a></li>
                                        <li class="{{ Request::is('inventory/receive') ? 'active' : '' }}"><a href="{{ url('inventory/receive') }}">Receive Items</a></li>
                                        <li class="{{ Request::is('inventory/return') ? 'active' : '' }}"><a href="{{ url('inventory/return') }}">Return Items</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('report/*') || Request::is('report') ? 'active' : '' }}">
                                    <a href=""><i class="fa fa-check-square"></i> <span>Reports</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('report/daily-sales/*') || Request::is('report/daily-sales') ? 'active' : '' }}"><a href="{{ url('report/daily-sales') }}">Daily Sales</a></li>
                                        <li class="{{ Request::is('report/agency-sales/*') || Request::is('report/agency-sales') ? 'active' : '' }}"><a href="{{ url('report/agency-sales') }}">Agency Sales</a></li>
                                        <li class="{{ Request::is('report/summary-sales/*') || Request::is('report/summary-sales') ? 'active' : '' }}"><a href="{{ url('report/summary-sales') }}">Sales Summary</a></li>
                                        <li class="{{ Request::is('report/transaction-summary/*') || Request::is('report/transaction-summary') ? 'active' : '' }}"><a href="{{ url('report/transaction-summary') }}">Transaction Summary</a></li>
                                        <li class="{{ Request::is('report/status/*') || Request::is('report/status') ? 'active' : '' }}"><a href="{{ url('report/status') }}">Status</a></li>
                                        <li class="{{ Request::is('report/consumed-prod/*') || Request::is('report/consumed-prod') ? 'active' : '' }}"><a href="{{ url('report/consumed-prod') }}">Consumed Product</a></li>
                                    </ul>
                                </li>
                                <li class="nav-parent {{ Request::is('agency/*') || Request::is('agency') || Request::is('category') || Request::is('category/*') || Request::is('service/*') || Request::is('service') || Request::is('package/*') || Request::is('package') || Request::is('supply/*') || Request::is('supply') || Request::is('country/*') || Request::is('country') || Request::is('pricing-types/*') || Request::is('pricing-types') || Request::is('association/*') || Request::is('association') || Request::is('agency-pricing/*') || Request::is('agency-pricing') || Request::is('supplies/*') || Request::is('supplies') ? 'active' : '' }}" >    
                                    <a href=""><i class="fa fa-wrench"></i> <span>Utilities</span></a>
                                    <ul class="children">
                                        <li class="{{ Request::is('agency/*') || Request::is('agency') ? 'active' : '' }}"><a href="{{ url('agency') }}">Agency</a></li>
                                        <li class="{{ Request::is('category/*') || Request::is('category') ? 'active' : '' }}"><a href="{{ url('category') }}">Categories</a></li>
                                        <li class="{{ Request::is('service/*') || Request::is('service') ? 'active' : '' }}"><a href="{{ url('service') }}">Services </a></li>
                                        <li class="{{ Request::is('package/*') || Request::is('package') ? 'active' : '' }}"><a href="{{ url('package') }}">Packages</a></li>
                                        <li class="{{ Request::is('association/*') || Request::is('association') ? 'active' : '' }}"><a href="{{ url('association') }}">Association</a></li>
                                        <li class="{{ Request::is('country/*') || Request::is('country') ? 'active' : '' }}"><a href="{{ url('country') }}">Countries</a></li>
                                        <li class="{{ Request::is('supplies/*') || Request::is('supplies') ? 'active' : '' }}"><a href="{{ url('supplies') }}">Supplies</a></li>
                                        <li class="{{ Request::is('pricing-types/*') || Request::is('pricing-types') ? 'active' : '' }}"><a href="{{ url('pricing-types') }}">Pricing Type </a></li>
                                        <li class="{{ Request::is('agency-pricing/*') || Request::is('agency-pricing') ? 'active' : '' }}"><a href="{{ url('agency-pricing') }}">Agency Pricing </a></li>
                                    </ul>
                                </li>
                                <li class="{{ Request::is('supplies') ? 'active' : '' }}" >    
                                    <a href="{{ url('settings') }}"><i class="fa fa-cog"></i> <span>Settings</span></a>
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
            <div id="content">
            <div class="mainpanel">
                <div class="contentpanel">
                    
                    
                    @include('alert')
                    @yield('content')
                    </div>
                </div>
            </div>
            @yield('modal')
            @yield('footer')
        </section>

        <script src="<?php echo asset('public/quirk/lib/jquery/jquery.js') ?>"></script>

        <script src="<?php echo asset('public/quirk/lib/jquery-ui/jquery-ui.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/bootstrap/js/bootstrap.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/jquery-autosize/autosize.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/select2/select2.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/jquery-toggles/toggles.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/jquery-maskedinput/jquery.maskedinput.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/timepicker/jquery.timepicker.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/dropzone/dropzone.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/bootstrapcolorpicker/js/bootstrap-colorpicker.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/datatables/jquery.dataTables.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/lib/select2/select2.js') ?>"></script>
        <script src="<?php echo asset('public/quirk/js/quirk.js') ?>"></script>

        <script src="<?php echo asset('public/js/print.js') ?>"></script>
        <script type="text/javascript">
            $('#dataTable1').dataTable( {
                "order": [],
            } );

            autosize($('.autosize'));
            $('.select').select2();
            $('.select-tag').select2({ tags: true });
            $('.select-limit-one').select2({ maximumSelectionLength: 1 });

            $('.date').mask('9999-99-99');
            $('.dt').datepicker({ 
                dateFormat: 'yy-mm-dd' 
            });

            $(window).load(function() {      //Do the code in the {}s when the window has loaded 
                $("#loader").fadeOut("fast");  //Fade out the #loader div
            });
        </script>
        @yield('js')
        @stack('scripts')

    </body>
</html>
