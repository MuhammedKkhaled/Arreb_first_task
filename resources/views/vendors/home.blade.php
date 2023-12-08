@extends('vendors.layouts.app')



@section('content')
    Welcome Mr : {{ Auth::guard('vendor')->user()->name }}
@endsection