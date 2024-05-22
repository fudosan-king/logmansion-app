@extends('adminlte::page')

@section('title', config('estate_labels.contact_detail'))


@section('content_header')
<h1>{{ config('estate_labels.contact_detail') }}</h1>
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

    .message-time {
        font-style: italic;
        font-size: 14px;
    }

    .alert.alert-primary {
        position: relative;
    }

    .fas.fa-images.float-right.cursor-pointer {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
    }
</style>
@stop

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="chat-container">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="optionsRow1">{{$contact->client->client_name}}様</label>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="optionsRow1"> {{ $contact->contact_title }} : </label>
                        </div>
                    </div>
                    <div class="message-container">
                        @if($contactMessages)

                        @foreach($contactMessages as $message)

                        @if($message->author_type == 0)

                        <div class="message">
                            <span class="message-time">{{$message->created_at}}</span>
                            <div class="alert alert-primary" role="alert">
                                <i class="fas fa-comment"></i>
                                {{$message->contact_message}}
                                <?php $files = App\Models\ContactFile::where('contact_detail_id', $message->id)->get(); ?>
                                @if(count($files) > 0)
                                <i class="fas fa-images float-right cursor-pointer" data-toggle="modal" data-target="#listimageModal{{$message->id}}"></i>
                                @endif
                            </div>
                        </div>

                        <!-- modal show list image -->
                        <div class="modal fade" id="listimageModal{{$message->id}}" tabindex="-1" role="dialog" aria-labelledby="listimageModalLabel{{$message->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="listimageModalLabel{{$message->id}}">List Image</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">

                                                @foreach($files as $file)

                                                <div class="card mr-4">
                                                    <img src="{{ Storage::url($file->path_file) }}" alt="Image" class="img-fluid img-thumbnail thumbnail-image cursor-pointer" data-toggle="modal" data-target="#imageModal{{$file->id}}">
                                                </div>

                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @elseif($message->contact_message != null)

                        <div class="message">
                            <span class="message-time">{{$message->created_at}}</span><br>
                            <span>{{$message->user->name}}</span>
                            <div class="alert alert-secondary" role="alert">
                                <i class="fas fa-comment"></i>
                                {{$message->contact_message}}
                            </div>
                        </div>

                        @endif

                        @if($message->contact_note != null)

                        <div class="message">
                            <span class="message-time">{{$message->created_at}}</span>
                            <div class="alert alert-secondary" role="alert">
                                <i class="fas fa-sticky-note"></i>
                                {{$message->contact_note}}
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
                                <label for="optionsRow1">返信：</label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <textarea type="text" name="contact-message" class="form-control" aria-describedby=""></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="optionsRow1">メモ&nbsp;&nbsp;&nbsp;お客様には送信されません</label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <textarea type="text" name="contact-note" class="form-control" aria-describedby=""></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="optionsRow1">{{ config('estate_labels.status') }}</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            @foreach(array_slice(config('const.contact_status'), 1, null, true) as $key => $value)
                            <div class="col">
                                <input id="option_{{$key}}" type="radio" name="status" value="{{ $key }}" @if ($key==$contact->contact_status)
                                checked
                                @elseif ($key == 1)
                                checked
                                @endif
                                >
                                <label for="option_{{$key}}">{{ $value }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="input-group-append float-right">
                            <button class="btn btn-primary" type="submit" id="">{{ __('messages.save') }}</button>
                        </div>
                        <div class="float-left">
                            <a href="{{ route('estcontact') }}" class="btn btn-default go-back" id="">{{ __('messages.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal show large image -->
<div class="modal fade" id="largeImageModal" tabindex="-1" role="dialog" aria-labelledby="largeImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>


@stop


@section('js')
<script>
    $(document).ready(function() {
        $('.thumbnail-image').click(function() {
            var imagePath = $(this).attr('src');

            var modalContent = '<div class="modal-dialog modal-dialog-centered modal-xl" role="document">';
            modalContent += '<div class="modal-content">';
            modalContent += '<div class="modal-header">';
            modalContent += '<h5 class="modal-title">Large Image</h5>';
            modalContent += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            modalContent += '<span aria-hidden="true">&times;</span>';
            modalContent += '</button>';
            modalContent += '</div>';
            modalContent += '<div class="modal-body">';
            modalContent += '<img src="' + imagePath + '" class="img-fluid" alt="Large Image">';
            modalContent += '</div>';
            modalContent += '</div>';
            modalContent += '</div>';

            $('#largeImageModal').html(modalContent);
            $('#largeImageModal').modal('show');
        });
    });
</script>
@stop

@section('plugins.Datatables', true)
@section('plugins.Select2', true)