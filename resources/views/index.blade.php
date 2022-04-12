<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
</head>
<body>
<div class="container">
    <h1 class="center-align mt-5">
        Games Search
    </h1>
    <form class="form-control mb-5" id="searchForm">
        <div class="form-group">
            <label for="gameName">Name of the game</label>
            <input required class="form-control" name="gameName" id="gameName" placeholder="Search games...">
        </div>
        <div class="form-group mt-2">
            <label for="gameMode">Play mode</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gameMode" value="money" required>
            <label class="form-check-label" for="gameMode">Money</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gameMode" value="demo">
            <label class="form-check-label" for="gameMode">Demo</label>
        </div>
        <div class="form-text">
            <button type="submit" class="btn btn-primary" id="search">Search</button>
        </div>
    </form>
    <div>
        <pre id="results" class="row row-cols-1 row-cols-md-2 g-4"></pre>
    </div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous">
</script>
<script>
    $(document).ready(function () {
        $('#search').click(function (event) {
            if (!$('input[name="gameMode"]:checked').val() || !$('#gameName').val()) {
                $('#results').html('Please enter all fields.');
                return;
            }

            event.preventDefault();

            $('#results').empty();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ @csrf_token() }}'
                }
            });
            $.ajax({
                url: "{{ route('game.search') }}",
                method: 'POST',
                data: {
                    gameName: $('#gameName').val(),
                    gameMode: $('input[name="gameMode"]:checked').val(),
                },
                success: function (data) {
                    let games = data.gameList;
                    if (games.length) {
                        for (const game of games) {
                            $('#results').prepend(
                                `<div class="card mb-3 mx-auto" style="width: 25rem;">\n` +
                                `  <img src="${game.images.default}" class="card-img-top">\n` +
                                `  <div class="card-body">\n` +
                                `    <h5 class="card-title">${game.name}</h5>\n` +
                                `    <p class="card-text"><small class="text-muted">${game.subCategory}</small></p>\n` +
                                `  </div>\n` +
                                `</div>`);
                        }
                    } else {
                        $('#results').html('Nothing found.');
                    }
                },
                error: function (error) {
                    $('#results').html('An error has occurred. Check the input fields.');
                }
            })
        })
    })
</script>
</body>
</html>
