@section('title')
    Otázka| Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Otázka</h2>


            <div class="card mt-4 border-primary shadow">
                <div class="card-header bg-primary text-white">
                    Názov
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-0">{{ $question->title }}</h5>
                </div>
            </div>

            <div class="card mt-4 border-success shadow">
                <div class="card-header bg-success text-white">
                    Otázka pre študenta
                </div>
                <div class="card-body">
                    {!! $question->question !!}
                </div>
            </div>

            <div class="card mt-4 border-info shadow">
                <div class="card-header bg-info text-white">
                    Možné riešenia
                </div>
                @if ($question->type <= 3)
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            {!! $question->answer == 'a' ? '<span class="text-success">'.  $question->a .' <i class="fas fa-check"></i></span>': '<span class="text-danger">'. $question->a .' <i class="fas fa-times"></i></span>' !!}
                        </li>
                        <li class="list-group-item">
                            {!! $question->answer == 'b' ? '<span class="text-success">'.  $question->b .' <i class="fas fa-check"></i></span>': '<span class="text-danger">'. $question->b .' <i class="fas fa-times"></i></span>' !!}
                        </li>
                        <li class="list-group-item">
                            {!! $question->answer == 'c' ? '<span class="text-success">'.  $question->c .' <i class="fas fa-check"></i></span>': '<span class="text-danger">'. $question->c .' <i class="fas fa-times"></i></span>' !!}
                        </li>
                        <li class="list-group-item">
                            {!! $question->answer == 'd' ? '<span class="text-success">'.  $question->d .' <i class="fas fa-check"></i></span>': '<span class="text-danger">'. $question->d .' <i class="fas fa-times"></i></span>' !!}
                        </li>
                    </ul>
                @endif

                @if ($question->type == 4)
                    <div class="row">
                        <div class="col-md-6 text-center mb-2 mt-2 question-possibilities-show">
                            <img src="{{$question->a}}" alt="odpoved a" class="img-thumbnail d-block mx-auto mt-2">
                            {!! $question->answer == 'a' ? '<span class="text-success"><i class="fas fa-check"></i></span>': '<span class="text-danger"><i class="fas fa-times"></i></span>' !!}
                        </div>

                        <div class="col-md-6 text-center mb-2 mt-2 question-possibilities-show">
                            <img src="{{$question->b}}" alt="odpoved b" class="img-thumbnail d-block mx-auto  mt-2">
                            {!! $question->answer == 'b' ? '<span class="text-success"><i class="fas fa-check"></i></span>': '<span class="text-danger"><i class="fas fa-times"></i></span>' !!}
                        </div>

                        <div class="col-md-6 text-center mb-2 question-possibilities-show">
                            <img src="{{$question->c}}" alt="odpoved c" class="img-thumbnail d-block mx-auto  mt-2">
                            {!! $question->answer == 'c' ? '<span class="text-success"><i class="fas fa-check"></i></span>': '<span class="text-danger"><i class="fas fa-times"></i></span>' !!}
                        </div>

                        <div class="col-md-6 text-center mb-2 question-possibilities-show">
                            <img src="{{$question->d}}" alt="odpoved d" class="img-thumbnail d-block mx-auto  mt-2">
                            {!! $question->answer == 'd' ? '<span class="text-success"><i class="fas fa-check"></i></span>': '<span class="text-danger"><i class="fas fa-times"></i></span>' !!}
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card border-primary mt-4 shadow">
                        <div class="card-header text-white bg-primary">
                            Kategórie
                        </div>
                        @if ($question->categories->isEmpty())
                            <div class="card-body">
                                <p class="card-text">Nie je zaradená do žiadnej kategórie</p>
                            </div>
                        @else
                            <div class="card-body">
                                @foreach ($question->categories as $item)
                                    <p class="card-text h5">
                                        {{$item->name}}
                                    </p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-success mt-4 shadow">
                        <div class="card-header text-white bg-success">
                            Hodnotenie
                        </div>
                        <div class="card-body">
                            <p class="card-text h5">
                                @php
                                    $rating = $question->ratings->avg('rating');
                                @endphp
                                @if(empty($rating) || $rating < 1)
                                    <span class="badge badge-pill badge-danger">Nehodnotené</span>
                                @elseif($rating >=4 )
                                    <span class="badge badge-pill badge-success">{{$rating}}</span>
                                @else
                                    <span class="badge badge-pill badge-warning">{{$rating}}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->is_admin)
                    <div class="col-lg-4">
                        <div class="card border-secondary mt-4 shadow">
                            <div class="card-header text-white bg-secondary">
                                Priemerný strávený čas na otázke
                            </div>
                            <div class="card-body">
                                <p class="card-text h5">
                                    {{ $avgTime ? $avgTime . ' s / test / otázka / žiak' : 'Nehodnotené' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if(!empty(trim($question->description_teacher)))
                <div class="card mt-4 border-dark shadow">
                    <div class="card-header bg-dark text-white">
                        Vysvetlenie pre učiteľa
                    </div>
                    <div class="card-body">
                        {!! $question->description_teacher !!}
                    </div>
                </div>
            @endif

            @if(!empty(trim($question->description)))
                <div class="card mt-4 border-secondary shadow">
                    <div class="card-header bg-secondary text-white">
                        Vysvetlenie pre študenta
                    </div>
                    <div class="card-body">
                        {!! $question->description !!}
                    </div>
                </div>
            @endif
            <div class="form-group mt-4">
                <a href="{{ route('question.index') }}" class="btn btn-link">Spať</a>
                @if (Auth::user()->is_admin || $question->created_by == Auth::user()->id)
                    <a href="{{ route('question.edit', $question) }}" class="btn btn-primary">
                        <i class="far fa-edit"></i> Upraviť
                    </a>
                    <form action="{{ route('question.destroy', $question) }}" class="d-inline-block" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Vymazať
                        </button>
                    </form>
                @endif
                <button class="btn btn-secondary" data-toggle="modal" data-target="#comment-modal">
                    <i class="fas fa-pen"></i> Napísať komment
                </button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#rating-modal">
                    <i class="far fa-star"></i> Hodnotiť
                </button>

            </div>
        </div>

        <div class="col-lg-4 pt-3 pb-3">
            @if (!empty($tests) && count($tests) > 0)
                <form action="{{ route('question.show', $question) }}" method="post">
                    <div class="form-group">
                        <label for="test">Test</label>
                        <select name="test" id="test-select" class="form-control">
                            @foreach ($tests as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-block btn-primary">
                            Pridaj do testu
                        </button>
                    </div>
                </form>
            @endif


            <div class="card border-warning mt-4 shadow">
                <div class="card-header text-dark bg-warning">
                    Komenty
                </div>
                @if ($question->comments->isEmpty())
                    <div class="card-body">
                        <p class="card-text">Ešte neboli žiadne komenty.</p>
                    </div>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($question->comments as $item)
                            <li class="list-group-item">
                                <strong>{{ $item->user->first_name . ' ' . $item->user->last_name}}</strong>, {{$item->created_at}}
                                <br>
                                {{$item->comment}}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('additional_html')
    <div class="modal fade" id="rating-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('question.rating', $question) }}" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hodnotenie</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- inspired from https://codepen.io/hesguru/pen/BaybqXv -->
                        <div class="rate">
                            <input type="radio" id="star5" name="value" value="5"
                                   @if(!empty($myRating) && $myRating->rating === 5) checked @endif/>
                            <label for="star5" title="text">5 stars</label>
                            <input type="radio" id="star4" name="value" value="4"
                                   @if(!empty($myRating) && $myRating->rating === 4) checked @endif />
                            <label for="star4" title="text">4 stars</label>
                            <input type="radio" id="star3" name="value" value="3"
                                   @if(!empty($myRating) && $myRating->rating === 3) checked @endif />
                            <label for="star3" title="text">3 stars</label>
                            <input type="radio" id="star2" name="value" value="2"
                                   @if(!empty($myRating) && $myRating->rating === 2) checked @endif />
                            <label for="star2" title="text">2 stars</label>
                            <input type="radio" id="star1" name="value" value="1"
                                   @if(!empty($myRating) && $myRating->rating === 1) checked @endif />
                            <label for="star1" title="text">1 star</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvoriť</button>
                        <button type="submit" class="btn btn-warning">Hodnotiť</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('question.comment', $question)}}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Napísať koment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea name="comment" id="" rows="6" class="form-control"></textarea>
                        @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Zatvoriť</button>
                        <button type="submit" class="btn btn-primary">Uložiť koment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
