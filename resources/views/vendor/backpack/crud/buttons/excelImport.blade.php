<button type="button" class="btn btn-primary mx-2 ml-5" data-toggle="modal" data-target="#modalForImport"
    id="bulkUpload">
    <i class="la la-file-excel-o" aria-hidden="true"></i>
    &nbsp;Import
</button>

<!-- Modal -->
<div class="modal fade" id="modalForImport" tabindex="-1" role="dialog"
    aria-labelledby="modalForImportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

        <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title text-center" id="exampleModalLongTitle">Member Entries via Excel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_test">
                    <form action="{{ route('importMemberExcel') }}" method="POST" id="importViaExcelForm" files=true>
                        <div class="modal-body ">
                            <input type="file" id="excelMemberFile" name="excelMemberFile" required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Discard</button>
                            <button class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
<style>
    .modal{
        z-index:10000;
    }
</style>


@push('after_scripts')
<script>
    $('#modalForImport').appendTo('body');

    $('#importViaExcelForm').submit(function(e) {
        e.preventDefault();
        let url = $('#importViaExcelForm').attr('action');
        let formdata = new FormData(this);

        axios.post(url, formdata).then((response) => {
            if (response.data === 1) {
                document.location = 'member';
            } else {
                $('#modal_test').html(response.data);
            }
        }, (error) => {
            alert("Error !", error.response.data.message, "error")
        });
    });
</script>
@endpush
