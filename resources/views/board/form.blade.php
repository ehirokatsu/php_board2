<div class="container ops-main">
    <div class="row">
        <div class="col-md-6">
            <h2>投稿フォーム</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
        @include('board/message')
            @if($target === 'store')
            <form action="/board" method="post" enctype="multipart/form-data">
            @elseif($target === 'update')
            <form action="/board/{{ $board->id }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
            @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="name">投稿</label>
                    <input type="textarea" class="form-control" name="post_text" value="{{ $board->post_text }}" cols="60" rows="8" maxlength=140>
                </div>
                @if(!empty($board->boardimage->image_name))
                <figure>
                <img src="/storage/images/{{$board->boardimage->image_name}}">
                </figure>
                @endif
                <input type="file" name="image">
                <button type="submit" class="btn btn-default">投稿</button>
                <a href="/board">戻る</a>
            </form>
        </div>
    </div>
</div>