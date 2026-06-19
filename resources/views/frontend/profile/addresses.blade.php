@extends('layouts.app')

@section('title', 'Address Book - StyleHub')

@section('content')
<div class="container py-4">
    <div class="row">
        
        <div class="col-md-3 mb-4">
            <div class="profile-sidebar p-3 rounded-3" style="background: #fff; border: 1px solid #eee;">
               
                <div class="text-center pb-3 border-bottom">
                    <div class="avatar mx-auto mb-2" style="width: 70px; height: 70px; background: #db4444; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span class="text-white fw-bold fs-3">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                    <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
                </div>
              
                <div class="mt-3">
                    <a href="{{ route('profile.dashboard') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-tachometer-alt" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">Dashboard</span>
                    </a>
                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">Manage My Account</h6>
                    <a href="{{ route('profile.edit') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-user" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Profile</span>
                    </a>
                    <a href="{{ route('profile.addresses') }}" class="sidebar-link active d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-map-marker-alt" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">Address Book</span>
                    </a>
                    
                   
                    <a href="{{ route('profile.payment') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-credit-card" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Payment Options</span>
                    </a>
                    
                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">My Orders</h6>
                    
                   
                    <a href="{{ route('orders.index') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-box" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Orders</span>
                    </a>
                    <a href="{{ route('orders.returns') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-undo" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Returns</span>
                    </a>
                    <a href="{{ route('orders.cancellations') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-times-circle" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">My Cancellations</span>
                    </a>
                    
                    <h6 class="fw-bold mt-4 mb-3" style="color: #333; font-size: 14px;">My Wishlist</h6>
                    <a href="{{ route('wishlist.index') }}" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none">
                        <i class="fas fa-heart" style="width: 18px; font-size: 13px;"></i>
                        <span class="small">View Wishlist</span>
                    </a>
                    <hr class="my-3">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="sidebar-link d-flex align-items-center gap-2 p-2 rounded mb-1 text-decoration-none text-danger">
                        <i class="fas fa-sign-out-alt" style="width: 18px; font-size: 13px;"></i>
                        <span class="small fw-semibold">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="profile-content p-4 rounded-3" style="background: #fff; border: 1px solid #eee;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Address Book</h5>
                    <button class="btn btn-danger btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        <i class="fas fa-plus me-1"></i> Add New Address
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    @forelse($addresses as $address)
                        <div class="col-md-6 mb-3">
                            <div class="address-card p-3 rounded-3" style="border: 1px solid #eee;">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold">{{ $address->label ?? 'Address' }}</h6>
                                    @if($address->is_default)
                                        <span class="badge bg-success">Default</span>
                                    @endif
                                </div>
                                <p class="text-muted small mb-1">{{ $address->address }}</p>
                                <p class="text-muted small mb-1">{{ $address->city }}, {{ $address->state }}</p>
                                <p class="text-muted small mb-0">{{ $address->postal_code }}, {{ $address->country }}</p>
                                <div class="mt-2">
                                    <a href="#" class="text-danger small text-decoration-none">Edit</a>
                                    <span class="mx-2 text-muted">|</span>
                                    <form action="{{ route('profile.address.delete', $address->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger small text-decoration-none p-0" onclick="return confirm('Delete this address?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted">No addresses added yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.address.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="fw-semibold small">Label (e.g. Home, Office)</label>
                        <input type="text" name="label" class="form-control" placeholder="Home">
                    </div>
                    <div class="mb-3">
                        <label class="fw-semibold small">Address</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-semibold small">City</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold small">State</label>
                            <input type="text" name="state" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-semibold small">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-semibold small">Country</label>
                            <input type="text" name="country" class="form-control" value="Pakistan">
                        </div>
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

@push('styles')
<style>
    .profile-sidebar { position: sticky; top: 20px; }
    .sidebar-link { color: #6c757d; font-size: 14px; transition: all 0.2s; }
    .sidebar-link:hover { background: #f8f9fa; color: #db4444; }
    .sidebar-link.active { background: #fff5f5; color: #db4444; }
    .sidebar-link.active i { color: #db4444 !important; }
    .avatar { box-shadow: 0 3px 10px rgba(219,68,68,0.2); }
    .address-card { transition: all 0.3s; }
    .address-card:hover { box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
</style>
@endpush