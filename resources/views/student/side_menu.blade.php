<hr>
<h4 class="mb-3">Menu</h4>
<div class="row">
    <div class="col-3 text-center pb-2">
        <a href="{{ route('solving_student', ['id' => Session::get('testSettings')->id]) }}" class="btn btn-sm btn-success btn-block">
            <i class="fas fa-play-circle"></i>
        </a>
    </div>
    @php
        $qs = count(Session::get('testQuestions'));
        for($i = 0; $i < $qs; $i++){
            if (isset($curr) && $i+1 == $curr){
                echo '<div class="col-3 text-center pb-2"><span class="btn btn-dark btn-sm disabled btn-block">'. ($i+1) .'.</span></div>';
            }
            else{
                echo '<div class="col-3 text-center pb-2">';
                    echo '<a href="'. route('question_student', ['id' => Session::get('testSettings')->id, 'ord' => $i + 1]) .'" class="btn btn-sm btn-primary btn-block">'. ($i + 1) .'.</a>';
                echo '</div>';
            }
        }
    @endphp
    <div class="col-3 text-center pb-2">
        <a href="{{ route('finish_student', ['id' => Session::get('testSettings')->id]) }}" class="btn btn-sm btn-danger btn-block">
            <i class="fas fa-flag-checkered"></i>
        </a>
    </div>
</div>
<hr>