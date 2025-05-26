<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boardify</title>
    <link rel="stylesheet" href="{{ asset('css/boards.css') }}">
</head>
<body>
    @include('parts.nav')

    <section id="boards-container">
        <h1>Mijn Borden</h1>

        <div id="boards-list"></div> 

        <form action="{{ route('boards.create') }}" method="get">
            <button type="submit" class="add-board-btn">+ Nieuw Board</button>
        </form>
    </section>

    <script id="boards-data" type="application/json">
        @json($boards)
    </script>

    <script>
        const boardsData = JSON.parse(document.getElementById('boards-data').textContent);
        const boardsList = document.getElementById('boards-list');
    
        if (boardsData.length === 0) {
            boardsList.innerHTML = '<p>Je hebt nog geen board. Maak een board aan om te beginnen!</p>';
        } else {
            boardsData.forEach(board => {
                const boardItem = document.createElement('div');
                boardItem.classList.add('board-item');
    
                boardItem.innerHTML = `
                <form action="/boards/${board.Slug}" method="get" style="display:inline;">
                    <button type="submit" class="board-btn">${board.Titel}</button>
                </form>
                <form action="/boards/${board.Slug}" method="post" style="display:inline;">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="delete-board-btn">x</button>
                </form>

                `;
    
                boardsList.appendChild(boardItem);
            });
        }
    </script>

    @include('parts.footer')
</body>
</html>
