@if ($errors && count($errors))
    <div class="card">
        <div class="card-body">
            <h4 class="card-title text-danger">Errors</h4>
            <div class="card-text">
                <ul class="text-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif