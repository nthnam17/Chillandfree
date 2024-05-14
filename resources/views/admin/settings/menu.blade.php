@extends('admin.layouts.index')
@section('pageTitle', 'Menu')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Cài đặt</li>
        <li class="breadcrumb-item active">Menu</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    Menu
                </div>
                <div class="card-body">
                    {!! Menu::render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    {!! Menu::scripts() !!}
@endpush




