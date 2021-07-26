@extends('layouts.adminlte3.default')
@section('meta_title', 'Search Results')
@section('meta_description', 'Search Results')
@section('page_title', 'Site Search')
@section('show_title', true)
@section('content')
    {{-- TODO: Beautify Styling --}}
    @foreach($resultCollections as $collectionName => $collection)
        @if (count($collection) > 0)
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"> {{ ucfirst($collectionName) }}s</i>
                            <small class="float-right">Date: 2/10/2014</small>
                        </h4>
                    </div>
                </div>

                <div class="row invoice-info">
                @foreach($collection as $result)
                    @includeFirst([
                        "layouts.adminlte3.modules.search.result-$collectionName",
                        "layouts.adminlte3.modules.search.result"
                    ])
                @endforeach
                </div>
            </div>
        @endif
    @endforeach
@endsection
