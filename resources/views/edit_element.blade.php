<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Element</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            width: 60%;
            max-width: 600px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="text-center mb-4">Update Element Details</h2>
        <form id="updateForm" action="{{ route('element.update', ['element_id' => $element->id]) }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="label" class="form-label">Label</label>
                <input type="text" class="form-control" value="{{ old('label') ?? $element->label }}" id="label" name="label" required>
                @if ($errors->has('label'))
                <div class="ms-2 small text-danger">{{ $errors->first('label') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type:</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="input" {{ $element->type == 'input' ? 'selected' : '' }}>Input</option>
                    <option value="number" {{ $element->type == 'number' ? 'selected' : '' }}>Number</option>
                    <option value="select" {{ $element->type == 'select' ? 'selected' : '' }}>Select</option>
                    <option value="email" {{ $element->type == 'email' ? 'selected' : '' }}>Email</option>
                </select>
                @if ($errors->has('type'))
                <div class="ms-2 small text-danger">{{ $errors->first('type') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Value</label>
                <input type="text" class="form-control" value="{{ old('value') ?? $element->value }}" id="value" name="value">
                @if ($errors->has('value'))
                <div class="ms-2 small text-danger">{{ $errors->first('value') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="sequence" class="form-label">Sequence Number:</label>
                <input type="number" class="form-control" value="{{ old('sequence') ?? $element->sequence }}" id="sequence" name="sequence">
                @if ($errors->has('sequence'))
                <div class="ms-2 small text-danger">{{ $errors->first('sequence') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="required" class="form-label">Required:</label>
                <select class="form-select" id="required" name="required" required>
                    <option value="0" {{ $element->required == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $element->required == 1 ? 'selected' : '' }}>Yes</option>
                </select>
                @if ($errors->has('required'))
                <div class="ms-2 small text-danger">{{ $errors->first('required') }}</div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>