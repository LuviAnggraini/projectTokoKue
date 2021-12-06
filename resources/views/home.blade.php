@extends('layouts.app')

@section('content')

<img src="{{ url('images/logo.png') }}" width="250" class="rounded mx-auto d-block"><br>
<h2 align="center">Welcome to Ossena Cake's</h2><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p align="justify">
                        Ossena Cake's adalah salah satu usaha toko dan juga produsen Cake & Tart yang berada di Ikkebukuro. 
                        Ossena Cake's menawarkan berbagai pilihan Cake & bahkan Tart sesuai moment atau acara apa yang sedang 
                        anda adakan baik itu acara ulang tahun, ater-ater nikahan, ater-ater kenduri, arisan, rapat, seminar, 
                        wisuda, weeding, tour & travel, dan lain sebagainya. Ossena Cake's memiliki Cake & Tart antara lain 
                        Mandarin, Brownis oven & kukus, Cake Tales, Tart Cis, Maffin, Roti Manis, Sus Via, Karamel, Bika Ambon, 
                        Chiffon Cake, Banana Cake, Sirsat Cake, Lapis Mocca, Lapis Surakarta, Lapis Magelangan, Bolu Batik, 
                        Bolu Kukus Pelangi, Roll Bolu Batik, Roll Mandarin, Roll Rainbow.dll. Semua Cake & Tart diolah dan 
                        diracik dengan bahan dasar yang berkualitas, tanpa bahan pengawet, proses pengerjaan yang higienis, 
                        dan di dukung dengan karyawan berpengalaman dan peralatan produksi yang canggih untuk menghasilkan 
                        produksi cake & tart yang berkuallitas dengan harga yang terjangkau.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
