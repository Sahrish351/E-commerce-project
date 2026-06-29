@extends('client.layouts.app')

@section('title', 'Addresses')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-map-marker-alt text-danger me-2"></i> My Addresses</h5>
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            <i class="fas fa-plus"></i> Add Address
        </button>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse($addresses as $address)
        <div class="border rounded-3 p-3 mb-3">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-1"><strong>{{ $address->address_line1 }}</strong></p>
                    <p class="mb-1">{{ $address->address_line2 }}</p>
                    <p class="mb-1">{{ $address->city }}, {{ $address->state }} - {{ $address->postal_code }}</p>
                    <p class="mb-0">{{ $address->country }}</p>
                </div>
                <div class="text-end">
                    @if($address->is_default)
                        <span class="badge bg-success mb-2">Default</span>
                    @endif
                    <form action="{{ route('client.profile.address.delete', $address->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this address?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-4">
            <i class="fas fa-map-marker-alt" style="font-size:40px; color:#ddd; display:block; margin-bottom:10px;"></i>
            <p class="text-muted">No addresses saved yet</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle text-danger"></i> Add Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('client.profile.address.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Address Line 1</label>
                        <input type="text" name="address_line1" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" name="address_line2" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="is_default" class="form-check-input" id="isDefault">
                        <label class="form-check-label" for="isDefault">Set as default address</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection