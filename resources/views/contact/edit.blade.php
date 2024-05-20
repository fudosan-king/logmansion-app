@extends('adminlte::page')

@section('title', config('estate_labels.title_estate'))


@section('content_header')
<h1>{{ config('estate_labels.title_estate') }}</h1>
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    #tblData_filter {
        display: none;
    }

    .chat-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .message-container {
        overflow-y: auto;
        max-height: 500px;
    }

    .message {
        margin-bottom: 10px;
    }

    .thumbnail-image {
        max-width: 100%;
        max-height: 100%;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .img-thumbnail {
        width: 200px;
        height: 200px;
        object-fit: cover;
    }

    .go-back {
        background-color: #f8f9fa;
        border-color: #ddd;
        color: #444;
    }
</style>
@stop

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            @foreach($contactFiles as $file)
            <div class="card mr-4 cursor-pointer">
                <img src="{{ Storage::url($file->contact_file) }}" alt="Hình ảnh" class="img-fluid img-thumbnail thumbnail-image" data-toggle="modal" data-target="#imageModal">
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="chat-container">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="optionsRow1">{{$contact->client->client_name}}</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="optionsRow1">場所：{{ Config::get('const.contact_spot.'.$contact->contact_spot) }}</label>
                        </div>
                    </div>
                    <div class="message-container">
                        @if($contactMessages)

                        @foreach($contactMessages as $message)
                        @if($message->author_type == 0)
                        <div class="message">
                            <div class="alert alert-primary" role="alert">
                                {{$message->contact_message}}
                            </div>
                        </div>
                        @else
                        <div class="message">
                            <div class="alert alert-secondary" role="alert">
                                {{$message->contact_message}}
                            </div>
                        </div>
                        @endif
                        @endforeach

                        @endif

                    </div>
                    <form method="POST" enctype="multipart/form-data" action="{{route('estcontact.update', ['id' => $contact->contact_id])}}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col">
                                <label for="optionsRow1">Choose an option:</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="radio" id="option1" name="options-status" value="1" checked>
                                <label for="option1">回答待ち</label>
                            </div>
                            <div class="col">
                                <input type="radio" id="option2" name="options-status" value="2">
                                <label for="option2">応答済</label>
                            </div>
                            <div class="col">
                                <input type="radio" id="option3" name="options-status" value="3">
                                <label for="option3">対応終了</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="optionsRow1">Choose an option:</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <input type="radio" id="option4" name="options-response" value="0" checked>
                                <label for="option4">この内容で送信</label>
                            </div>
                            <div class="col">
                                <input type="radio" id="option5" name="options-response" value="1">
                                <label for="option5">登録のみ</label>
                            </div>
                            <div class="col">
                                <input type="radio" id="option6" name="options-response" value="2">
                                <label for="option6">電話等で対応</label>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <textarea type="text" name="contact-message" class="form-control" placeholder="Type your message..." aria-label="Type your message..." aria-describedby=""></textarea>
                        </div>
                        <div class="input-group-append float-right">
                            <button class="btn btn-primary" type="submit" id="">{{ __('messages.save') }}</button>
                        </div>
                        <div class="float-left">
                            <a href="{{ URL::previous() }}" class="btn btn-default go-back" id="">{{ __('messages.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Thumbnail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="Thumbnail" class="img-fluid" id="thumbnailPreview" style="width: 100%;">
            </div>
        </div>
    </div>
</div>
@stop


@section('js')
<script>
    $(document).ready(function() {
        $('.thumbnail-image').click(function() {
            var src = $(this).attr('src');
            $('#thumbnailPreview').attr('src', src);
        });
    });
</script>
@stop

@section('plugins.Datatables', true)