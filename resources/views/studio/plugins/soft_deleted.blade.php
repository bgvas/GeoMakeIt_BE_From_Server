<div class="card">
    <div class="card-header with-border">
        <h3 class="card-title">Archived</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        @foreach($plugins as $plugin)
            <div class="col-md-4">
                <div class="card card-widget widget-user">
                    <div class="widget-user-header bg-info" style="height: auto;">
                        <h3 class="widget-user-username"><strong>{{ $plugin->title }}</strong></h3>
                        <p>{{ $plugin->short_description }}</p>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="description-block">
                                    {!! Form::open(['route' => ['studio.plugins.restore', $plugin], 'method' => 'post']) !!}
                                    {!! Form::button('<i class="fas fa-refresh"></i> Restore', ['type' => 'submit', 'class' => 'btn btn-success ']) !!}
                                    {!! Form::close() !!}
                                </div>
                                <div class="description-block">
                                    {!! Form::open(['route' => ['studio.plugins.forceDelete', $plugin], 'method' => 'delete']) !!}
                                    {!! Form::button('<i class="fas fa-trash"></i> PERMANENTLY DELETE', ['type' => 'submit', 'class' => 'btn btn-danger ', 'onclick' => "return confirm('Are you sure? This is irreversible!')"]) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
