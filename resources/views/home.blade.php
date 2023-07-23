@extends('layout')
@section('content')
     <!-- Post content-->
     @foreach ($result as $row)
            <?php
                preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $row->content, $image);
                $image = $image['src'];
            ?>  
     
        <article>
            <!-- Post header-->
            <header class="mb-4">
                <!-- Post title-->
                <h2 class="fw-bolder mb-1"><a href='{{ url("article/$row->slug") }}' title="{{ $row->title }}">{{ $row->title }}</a></h2>
                <!--  author -->
                {{-- <p class="lead">
                    by <a href="#">{{ $row->name_author }}</a>
                </p>

                <hr> --}}
            {{--  @if($image)
                    <img src='{{ $image }}' alt="" style="max-width: 100%">
                @endif --}}
                <!-- Post meta content-->
                <div class="text-muted fst-italic mb-2">Posted on {{date('M,d Y',strtotime($row->created_at))}} by {{ $row->name_author }}</div>
                <!-- Post categories-->
                <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{ $row->name_categories }}</a>
            {{--  <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{ $row->name_categories }}</a> --}}
            </header>
            
            <!-- Post content-->
            <section class="mb-5">
                {{\Illuminate\Support\str::limit(strip_tags($row->content),200)}}
                <p><a href='{{ url("article/$row->slug") }}' title="{{ $row->title }}">Read More &raquo;</a></p>
            </section>
        </article> 
    @endforeach
    
@endsection