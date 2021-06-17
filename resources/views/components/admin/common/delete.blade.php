<div class="card">
    <div class="card-body">
        <h4 class="card-title">Delete {{ $item }}</h4>
        <div class="card-text">
            Want to delete this {{ $item }}? 
            <div class="mt-2">
                <a href="#custom-modal" class="btn btn-danger btn-sm waves-effect" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#36404a">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="custom-modal" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Are you sure?</h4>
    <div class="custom-modal-text">
        You are going to delete this {{ $item }}. This may lose all related data and might not able to recover once it's deleted.
        <div class="mt-2">
            <form action="{{ $url }}" method="post">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-secondary" onclick="Custombox.modal.close();">Cancel</button>
                <button class="btn btn-danger" type="submit">Proceed</button>
            </form>
        </div>
    </div>
</div>