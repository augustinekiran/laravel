<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Form {{ $key+1 }} - {{ $form->name }}
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse {{ $key == 0 ? 'show' : ''}}" aria-labelledby="headingOne" data-bs-parent="#formAccordion">
                    <div class="accordion-body">
                        <div class="table-responsive">
                            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addElementModal">Add Element</button>
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
                    <input type="hidden" name="form_id" value="1">
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
                        <div class="mb-3" id="optionsDiv" style="display: none;">
                            <label for="elementOptions" class="form-label">Options (comma separated)</label>
                            <input type="text" class="form-control" id="elementOptions" placeholder="Option1, Option2, Option3">
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        <?php
        if ($errors->has('name')) {
            echo 'var myModal = new bootstrap.Modal(document.getElementById("createFormModal"));';
            echo 'myModal.show();';
        }
        ?>

        <?php
        if ($errors->any() && !$errors->has('name')) {
            echo 'var myModal = new bootstrap.Modal(document.getElementById("addElementModal"));';
            echo 'myModal.show();';
        }
        ?>



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

        // Show options input field when "Select" type is chosen
        document.getElementById('elementType').addEventListener('change', function() {
            const optionsDiv = document.getElementById('optionsDiv');
            if (this.value === 'select') {
                optionsDiv.style.display = 'block';
            } else {
                optionsDiv.style.display = 'none';
            }
        });
    </script>
</body>

</html>