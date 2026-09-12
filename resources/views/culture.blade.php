@extends('layouts.app')

@section('title', 'Cultural Heritage & History - Puntland Tourism')

@section('content')
<div style="position:relative; height:380px; background:linear-gradient(180deg, rgba(10,25,47,0.4) 0%, rgba(10,25,47,0.95) 100%), url('{{ asset('images/destinations/eyl_castle.jpg') }}') center/cover no-repeat;">
    <div class="container" style="height:100%; display:flex; align-items:flex-end; padding-bottom:3rem;">
        <div>
            <div class="badge badge-gold" style="margin-bottom:0.5rem;"><i class="fa-solid fa-landmark"></i> Rich Somali Traditions</div>
            <h1 style="font-size:3rem; margin-bottom:0.5rem; color:#fff;">Puntland Cultural Heritage</h1>
            <p style="font-size:1.1rem; color:#cbd5e1;">Centuries of ancient frankincense trade routes, maritime dhow navigation, and heroic stone fortresses</p>
        </div>
    </div>
</div>

<div class="container" style="padding: 4rem 0;">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:3rem; margin-bottom:4rem; align-items:center;">
        <div>
            <div class="badge badge-region" style="margin-bottom:0.5rem;">Ancient Trade</div>
            <h2 style="font-size:2.2rem; margin-bottom:1rem; color:var(--text-heading);">The Land of Frankincense & Myrrh</h2>
            <p style="color:var(--text-main); font-size:1.02rem; line-height:1.8; margin-bottom:1rem;">
                Known historically as part of the ancient "Land of Punt", Puntland has produced the world’s finest Frankincense (<em>Boswellia sacra</em> &amp; <em>Boswellia frereana</em>) for over 3,000 years. Ancient Pharaohs of Egypt dispatched famed maritime expeditions to Puntland's ports to trade gold, silk, and linen for aromatic gums and resins.
            </p>
            <p style="color:var(--text-muted); font-size:0.95rem;">
                Today, visitors to the Cal Madow highlands and Bari region can meet traditional incense harvesters and observe age-old resin tapping practices.
            </p>
        </div>
        <div>
            <img src="{{ asset('images/destinations/cal_madow.jpg') }}" style="width:100%; height:320px; object-fit:cover; border-radius:16px; border:1px solid var(--border-color);">
        </div>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:3rem; align-items:center;">
        <div>
            <img src="{{ asset('images/destinations/qandala_coast.jpg') }}" style="width:100%; height:320px; object-fit:cover; border-radius:16px; border:1px solid var(--border-color);">
        </div>
        <div>
            <div class="badge badge-gold" style="margin-bottom:0.5rem;">Maritime Mastery</div>
            <h2 style="font-size:2.2rem; margin-bottom:1rem; color:var(--text-heading);">Dhow Shipbuilding & Coastal Seaports</h2>
            <p style="color:var(--text-main); font-size:1.02rem; line-height:1.8; margin-bottom:1rem;">
                Puntland’s strategic position along the Gulf of Aden and Indian Ocean fostered a centuries-old seafaring civilization. Historic ports like Bosaso, Qandala, Calula, and Hafun served as thriving commerce nodes connecting East Africa with the Arabian Peninsula, Persia, and India.
            </p>
            <p style="color:var(--text-muted); font-size:0.95rem;">
                Handcrafted wooden dhow boats are still built using traditional tools along the coastline, carrying rich stories of Somali navigation.
            </p>
        </div>
    </div>
</div>
@endsection
