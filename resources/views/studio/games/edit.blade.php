@extends('layouts.studio')

@section('page_title')
Edit <strong>{{$game->title}}</strong>
@endsection
@section('show_title', true)

@section('content')
   @include('flash::message')
   @include('layouts.adminlte3.common.errors')

   <div class="card card-tabs card-outline">
       <div class="card-header p-0 pt-1 border-bottom-0">
           <ul class="nav nav-tabs" role="tablist">
               <li class="nav-item">
                   <a class="nav-link {{ !isset($focus) ? 'active' : '' }}" href="#tab_game" data-toggle="pill" role="tab"
                      aria-controls="tab_game" aria-selected="{{ !isset($focus) ? 'true' : 'false' }}">
                       <i class="fas fa-play"></i> Game Information
                   </a></li>
               <li class="nav-item">
                   <a class="nav-link {{ isset($focus) && preg_match("/tab_plugins_.*/", $focus) ? 'active' : '' }}" href="#tab_plugins" data-toggle="pill" role="tab"
                      aria-controls="tab_game" aria-selected="{{ isset($focus) && preg_match("/tab_plugins_.*/", $focus) ? 'true' : 'false'}}">
                       <i class="fas fa-plug"></i> Plugins
                   </a>
               </li>
           </ul>
       </div>
       <div class="card-body">
           <div class="tab-content">
               <div class="tab-pane fade {{ !isset($focus) ? 'active show' : '' }}" id="tab_game">
                   {!! Form::model($game, ['route' => ['studio.games.update', $game->id], 'method' => 'patch']) !!}
                   <div class="row">
                       @include('studio.games.fields')
                   </div>
                   {!! Form::close() !!}
               </div>
               <div class="tab-pane fade {{ isset($focus) && preg_match("/tab_plugins_.*/", $focus) ? 'active show' : '' }}" id="tab_plugins">
                   <!-- Plugins Tab -->
                   @include('studio.games.plugins.show')
               </div>
           </div>
       </div>
   </div>
@endsection
