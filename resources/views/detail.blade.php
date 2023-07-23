@extends('layout')
@section('content')
     <!-- Post content-->
    
         <style>
            h3{
                display: inline-block;
            }
            .comment-date{
                display: inline-block;
                color: #AAAAAA;
                font: 12px Roboto,Arial,sans-serif;
            }
            .fw-bold{
                display: inline-block;
            }
         </style>
     
     <article>
        <!-- Post header-->
        <header class="mb-4">
            <!-- Post title-->
            <h1 class="fw-bolder mb-1">{{ $row->title }}</h1>
            <!--  author -->
            {{-- <p class="lead">
                by <a href="#">{{ $row->name_author }}</a>
            </p>

            <hr> --}}

            <!-- Post meta content-->
            <div class="text-muted fst-italic mb-2">Posted on {{date('M,d Y',strtotime($row->created_at))}} by {{ $row->name_author }}</div>
            <!-- Post categories-->
            <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{ $row->name_categories }}</a>
            {{-- <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{ $row->name_categories }}</a> --}}
        </header>
        
        <!-- Post content-->
        <section class="mb-5">
            {!! $row->content !!}
        </section>
    </article> 
    
    <!-- Comments section-->

     <section class="mb-5">
        <div class="card bg-light">
            <div class="card-body">
                <h3 class="comment-title">Comments</h3>
                <small>({{ $comments->count() }})</small>
                <br>
                <br>
                @if ($comments->isEmpty())
                        <p>No comments available.</p>
                @else
            
                    @foreach ($comments as $comment)
                            <div class="comment mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="Profile Image" />
                                    </div>
                                    <div class="ms-3">
                                        <div class="fw-bold">{{ $comment->users_name }}</div>
                                        <p>{!! $comment->content !!}</p>
                                        <div class="comment-date">{{ $comment->created_at }}</div>
                                        <div class="comment-actions">
                                            <button class="btn btn-sm btn-primary reply-toggle" data-comment-id="{{ $comment->id }}">Reply</button>
                                            <button class="btn btn-sm btn-success like-toggle" data-comment-id="{{ $comment->id }}">Like ({{ $comment->like_count }})</button>
                                            <button class="btn btn-sm btn-danger dislike-toggle" data-comment-id="{{ $comment->id }}">Dislike ({{ $comment->dislike_count }})</button>
                                        </div>
                                        @if ($comment->replies)
                                            <div class="replies mt-4">
                                                @foreach ($comment->replies as $reply)
                                                    <div class="d-flex mb-4">
                                                        <div class="flex-shrink-0">
                                                            <img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="Profile Image" />
                                                        </div>
                                                        <div class="ms-3">
                                                            <div class="fw-bold">{{ $reply->user_name }}</div>
                                                            <p>{!! $reply->content !!}</p>
                                                            <div class="comment-date">{{ $reply->created_at }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="reply-form" id="reply-form-{{ $comment->id }}" style="display: none;">
                                            <form class="form-group" action="{{ route('storeReply') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                <textarea class="form-control" rows="3" name="content" placeholder="Leave a reply" required></textarea>
                                                <button type="submit" class="btn btn-primary btn-sm mt-2">Submit Reply</button>
                                            </form>
                                        </div>                          
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @endif
           
            </div>
        </div>
    </section>
   
     <section class="mb-5">
        <div class="card bg-light">
            <div class="card-body">
               
                <!-- Comment form-->
                <form class="form-group" action="{{ route('comments') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="d-flex mb-4">
                        <input type="hidden" name="post_id" value="{{ $row->id }}" >
                        <textarea class="form-control" rows="3" name="content" placeholder="Join the discussion and leave a comment!" required></textarea>
                        @if ($errors->has('content'))
                            <small class="form-text invalid-feedback">{{ $errors->first('content') }}</small>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary ">Add Comment</button>
                </form>
                <br>
                
            </div>
        </div>
    </section> 
    
    <script>
        $(document).ready(function() {
            $('.reply-toggle').on('click', function() {
                var commentId = $(this).data('comment-id');
                var replyForm = $('#reply-form-' + commentId);
                
                replyForm.slideToggle();
            });
        });
    </script>
    

@endsection