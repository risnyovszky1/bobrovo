@section('title')
  Otázka| Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
  <div class="row">
    <div class="col-lg-8 pt-3 pb-3">
      <h2>Otázka</h2>
      

      <div class="card mt-3 border-primary">
        <div class="card-header bg-primary text-white">
          Názov
        </div>
        <div class="card-body">
            <h5 class="card-title mb-0">{{ $question->title }}</h5>
        </div>
      </div>

      <div class="card mt-3 border-success">
        <div class="card-header bg-success text-white">
          Otázka pre študenta
        </div>
        <div class="card-body">
            {!! $question->question !!}
        </div>
      </div>

      <div class="card mt-3 border-info">
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
              <img src="{{$question->a}}" alt="odpoved a" class="img-thumbnail d-block mx-auto">
              {!! $question->answer == 'a' ? '<span class="text-success"><i class="fas fa-check"></i></span>': '<span class="text-danger"><i class="fas fa-times"></i></span>' !!}
            </div>
            
            <div class="col-md-6 text-center mb-2 mt-2 question-possibilities-show">
              <img src="{{$question->b}}" alt="odpoved b" class="img-thumbnail d-block mx-auto">
              {!! $question->answer == 'b' ? '<span class="text-success"><i class="fas fa-check"></i></span>': '<span class="text-danger"><i class="fas fa-times"></i></span>' !!}
            </div>
            
            <div class="col-md-6 text-center mb-2 question-possibilities-show">
              <img src="{{$question->c}}" alt="odpoved c" class="img-thumbnail d-block mx-auto">
              {!! $question->answer == 'c' ? '<span class="text-success"><i class="fas fa-check"></i></span>': '<span class="text-danger"><i class="fas fa-times"></i></span>' !!}
            </div>

            <div class="col-md-6 text-center mb-2 question-possibilities-show">
              <img src="{{$question->d}}" alt="odpoved d" class="img-thumbnail d-block mx-auto">
              {!! $question->answer == 'd' ? '<span class="text-success"><i class="fas fa-check"></i></span>': '<span class="text-danger"><i class="fas fa-times"></i></span>' !!}
            </div>
          </div>    
        @endif
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="card border-primary mt-3">
            <div class="card-header text-white bg-primary">
              Kategórie  
            </div>  
            @if (empty($categories) || count($categories) == 0)
                <div class="card-body">
                  <p class="card-text">Nie je zaradená do žiadnej kategórie</p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                  @foreach ($categories as $item)
                    <li class="list-group-item">{{$item->name}}</li>
                  @endforeach
                </ul>
            @endif
          </div>  
        </div>
        
        <div class="col-lg-6">
          <div class="card border-success mt-3">
            <div class="card-header text-white bg-success">
              Hodnotenie
            </div>
            <div class="card-body">
              <p class="card-text h5">
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
      </div>

      <div class="card mt-3 border-dark">
        <div class="card-header bg-dark text-white">
            Vysvetlenie pre učiteľa
        </div>
        <div class="card-body">
            {!! $question->description_teacher !!}
        </div>
      </div>

      <div class="card mt-3 border-secondary">
        <div class="card-header bg-secondary text-white">
            Vysvetlenie pre študenta
        </div>
        <div class="card-body">
            {!! $question->description !!}
        </div>
      </div>

      <div class="form-group mt-3">
        @if (Auth::user()->is_admin || $question->created_by == Auth::user()->id)
          <a href="{{ route('questions.edit', ['id' => $question->id]) }}" class="btn btn-primary">
            <i class="far fa-edit"></i> Upraviť
          </a>
          <a href="{{ route('questions.delete', ['id' => $question->id]) }}" class="btn btn-danger">
            <i class="fas fa-trash"></i> Vymazať
          </a>
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
        <form action="" method="post">
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
      

      <div class="card border-warning mt-4">
        <div class="card-header text-dark bg-warning">
          Komenty
        </div>
        @if (empty($comments) || count($comments) < 1)
            <div class="card-body">
              <p class="card-text">Ešte neboli žiadne komenty.</p>
            </div>
        @else
            <ul class="list-group list-group-flush">
              @foreach ($comments as $item)
                <li class="list-group-item">
                  <strong>{{ $item->first_name . ' ' . $item->last_name}}</strong>, {{$item->created_at}} <br>
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
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hodnotenie</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @if (empty($myRating->rating))
            <p>Ešte nehodnotili ste otázku.</p>
            <p class="h4">
              <a href="{{ route('questions.rating', ['id' => $question->id, 'rating' => 1]) }}" class="text-secondary rating-star" data-original="false"><i class="fas fa-star"></i></a>
              <a href="{{ route('questions.rating', ['id' => $question->id, 'rating' => 2]) }}" class="text-secondary rating-star" data-original="false"><i class="fas fa-star"></i></a>
              <a href="{{ route('questions.rating', ['id' => $question->id, 'rating' => 3]) }}" class="text-secondary rating-star" data-original="false"><i class="fas fa-star"></i></a>
              <a href="{{ route('questions.rating', ['id' => $question->id, 'rating' => 4]) }}" class="text-secondary rating-star" data-original="false"><i class="fas fa-star"></i></a>
              <a href="{{ route('questions.rating', ['id' => $question->id, 'rating' => 5]) }}" class="text-secondary rating-star" data-original="false"><i class="fas fa-star"></i></a>
            </p>
          @else
              <p>Už ste hodnotili otázku. Chcete to zmeniť?</p>
              <p class="h4">
                @for ($i = 1; $i <= $myRating->rating; $i++)
                  <a href="{{ route('questions.rating', ['id' => $question->id, 'rating' => $i]) }}" class="text-warning rating-star" data-original="true"><i class="fas fa-star"></i></a>
                @endfor
                @for ($i = 0; $i < 5 - $myRating->rating; $i++)
                  <a href="{{ route('questions.rating', ['id' => $question->id, 'rating' => $myRating->rating + $i + 1]) }}" class="text-secondary rating-star" data-original="false"><i class="fas fa-star"></i></a>
                @endfor
              </p>
          @endif         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvoriť</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('questions.addcomment', ['id' => $question->id] )}}" method="post">
          <div class="modal-header">
            <h5 class="modal-title">Napísať koment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
           <textarea name="comment" id="" rows="6" class="form-control"></textarea>   
           {{ csrf_field() }}      
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Uložiť koment</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvoriť</button>
          </div>
        </form>
      </div>
    </div>
</div>
@endsection