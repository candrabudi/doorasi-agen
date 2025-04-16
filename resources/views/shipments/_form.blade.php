<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ $shipment->name ?? '' }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Code</label>
    <input type="text" name="code" class="form-control" value="{{ $shipment->code ?? '' }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Icon (optional)</label>
    <input type="file" name="icon" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ $shipment->description ?? '' }}</textarea>
</div>

<div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="is_active" value="1"
        {{ isset($shipment) && !$shipment->is_active ? '' : 'checked' }}>
    <label class="form-check-label">Active</label>
</div>
