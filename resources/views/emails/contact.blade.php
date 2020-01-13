@extends('emails.container')

@section('content')

{{ $remitente_data['name'] }}

{{ $remitente_data['email'] }}

{{ $remitente_data['subject'] }}

{{ $remitente_data['message'] }}

@endsection