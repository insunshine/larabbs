@include('common.error')

<div class="reply-box">
    <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
        <div class="form-group">
            <textarea class="form-control" rows="3"placeholder="share your idea" name="content"></textarea>
        </div>
        <button class="btn btn-primary btn-sm" type="submit">
            <i class="fa fa-share"></i>回复
        </button>
    </form>
</div>
<hr/>