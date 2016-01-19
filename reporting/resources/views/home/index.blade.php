@extends('layouts.master')
@section('content')
    <div class="row">
    <ul class="accordion" data-accordion role="tablist">
        <?php $count = 0; $otherCount = 0; //dd($fileArray)?>
        @foreach($fileArray as $key => $value)
            <?php //dd($key); ?>
            <li class="accordion-item">
                <!-- The tab title needs role="tab", an href, a unique ID, and aria-controls. -->
                <a href="#panel{!! $count !!}d" role="tab" class="accordion-title" id="panel{!! $count !!}d-heading" aria-controls="panel{!! $count !!}d">{!! $key !!}</a>
                <!-- The content pane needs an ID that matches the above href, role="tabpanel", data-tab-content, and aria-labelledby. -->
                <div id="panel{!! $count !!}d" class="accordion-content" role="tabpanel" data-tab-content aria-labelledby="panel{!! $count !!}d-heading">
                    <ul>
                        <li><a href="">View Total Reports</a></li>
                        <?php //dd($value); ?>
                        @foreach($value as $k => $date)
                            <li>
                                <a href="">{!! $date["parsed_date"] !!}</a>
                            </li>
                            <?php $otherCount++; ?>
                        @endforeach
                    </ul>
                </div>
            </li>
            <?php $count++; ?>
        @endforeach
    </ul>
        {!! Form::open(['url' => '/', 'files' => true, 'id' => 'file_upload']) !!}
        {!! Form::file('file') !!}
        {!! Form::submit('Submit', array('class'=>'button')) !!}
        {!! Form::close() !!}
        <!--<input type="file">-->
    </div>
@stop