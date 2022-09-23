@extends('errors.layout')

@php
  $error_number = 503;
@endphp

@section('title')
  {{-- सर्भरमा हाल समस्या रहेकोले दुईदिन पछि पुनः प्रयास गर्नुहोला |<br>
  योजना माग गर्ने समय सर्भर नबन्दा सम्म थपिने छ | --}}
  It's not you, it's me.
@endsection

@section('description')
  @php
    $default_error_message = "The server is overloaded or down for maintenance. Please try again later.";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
@endsection
