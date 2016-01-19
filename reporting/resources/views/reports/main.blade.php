@extends('layouts.master')
@section('content')
    {!! Form::open(['url' => '/getReport', 'id' => 'getReport']) !!}
    <div class="row">
            <div class="large-6 columns">
                @foreach($data["other"] as $other)
                    <label>{!! $other["title"] !!}
                        <select name={!! $other['db_title'] !!}>
                            @foreach($other["value"] as $value)
                                <option value={!! "$value->value" !!}>{!! $value->value !!}</option>
                            @endforeach
                        </select>
                    </label>
                @endforeach
            </div>
            <div class="large-6 columns">
                <label>To:
                    <select name='toSelect'>
                        @foreach($data['date'] as $date)
                             <option value={!! $date["db_title"] !!}>{!! $date["title"] !!}</option>
                        @endforeach
                    </select>
                    <input type="date" id="toDate" name="toDate">
                </label>
                <label>From:
                    <select name='fromSelect'>
                        @foreach($data['date'] as $date)
                             <option value={!! $date["db_title"] !!}>{!! $date["title"] !!}</option>
                        @endforeach
                    </select>
                    <input type="date" id="fromDate" name="fromDate">
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-6 columns">
                {!! Form::submit('Submit', array('class'=>'button')) !!}
            </div>
        </div>
    {!! Form::close() !!}
@stop