@extends('layouts.app')

@section('css')
    <style>
        .mae tbody tr{
            font-size: 20px;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h2 class="head text-center">Mean Absolute Error</h2>
        
        <div class="row">
            <div class="col-md-6">
                <h3>Total Produk : {{ $totalProduct }}</h3><br>
            </div>
            <div class="col-md-6">
                <h3 class="pull-right">
                    Total Produk Yang di Rating 
                    <span style="font-weight: bold;"><u>{{ Auth::user()->name }}</u></span> 
                    : {{ $totalProductRating }}
                </h3><br>
            </div>
        </div>
        <table class="table table-striped table-bordered mae">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar Produk</th>
                    <th>ID Produk</th>
                    <th>Nama Produk</th>
                    <th>Rata - Rata Rating</th>
                    <th>Nilai Prediksi</th>
                    <th>Nilai MAE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i=0;
                @endphp
                @foreach( $mae as $item )
                    <tr>
                        <td>{{ $i+=1 }}.</td>
                        <td>
                            <a href="{{ route('member.product.index', ['id' => $item->detail->id]) }}">
                                <img src="{{ asset('storage/'.$item->detail->file->path) }}" class="img-thumbnail" style="height: 150px; width: 150px;">
                            </a>
                        </td>
                        <td>
                            {{ $item->id }}
                        </td>
                        <td width="25%">
                            {{ $item->detail->name }}
                        </td>
                        <td>
                            {{ $item->average != null ? $item->average : 0 }}
                        </td>
                        <td>
                            {{ $item->predict }}
                        </td>
                        <td>
                            {{ $item->mae }}
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="6" style="text-align: center;">Total MAE</td>
                        <td>{{ $totalMae }}</td>
                    </tr>
            </tbody>
        </table>
    </div>
@endsection