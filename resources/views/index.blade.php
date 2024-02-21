<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test AICOD</title>

    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @vite('resources/js/app.js')

</head>

<body>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Form di registrazione utente -->
                    <form method="post" action="{{ route('users.processForm') }}" enctype="multipart/form-data">
                        {{-- Token CSRF --}}
                        @csrf

                        <!-- Campo Nome -->
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>

                        <!-- Campo Cognome -->
                        <div class="mb-3">
                            <label for="cognome" class="form-label">Cognome</label>
                            <input type="text" class="form-control" name="cognome" required>
                        </div>

                        <!-- Campo Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <!-- Campo Codice Tessera -->
                        <div class="mb-3">
                            <label for="codice_tessera" class="form-label">Codice tessera</label>
                            <input type="text" class="form-control" id="codice_tessera" name="codice_tessera" required>
                        </div>

                        <!-- Campo Note -->
                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <input type="text" class="form-control" id="note" name="note">
                        </div>

                        <!-- Campo Livello -->
                        <div class="mb-3">
                            <label for="livello" class="form-label">Livello</label>
                            <input type="number" class="form-control" id="livello" name="livello">
                        </div>

                        <!-- Pulsante di invio del form -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>

</html>
