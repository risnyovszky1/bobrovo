@if(!empty($test->time_to_do))
    <div class="count-down-container text-right">
        <div id="getting-started"></div>
    </div>


    <script type="text/javascript">
        $('#getting-started').countdown('{{ $finish }}', function (event) {
            var hours = event.strftime('<div class="count-down-col border rounded pt-2 pb-2 pl-2 pr-2 border-primary bg-white mr-1"> %H </div>');
            var mins = event.strftime('<div class="count-down-col border rounded pt-2 pb-2 pl-2 pr-2 border-primary bg-white mr-1 ml-1"> %M </div>');
            var seconds = event.strftime('<div class="count-down-col border rounded pt-2 pb-2 pl-2 pr-2 border-primary bg-white ml-1"> %S </div>');

            $(this).html(hours + ":" + mins + ":" + seconds);
        }).on('finish.countdown', function (event) {
            window.location.href = '{{ route('finish_student_timer', ['id' => Session::get('testSettings')->id]) }}';
        });


    </script>


    <style>
        .count-down-container {
            font-size: 2em
        }

        .count-down-container .count-down-col {
            display: inline-block;
        }
    </style>

    <hr>
@endif

<h4 class="mb-3">{{ __('student.menu') }}</h4>

<div class="row">
    <div class="col-3 text-center pb-2">
        <a href="{{ route('solving_student', ['id' => Session::get('testSettings')->id]) }}"
           class="btn btn-sm btn-success btn-block">
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
        <a href="{{ route('finish_student', ['id' => Session::get('testSettings')->id]) }}"
           class="btn btn-sm btn-danger btn-block">
            <i class="fas fa-flag-checkered"></i>
        </a>
    </div>
</div>
<hr>
