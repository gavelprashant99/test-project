<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Custom Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <!-- Add this button in your Blade view -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#documentModal"
        data-document-id="{{ $documentId }}">
        Open Document
    </button>
    <!-- Add this input field in your modal view -->
    <input type="hidden" id="documentId" value="{{ $documentId }}">
  

    <div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentModalLabel">Document Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- You can display the document PDF content here -->
                    {{-- <embed src="{{($documentUrl, $documentId) }}" type="application/pdf" width="100%"
                        height="500"> --}}
                    <iframe src="{{ asset('storage/' . $documentPath) }}" style="width: 100%; height: 500px;"></iframe>

                    
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to update the hidden input field -->
    <script>
        $('#documentModal').on('show.bs.modal', function(e) {

            var button = $(e.relatedTarget);
            var documentId = button.data('document-id');
            $('#documentId').val(documentId);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
