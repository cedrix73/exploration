@extends('errors::minimal')

@section('title', __('Page expirée'))
@section('code', '419')
@section('message', __('Page Expirée: La requête n\'a pas été authentifiée contre le CSRF !'))
