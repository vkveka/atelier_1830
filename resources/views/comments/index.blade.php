@extends('layouts.app')

@section('title')
    Avis | Atelier 1830
@endsection


@section('content')
    <section id="comments">
        <div class="container-fluid mb-4">
            <div class="col-md-6 mx-auto text-center div_comments">
                @foreach ($comments as $comment)
                    @if ($comment->user)
                        <h5><span>{{ $comment->user->firstname }}</span></h5>
                    @else
                        <h5><span><i>Utilisateur inconnu</i></span></h5>
                    @endif
                    <h6>
                        @php
                            echo \Carbon\Carbon::parse($comment->created_at)->translatedFormat('l d F Y à H\hi');
                        @endphp
                    </h6>
                    <h5 class="title_comment">{{ $comment->title }}</h5>
                    @for ($i = 1; $i <= $comment->note; $i++)
                        <i class="fas fa-star" style="color: #fedc18"></i>
                    @endfor
                    <div class="quote_comment">
                        <p>{!! nl2br(e($comment->content)) !!}</p>
                    </div>
                    <div class="the_red_line mx-auto" style="width: 70%; border-top: dashed 2px #a44a4a; margin: 60px 0">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
