@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="text-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid" style="max-width: 1000px;">
        </div>
    </section>
</div>
@endsection

<style>
    .text-center {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 200px;
    flex-direction: column; /* Jika ingin mengatur logo dan judul secara vertikal */
}
</style>
