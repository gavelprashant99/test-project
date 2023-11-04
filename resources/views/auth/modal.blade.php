<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="modal fade" id="documentModal{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel{{ $document->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg for a larger modal -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="documentModalLabel{{ $document->id }}">{{ $document->document_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display the document preview here, e.g., an iframe for PDF, image, or other content -->
                    <iframe src="{{ asset('storage/' . $document->document_path) }}" width="100%" height="500"></iframe>
                </div>
                <div class="modal-footer">
                    <!-- Additional buttons or actions here, if needed -->
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>