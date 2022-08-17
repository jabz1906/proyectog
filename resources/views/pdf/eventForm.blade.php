<!DOCTYPE html>
<html>

<head>
    <title>Laravel 9 Generate PDF Example - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <h3>Registrado por: <small class="text-muted">{{ $event->user->name }}</small></h3>
    <h1>{{ $event->form->name }}</h1>
    <p>{{ $event->form->description }}</p>
    <br>
    @foreach ($event->form->questions->sortBy('order') as $question)
        @if ($question->type->id == 1)
            <h3>{{ $question->name }}</h3>
        @else
            @if ($question->type->id == 2)
                <p>{{ $question->name }}</p>
                <br>
            @else
                @foreach ($event->answers as $answer)
                    @if ($question->id == $answer->question_id)
                        @if ($answer->question->type->id == 3)
                            <h3>{{ $answer->question->name }}: <small
                                    class="text-muted">{{ $answer->input_data }}</small>
                            </h3>
                        @endif
                        @if ($answer->question->type->id == 4)
                            <h3>{{ $answer->question->name }}: <small
                                    class="text-muted">{{ $answer->input_data }}</small>
                            </h3>
                        @endif
                        @if ($answer->question->type->id == 5)
                            <h3>{{ $answer->question->name }}: <small
                                    class="text-muted">{{ $answer->option->name }}</small>
                            </h3>
                        @endif
                        @if ($answer->question->type->id == 6)
                            <h3>{{ $answer->question->name }}: <small
                                    class="text-muted">{{ $answer->input_data }}</small>
                            </h3>
                        @endif
                        @if ($answer->question->type->id == 7)
                            <h3>{{ $answer->question->name }}: <small
                                    class="text-muted">{{ $answer->input_data }}</small>
                            </h3>
                        @endif
                        @if ($answer->question->type->id == 8)
                            <h3>{{ $answer->question->name }}</h3>
                            @if ($answer->media_file == '')
                                <small class="text-muted"></small>
                            @else
                                @php
                                    $base64 = 'data:image/jpeg;base64,' . $answer->media_file;
                                    echo '<img src="' . $base64 . '" width="200" height="120">';
                                @endphp
                            @endif
                        @endif
                        @if ($answer->question->type->id == 9)
                            <h3>{{ $answer->question->name }}</h3>
                            @if ($answer->media_file == '')
                                <small class="text-muted"></small>
                            @else
                                @php
                                    $base64 = 'data:image/jpeg;base64,' . $answer->media_file;
                                    echo '<img src="' . $base64 . '" width="200" height="120">';
                                @endphp
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif
        @endif
    @endforeach
</body>

</html>
