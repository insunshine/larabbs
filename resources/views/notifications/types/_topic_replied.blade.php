<div class="media">
    <div class="avatar pull-left">
        <a href="{{ route('users.show', $notification->date['user_id']) }}">
            <img class="media-object img-thumbnail" alt="{{$notification->data['user_name'] }}" src="{{ $notification->data['user_avatar'] }}" style="width: 48px;height: 48px;">
        </a>
    </div>

    <div class="infos">
        <div class="media-heading">
            <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
            评论了
            <a href="{{ $notification->data['topic_link'] }}">{{ $notification->data['topic_title'] }}</a>

            {{-- 回复删除按钮--}}
            @can('destroy', $reply)
            <span class="media pull-right">
                <form action="{{ route('replies.destroy', $reply->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-default btn-xs pull-left">
                        <i class="glyphicon glyphicon-trash"></i>
                    </button>
                </form>
            </span>
            @endcan
        </div>
        <div class="reply-content">
            {!! $notification->data['reply_content'] !!}
        </div>
    </div>
</div>
<hr/>