<div class="custom-control custom-switch">
    <input type="hidden" name="{{ $name }}" value="{{ setting($name) }}">
    <input type="checkbox" class="custom-control-input" id="{{ $name }}" value="{{ setting($name) }}" {{ setting($name) && setting($name) === 'enable' ? 'checked' : null }}>
    <label class="custom-control-label" for="{{ $name }}">{{ $text }}</label>
</div>