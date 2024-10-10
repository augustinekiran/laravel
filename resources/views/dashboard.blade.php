<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Form Listing Dashboard</h2>
        <div class="mb-4 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFormModal">Create Form</button>
        </div>
        <div class="accordion" id="formAccordion">
            @foreach ($forms as $key => $form)
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <div class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Form {{ $key+1 }} - {{ $form->name }}
                    </div>
                </h2>
                @php
                $class = $key == 0 ? 'show' : '';
                @endphp
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addElementModal" onclick="setFormId('{{ $form->id }}')">Add Element</button>
                            <a class="ms-4" href="{{ route('form.show', ['form_slug' => $form->slug]) }}" target="_blank">Goto Form</a>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Label</th>
                                        <th>Type</th>
                                        <th>Value</th>
                                        <th>Required</th>
                                        <th>Sequence</th>
                                        <th>Options</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($form->elements as $index => $element)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $element->label }}</td>
                                        <td>{{ $element->type }}</td>
                                        <td>{{ $element->value ?? 'Not set' }}</td>
                                        <td>{{ $element->required == 1 ? 'Yes' : 'No' }}</td>
                                        <td>{{ $element->sequence ?? 'Not set' }}</td>
                                        <td>
                                            @if ($element->type == 'select')
                                            <div class="d-flex align-items-center">
                                                <select class="form-select" id="exampleSelect" aria-label="Select an Option">
                                                    <option selected>-- Select --</option>
                                                    @foreach ($element->options as $option)
                                                    <option value="{{ $option->value }}">{{ $option->label }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#addOptionModal" onclick="setElementId('{{ $element->id }}')"><i class="bi bi-plus-circle"></i></button>
                                            </div>
                                            @else
                                            N/A
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-warning"><i class="bi bi-pencil"></i></button>
                                            @php $deleteRoute = route('element.delete', ['element_id' => $element->id]); @endphp
                                            <button class="btn btn-danger" onclick="window.location.replace('{{ $deleteRoute }}')"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal for Adding Element -->
    <div class="modal fade" id="addElementModal" tabindex="-1" aria-labelledby="addElementModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addElementModalLabel">Add New Element</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addElementForm" action="{{ route('element.create') }}" method="post">
                    @csrf
                    <input type="hidden" name="form_id" id="form_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="elementLabel" class="form-label">Element Label</label>
                            <input type="text" class="form-control" name="label" required>
                            @if ($errors->has('label'))
                            <div class="ms-2 small text-danger">{{ $errors->first('label') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="elementType" class="form-label">Element Type</label>
                            <select class="form-select" name="type" required>
                                <option value="" disabled selected>Select type</option>
                                <option value="text">Text</option>
                                <option value="email">Email</option>
                                <option value="select">Select</option>
                            </select>
                            @if ($errors->has('type'))
                            <div class="ms-2 small text-danger">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="elementValue" class="form-label">Default Value</label>
                            <input type="text" class="form-control" name="value">
                            @if ($errors->has('value'))
                            <div class="ms-2 small text-danger">{{ $errors->first('value') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="elementRequired" class="form-label">Required</label>
                            <select class="form-select" name="required" required>
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            @if ($errors->has('required'))
                            <div class="ms-2 small text-danger">{{ $errors->first('required') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="elementOrder" class="form-label">Element Sequence</label>
                            <input type="number" class="form-control" name="sequence">
                            @if ($errors->has('sequence'))
                            <div class="ms-2 small text-danger">{{ $errors->first('sequence') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addElementButton">Add Element</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Creating Form -->
    <div class="modal fade" id="createFormModal" tabindex="-1" aria-labelledby="createFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createFormModalLabel">Create New Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createForm" action="{{ route('form.create') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="formName" class="form-label">Form Name</label>
                            <input type="text" class="form-control" name="name" required>
                            @if ($errors->has('name'))
                            <div class="ms-2 small text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="createFormButton">Create Form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for creating option -->
    <div class="modal fade" id="addOptionModal" tabindex="-1" aria-labelledby="addOptionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOptionModalLabel">Add New Option</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addOptionForm" action="{{ route('option.create') }}" method="post">
                    @csrf
                    <input type="hidden" name="element_id" id="element_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="optionLabel" class="form-label">Label</label>
                            <input type="text" class="form-control" name="option_label" required>
                            @if ($errors->has('option_label'))
                            <div class="ms-2 small text-danger">{{ $errors->first('option_label') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="optionValue" class="form-label">Value</label>
                            <input type="text" class="form-control" name="option_value" required>
                            @if ($errors->has('option_value'))
                            <div class="ms-2 small text-danger">{{ $errors->first('option_value') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="optionSequence" class="form-label">Sequence</label>
                            <input type="number" class="form-control" name="option_sequence">
                            @if ($errors->has('option_sequence'))
                            <div class="ms-2 small text-danger">{{ $errors->first('option_sequence') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="addOptionButton">Add Option</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        <?php
        if ($errors->has('name')) {
            echo 'var myModal = new bootstrap.Modal(document.getElementById("createFormModal"));';
            echo 'myModal.show();';
        }
        ?>

        <?php
        if ($errors->any() && !$errors->has('name') && !$errors->has('option_label') && !$errors->has('option_value') && !$errors->has('option_sequence')) {
            echo 'var myModal = new bootstrap.Modal(document.getElementById("addElementModal"));';
            echo 'myModal.show();';
        }
        ?>

        <?php
        if ($errors->has('option_label') || $errors->has('option_value') || $errors->has('option_sequence')) {
            echo 'var myModal = new bootstrap.Modal(document.getElementById("addOptionModal"));';
            echo 'myModal.show();';
        }
        ?>

        function setFormId(id) {
            const element = document.getElementById('form_id');
            element.value = id;
        }

        function setElementId(id) {
            const element = document.getElementById('element_id');
            element.value = id;
        }




        // JavaScript functions for Edit and Delete actions
        function editField(fieldNumber) {
            alert(`Edit field number: ${fieldNumber}`);
            // Logic to edit the field goes here
        }

        function deleteField(fieldNumber) {
            if (confirm(`Are you sure you want to delete field number: ${fieldNumber}?`)) {
                alert(`Field number ${fieldNumber} deleted.`);
                // Logic to delete the field goes here
            }
        }
    </script>
</body>

</html>