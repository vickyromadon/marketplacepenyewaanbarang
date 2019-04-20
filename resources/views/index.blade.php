@extends('layouts.app')

@section('content')
    <!-- BANNER -->
    <div class="main-banner banner text-center">
        <div class="container-fluid">    
            <h1>MARKETPLACE SEWA MENYEWA BARANG</h1>
            <p>Sewa Produk Apa Pun Secara Online Dengan RentOnCome</p>
            <a href="{{ route('member.howitworks') }}">Cara Kerja</a>
        </div>
    </div>

    <div class="content">
        <div class="categories">
            <div class="container">
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab1">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-music"></i></div>
                                <h4 class="clrchg">Alat - Alat Musik</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab2">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-laptop"></i></div>
                                <h4 class="clrchg">Elektronik & Peralatan</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab3">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-car"></i></div>
                                <h4 class="clrchg">Kendaraan</h4>
                            </div>
                        </div>
                    </a>
                </div>  
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab4">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-bank"></i></div>
                                <h4 class="clrchg">Properti</h4>
                            </div>
                        </div>
                    </a>
                </div>  
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab5">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-wheelchair"></i></div>
                                <h4 class="clrchg">Perabotan</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab6">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-bullhorn"></i></div>
                                <h4 class="clrchg">Peralatan audio visual</h4>
                            </div>
                        </div>
                    </a>
                </div>  
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab7">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-table"></i></div>
                                <h4 class="clrchg">Perabotan Kantor</h4>
                            </div>
                        </div>
                    </a>
                </div>  
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab8">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-female"></i></div>
                                <h4 class="clrchg">Kostum, Gaun, dan Aksesori</h4>
                            </div>
                        </div>
                    </a>
                </div>  
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab9">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-gamepad"></i></div>
                                <h4 class="clrchg">Aksesoris dan Mainan Bayi</h4>
                            </div>
                        </div>
                    </a>
                </div>  
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab10">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-tasks"></i></div>
                                <h4 class="clrchg">Perlengkapan Acara dan Pernikahan</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab11">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-binoculars"></i></div>
                                <h4 class="clrchg">Perlengkapan Petualangan</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-2 focus-grid">
                    <a href="{{ route('member.main_categories') }}#parentVerticalTab12">
                        <div class="focus-border">
                            <div class="focus-layout">
                                <div class="focus-image"><i class="fa fa-medkit"></i></div>
                                <h4 class="clrchg">Perlengkapan Medis</h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="trending-ads">
            <div class="container">
            <!-- slider -->
            <div class="trend-ads">
                @if( Auth::user() )
                    <h2>Produk Yang di Rekomendasikan</h2>
                @else
                    <h2>Produk Yang Sering di Lihat</h2>
                @endif
                    <ul id="flexiselDemo3">
                        @if( count($products) >= 0 )
                        <li>
                            @php
                                $loop1 = 0;
                                if ( count($products) >= 4 )
                                    $loop1 = 4;
                                else
                                    $loop1 = count($products);
                            @endphp
                            @for( $i = 0; $i < $loop1; $i++ )
                                <div class="col-md-3 biseller-column">
                                    <a href="{{ route('member.product.index', ['product' => $products[$i]->id]) }}">
                                        <img src="{{ asset('storage/'.$products[$i]->file->path) }}" style="width: 200px; height: 200px;">
                                        <span class="price">Rp. {{ number_format($products[$i]->price) }}</span>
                                    </a> 
                                    <div class="ad-info">
                                        <h5>{{ substr($products[$i]->name, 0, 20) }}</h5>
                                        <h5 class="label label-info pull-right"><i class="fa fa-eye"></i> {{ $products[$i]->view }}</h5>
                                        <span>{{\Carbon\Carbon::parse($products[$i]->created_at)->diffForHumans()}}</span>
                                    </div>
                                </div>
                            @endfor
                        </li>
                        @endif
                        @if( count($products) > 4 )
                        <li>
                            @php
                                $loop2 = 0;
                                if ( count($products) >= 8 )
                                    $loop2 = 8;
                                else
                                    $loop2 = count($products);
                            @endphp
                            @for( $i = 4; $i < $loop2; $i++ )
                                <div class="col-md-3 biseller-column">
                                    <a href="{{ route('member.product.index', ['product' => $products[$i]->id]) }}">
                                        <img src="{{ asset('storage/'.$products[$i]->file->path) }}" style="width: 200px; height: 200px;">
                                        <span class="price">Rp. {{ number_format($products[$i]->price) }}</span>
                                    </a> 
                                    <div class="ad-info">
                                        <h5>{{ substr($products[$i]->name, 0, 20) }}</h5>
                                        <h5 class="label label-info pull-right"><i class="fa fa-eye"></i> {{ $products[$i]->view }}</h5>
                                        <span>{{\Carbon\Carbon::parse($products[$i]->created_at)->diffForHumans()}}</span>
                                    </div>
                                </div>
                            @endfor
                        </li>
                        @endif
                        @if( count($products) > 8 )
                        <li>
                            @php
                                $loop3 = 0;
                                if ( count($products) >= 12 )
                                    $loop3 = 12;
                                else
                                    $loop3 = count($products);
                            @endphp
                            @for( $i = 8; $i < $loop3; $i++ )
                                <div class="col-md-3 biseller-column">
                                    <a href="{{ route('member.product.index', ['product' => $products[$i]->id]) }}">
                                        <img src="{{ asset('storage/'.$products[$i]->file->path) }}" style="width: 200px; height: 200px;">
                                        <span class="price">Rp. {{ number_format($products[$i]->price) }}</span>
                                    </a> 
                                    <div class="ad-info">
                                        <h5>{{ substr($products[$i]->name, 0, 20) }}</h5>
                                        <h5 class="label label-info pull-right"><i class="fa fa-eye"></i> {{ $products[$i]->view }}</h5>
                                        <span>{{\Carbon\Carbon::parse($products[$i]->created_at)->diffForHumans()}}</span>
                                    </div>
                                </div>
                            @endfor
                        </li>
                        @endif
                    </ul>
                </div>   
            </div>            
        </div>
    </div>
@endsection

@section('information')
    <div class="footer-top">
        <div class="container">
            <div class="foo-grids">
                <div class="col-md-3 footer-grid">
                    <h4 class="footer-head">RentOnCome ?</h4>
                    <p>{!! $data->description !!}</p>
                </div>
                <div class="col-md-3 footer-grid">
                    <h4 class="footer-head">Bantuan</h4>
                    <ul>
                        <li><a href="{{ route('member.faqs') }}">FAQ</a></li>
                        <li><a href="{{ route('member.message.index') }}">Pesan</a></li>
                    </ul>
                </div>
                <div class="col-md-3 footer-grid">
                    <h4 class="footer-head">Informasi</h4>
                    <ul>
                        <li><a href="{{ route('member.location') }}">Peta Lokasi</a></li>   
                        <li><a href="{{ route('member.termsofuse') }}">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('member.privacypolicy') }}">Kebijakan Hukum</a></li>
                        <li><a href="{{ route('owner.register') }}">Jadilah Pemilik</a></li>  
                    </ul>
                </div>
                <div class="col-md-3 footer-grid">
                    <h4 class="footer-head">Hubungi kami</h4>
                    <address>
                        <ul class="location">
                            <li><span class="glyphicon glyphicon-map-marker"></span></li>
                            <li>{{ $data->location->title }}</li>
                            <div class="clearfix"></div>
                        </ul>   
                        <ul class="location">
                            <li><span class="glyphicon glyphicon-earphone"></span></li>
                            <li>{{ $data->phone }}</li>
                            <div class="clearfix"></div>
                        </ul>   
                        <ul class="location">
                            <li><span class="glyphicon glyphicon-envelope"></span></li>
                            <li>{{ $data->email }}</li>
                            <div class="clearfix"></div>
                        </ul>                       
                    </address>
                </div>
                <div class="clearfix"></div>
            </div>                      
        </div>  
    </div>
@endsection