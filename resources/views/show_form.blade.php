<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $form->name }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 60%;
            margin: auto;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="form-container">
            <h2 class="mb-4 text-center">{{ $form->name }}</h2>

            @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="/submit" method="POST">
                @csrf
                <input type="hidden" name="form_slug" value="{{ $form->slug }}">
                <input type="hidden" name="form_id" value="{{ $form->id }}">
                @foreach ($form->elements as $element)
                <div class="mb-3">
                    <label class="form-label">{{ $element->label }}:</label>
                    @if ($element->type == 'select')
                    <select class="form-select" name="{{ $element->id }}" {{ $element->required == 1 ? 'required' : '' }}>
                        <option value="" disabled selected>-- Select --</option>
                        @foreach ($element->options as $option)
                        <option value="{{ $option->value }}">{{ $option->label }}</option>
                        @endforeach
                    </select>
                    @else
                    <input type="{{ $element->type }}" class="form-control" name="{{ $element->id }}" {{ $element->required == 1 ? 'required' : '' }}>
                    @endif
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>