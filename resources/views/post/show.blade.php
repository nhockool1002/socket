@extends('layouts.app')

@section('content')
    <div id="app" class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $post->title }}</div>

                    <div class="card-body">
                        {{ $post->desc }}
                        <ul>
                            <li v-for="comment in comments">
                                @{{ comment.user.name }}: @{{ comment.body }}
                            </li>
                        </ul>
                        <form v-on:submit.prevent="nhut">
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="body">
                                @{{ message }}
                            </div>
                            <button type="submit" class="btn btn-success" v-bind:disabled="body == ''">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>
    <script>
        var app = {
            socket_url: '{{ config('app.socket_url') }}',
            post_id: {{ $post->id }}
        }
    </script>
    <script type="text/javascript" src="/lar57/public/js/demo.js"></script>
@endpush
