@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="post-title">
            <h3>{{ $post->title }}</h3>
        </div>
        <div class="post-body">
            <p>{{ $post->body }}</p>
        </div>

        @if (Auth::check())
            <form id="commentForm">
                @csrf
                <div class="comments__">
                    <input type="textarea" id="comment" name="comment" placeholder="leave a comment">
                    <button onsubmit="postComment(e)" class="btn btn-primary">Comment</button>
                </div>
            </form>
        @else
            <h2>You should be Logged in to comment.</h2>
            <a href="{{ url('/login') }}">Login>></a>
        @endif
        <h1 style="text-align: center;">Comments</h1>
        <div id="comment__list">
            {{-- <ul>

                <li>{{ $comment->body }}
                    <br>
                    <span> By: {{ App\User::where('id', $comment->user_id)->first()->name }}</span>
                </li>

            </ul> --}}

        </div>

        {{-- <div class="comments">
            <ul>
                @foreach ($post->comments as $comment)
                    <li>{{ $comment->body }}
                        <br>
                        <span> By: {{ App\User::where('id', $comment->user_id)->first()->name }}</span>
                    </li>
                @endforeach
            </ul>

        </div> --}}

        <p id="mula">hello</p>


    </div>
    <script>
        let post_id = {!! $post->id !!};
        // console.log(post_id);
        let channel = Echo.channel('post.' + post_id);
        channel.subscribed(() => {
            console.log('channel subscribed');
        }).listen('NewComment', (comment) => {
            getAllData();
        });

        const createComment = (data) => {
            let ul = "",
                i = 1;
            $.each(data, function(key, value) {
                ul = ul + '<ul>';
                // ul = ul + '<li>' + ++i + '</li>';

                ul = ul + '<li>' + value.body + '<br/><span style="color:red;">' + "Commented by :" + value.user
                    .name + '</span>' + '</li>';

                ul = ul + '</ul>';
            });
            $("#comment__list").html(ul);
        }

        const getAllData = () => {
            axios.get('/api/posts/' + post_id + '/comments')
                .then((response) => {
                    comments = response.data;
                    console.log(comments);
                    createComment(comments);
                })
                .catch((err) => {
                    console.log('error');
                });
        };

        getAllData();
        $('#commentForm').on('submit', function(event) {
            event.preventDefault();
            axios.post('/api/posts/' + post_id + '/comments', {
                api_token: "adhashfftwefwefi",
                body: $('#comment').val(),
            }).then((response) => {
                //let data = response.data;
                // $('#mula').val() = $('#comment').val();
                // console.log(data);
                getAllData();


            }).catch((error) => {
                console.log('error');
            });
        })
    </script>
@endsection
