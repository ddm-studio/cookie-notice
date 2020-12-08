@extends('statamic::layout')

@section('title','Cookie Notice')

@section('content')
    <publish-form
        title="Cookie Notice Settings"
        action="{{ cp_route('ddm-studio.cookie-notice.index') }}"
        :blueprint='@json($blueprint)'
        :meta='@json($meta)'
        :values='@json($values)'></publish-form>
@stop
