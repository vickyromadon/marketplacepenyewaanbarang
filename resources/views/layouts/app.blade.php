<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>RentOnCome</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('rentoncome/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('rentoncome/css/bootstrap-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('rentoncome/css/flexslider.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('rentoncome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('rentoncome/css/jquery.uls.css') }}">
    <link rel="stylesheet" href="{{ asset('rentoncome/css/jquery.uls.grid.css') }}">
    <link rel="stylesheet" href="{{ asset('rentoncome/css/jquery.uls.lcd.css') }}">
    <link rel="stylesheet" href="{{ asset('rentoncome/css/style.css') }}" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('rentoncome/css/easy-responsive-tabs.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/jquery.rateyo.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/fontawesome-stars.css') }}">
    @yield('css')
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="col-md-5 logo">
                <a href="{{ Auth::user() ? route('home') : route('member.index') }}"><span>Rent</span>OnCome</a>
            </div>
            <div class="col-md-4" style="margin-top: 20px;">
                @if( (Request::segment(1)) == 'home' || (Request::segment(1)) == '' )
                    <form action="{{ route('member.category.search') }}" method="post">
                        @csrf
                        <div class="input-group input-group-md">
                            <input type="text" class="form-control" name="search" id="search" placeholder="Cari Produk..." autocomplete="off">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-success btn-flat">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                @endif
            </div>
            <div class="col-md-3">
                <div class="header-right">
                    @if ( !Auth::user() )
                        <a class="account" href="{{ route('login') }}">Masuk</a>
                    @else
                        <div class="dropdown account">
                            <button class="dropdown-toggle buttonAccount" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <i class="fa fa-chevron-circle-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('member.location.index') }}">
                                    Lokasi Produk
                                </a> <br>
                                <a class="dropdown-item" href="{{ route('member.profile.update', ['id' => Auth::user()->id]) }}">
                                    Profil
                                </a> <br>
                                <a class="dropdown-item" href="{{ route('member.history.index') }}">
                                    Pemesanan
                                </a> <br>
                                <a class="dropdown-item" href="{{ route('member.transaction.index') }}">
                                    Transaksi
                                </a> <br>
                                <a class="dropdown-item" href="{{ route('member.delivery.index') }}">   
                                    Pengiriman
                                </a> <br>
                                <a class="dropdown-item" href="{{ route('member.reversion.index') }}">   
                                    Pengembalian
                                </a> <br>
                                <a class="dropdown-item" href="{{ route('member.refund.index') }}">   
                                    Pengembalian Dana
                                </a> <br>
                                <a class="dropdown-item" href="{{ route('member.story.index') }}">   
                                    Riwayat Sewa
                                </a> <br>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div style="min-height: 300px">
        @yield('content')
    </div>

    <footer>
        
        @yield('information')

        <div class="footer-bottom text-center">
            <div class="container">
                <div class="footer-logo">
                    <a href="{{ Auth::user() ? route('home') : route('member.index') }}"><span>Rent</span>OnCOme</a>
                </div>
                <div class="footer-social-icons">
                    <ul>
                        <li><a class="facebook" href="#"><span>Facebook</span></a></li>
                        <li><a class="twitter" href="#"><span>Twitter</span></a></li>
                        <li><a class="flickr" href="#"><span>Flickr</span></a></li>
                        <li><a class="googleplus" href="#"><span>Google+</span></a></li>
                        <li><a class="dribbble" href="#"><span>Dribbble</span></a></li>
                    </ul>
                </div>
                <div class="copyrights">
                    <p> © 2018 RentOnCome. Hak Cipta Dilindungi | Desain Oleh  <a href="#">RentOnCome~Dev</a></p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT  -->
    <script type="application/x-javascript">
        addEventListener("load", function() { 
            setTimeout(hideURLbar, 0); 
        }, false); 

        function hideURLbar(){ 
            window.scrollTo(0,1); 
        }
    </script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/bootstrap-select.js') }}"></script> 
    <script>
        $(document).ready(function () {
            var mySelect = $('#first-disabled2');
            $('#special').on('click', function () {
                mySelect.find('option:selected').prop('disabled', true);
                mySelect.selectpicker('refresh');
            });

            $('#special2').on('click', function () {
                mySelect.find('option:disabled').prop('disabled', false);
                mySelect.selectpicker('refresh');
            });

            $('#basic2').selectpicker({
                liveSearch: true,
                maxOptions: 1
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.leanModal.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.uls.data.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.uls.data.utils.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.uls.lcd.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.uls.languagefilter.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.uls.regionfilter.js') }}"></script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.uls.core.js') }}"></script>
    <script>
        $( document ).ready( function() {
            $( '.uls-trigger' ).uls( {
                onSelect : function( language ) {
                    var languageName = $.uls.data.getAutonym( language );
                    $( '.uls-trigger' ).text( languageName );
                },
                quickList: ['en', 'hi', 'he', 'ml', 'ta', 'fr'] //FIXME
            } );
        });
    </script>
    <script type="text/javascript">
        $(window).load(function() {
            $("#flexiselDemo3").flexisel({
                visibleItems:1,
                animationSpeed: 1000,
                autoPlay: true,
                autoPlaySpeed: 5000,            
                pauseOnHover: true,
                enableResponsiveBreakpoints: true,
                responsiveBreakpoints: { 
                    portrait: { 
                        changePoint:480,
                        visibleItems:1
                    }, 
                    landscape: { 
                        changePoint:640,
                        visibleItems:1
                    },
                    tablet: { 
                        changePoint:768,
                        visibleItems:1
                    }
                }
            });
            
        });
    </script>
    <script type="text/javascript" src="{{ asset('rentoncome/js/jquery.flexisel.js') }}"></script>
    <script src="{{ asset('rentoncome/js/easyResponsiveTabs.js') }}"></script>
    <script src="{{ mix('/js/jquery.toast.min.js') }}"></script>
    <script src="{{ mix('/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ mix('/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ mix('/js/jquery.rateyo.min.js') }}"></script>
    <script src="{{ mix('/js/jquery.barrating.min.js') }}"></script>
    <script src="{{ mix('/js/icheck.min.js') }}"></script>
    <script src="{{ mix('/js/moment.js') }}"></script>
    <script src="{{ mix('/js/daterangepicker.js') }}"></script>
    @yield('js')
</body>
</html>
