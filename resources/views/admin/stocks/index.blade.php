@extends('admin.layouts.app')

@section('title', 'Stocks - StyleHub Admin')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header h4 i {
        color: #db4444;
        margin-right: 8px;
    }
    .page-header p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }

    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.04);
        height: 100%;
    }
    .stat-card .number {
        font-size: 28px;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1.2;
    }
    .stat-card .label {
        font-size: 14px;
        color: #8c8c9c;
        font-weight: 500;
    }
    .stat-card .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-card.green .icon-wrapper { background: rgba(67,233,123,0.12); color: #2e7d32; }
    .stat-card.orange .icon-wrapper { background: rgba(245,87,108,0.12); color: #e65100; }
    .stat-card.red .icon-wrapper { background: rgba(245,87,108,0.12); color: #dc3545; }
    .stat-card.blue .icon-wrapper { background: rgba(79,172,254,0.12); color: #1976d2; }

    .badge-status {
        padding: 4px 12px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 12px;
        white-space: nowrap;
        display: inline-block;
    }
    .badge-status.stock-in { background: #d4edda; color: #155724; }
    .badge-status.stock-low { background: #fff3cd; color: #856404; }
    .badge-status.stock-out { background: #f8d7da; color: #721c24; }

    .table-premium {
        font-size: 14px;
        margin-bottom: 0;
    }
    .table-premium thead th {
        background: #f8f9fa;
        color: #666;
        font-weight: 600;
        padding: 10px 18px;
        border-bottom: none;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .table-premium tbody td {
        padding: 10px 18px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .btn-update {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 5px 18px;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-update:hover {
        background: #b33232;
        color: #fff;
    }
    .btn-update:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

  
    .modal-custom .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .modal-custom .modal-header {
        border-bottom: none;
        padding: 20px 24px 0;
    }
    .modal-custom .modal-header .modal-title {
        font-weight: 700;
        font-size: 20px;
    }
    .modal-custom .modal-body {
        padding: 20px 24px;
    }
    .modal-custom .modal-footer {
        border-top: none;
        padding: 0 24px 24px;
    }
    .modal-custom .form-control {
        border-radius: 10px;
        padding: 10px 16px;
        border: 2px solid #e0e0e0;
        font-size: 16px;
        font-weight: 600;
    }
    .modal-custom .form-control:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 0.2rem rgba(219, 68, 68, 0.1);
    }

  
    #toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 380px;
        width: 100%;
    }
    .toast {
        background: #1a1a2e;
        color: #fff;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .toast.success { border-left: 4px solid #28a745; }
    .toast.error { border-left: 4px solid #dc3545; }
    .toast.info { border-left: 4px solid #0d6efd; }
    .toast .toast-icon { font-size: 20px; }
    .toast .toast-close {
        margin-left: auto;
        cursor: pointer;
        opacity: 0.6;
        transition: 0.2s;
        padding: 0 5px;
    }
    .toast .toast-close:hover { opacity: 1; }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

   
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        flex-wrap: wrap;
        gap: 10px;
        background: #f8f9fa;
        border-radius: 0 0 16px 16px;
        border-top: 1px solid #f0f0f0;
    }
    .pagination-wrapper .showing-info {
        font-size: 14px;
        color: #666;
    }
    .pagination-wrapper .showing-info strong {
        color: #1a1a2e;
    }
    .pagination-wrapper .pagination {
        margin: 0;
        gap: 4px;
    }
    .pagination-wrapper .pagination .page-link {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 8px 14px;
        color: #1a1a2e;
        font-size: 14px;
        transition: all 0.3s;
        background: #fff;
    }
    .pagination-wrapper .pagination .page-link:hover {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .pagination-wrapper .pagination .page-item.active .page-link {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .pagination-wrapper .pagination .page-item.disabled .page-link {
        color: #999;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }
        .pagination-wrapper .pagination .page-link {
            padding: 6px 10px;
            font-size: 12px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-chart-pie"></i> Stocks</h4>
        <p>Manage inventory and stock levels</p>
    </div>
</div>


<div id="toast-container"></div>


<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card green">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">{{ $totalProducts }}</div>
                    <div class="label">Total Products</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-box"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card orange">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">{{ $lowStock }}</div>
                    <div class="label">Low Stock</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card red">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">{{ $outOfStock }}</div>
                    <div class="label">Out of Stock</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card blue">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="number">{{ $totalItems }}</div>
                    <div class="label">Total Items</div>
                </div>
                <div class="icon-wrapper"><i class="fas fa-warehouse"></i></div>
            </div>
        </div>
    </div>
</div>


<div class="chart-card" style="background:#fff; border-radius:16px; box-shadow:0 2px 15px rgba(0,0,0,0.04); overflow:hidden;">
    <div style="padding:15px 20px; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
        <span style="font-weight:700; font-size:16px; color:#1a1a2e;">
            <i class="fas fa-list" style="color:#db4444; margin-right:8px;"></i> Stock Inventory
        </span>
        <span style="font-size:13px; color:#999;">All products</span>
    </div>
    <div style="padding:0;">
        <div class="table-responsive">
            <table class="table table-premium">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $index }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>
                            <span id="stock-{{ $product->id }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td>
                            @if($product->stock_quantity > 5)
                                <span class="badge-status stock-in">In Stock</span>
                            @elseif($product->stock_quantity > 0 && $product->stock_quantity <= 5)
                                <span class="badge-status stock-low">Low Stock</span>
                            @else
                                <span class="badge-status stock-out">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn-update update-stock-btn" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-stock="{{ $product->stock_quantity }}">
                                <i class="fas fa-edit"></i> Update
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:#999;">
                            <i class="fas fa-box-open" style="font-size:40px; display:block; margin-bottom:10px;"></i>
                            No products found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
        <div class="pagination-wrapper">
            <div class="showing-info">
                Showing <strong>{{ $products->firstItem() }}</strong> 
                to <strong>{{ $products->lastItem() }}</strong> 
                of <strong>{{ $products->total() }}</strong> results
            </div>
            <div>
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-custom" id="updateStockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit" style="color:#db4444;"></i> Update Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Product:</strong> <span id="modal-product-name"></span></p>
                <p><strong>Current Stock:</strong> <span id="modal-current-stock"></span></p>
                <div class="mb-3">
                    <label for="new-stock" class="form-label fw-bold">New Stock Quantity</label>
                    <input type="number" class="form-control" id="new-stock" min="0" step="1">
                </div>
                <input type="hidden" id="modal-product-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-update" id="save-stock-btn" style="padding: 10px 30px;">
                    <i class="fas fa-save"></i> Update Stock
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('updateStockModal'));
    const productName = document.getElementById('modal-product-name');
    const currentStock = document.getElementById('modal-current-stock');
    const productId = document.getElementById('modal-product-id');
    const newStock = document.getElementById('new-stock');
    const saveBtn = document.getElementById('save-stock-btn');

  
    document.querySelectorAll('.update-stock-btn').forEach(button => {
        button.addEventListener('click', function() {
            productId.value = this.dataset.id;
            productName.textContent = this.dataset.name;
            currentStock.textContent = this.dataset.stock;
            newStock.value = this.dataset.stock;
            modal.show();
        });
    });

   
    saveBtn.addEventListener('click', function() {
        const id = productId.value;
        const stock = newStock.value;

        if (stock === '' || parseInt(stock) < 0) {
            showToast('Please enter a valid stock quantity (min: 0)', 'error');
            return;
        }

        this.disabled = true;
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        fetch('/admin/stocks/' + id + '/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                stock_quantity: parseInt(stock)
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server error occurred');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('stock-' + id).textContent = stock;
                
                const row = document.querySelector('button[data-id="' + id + '"]').closest('tr');
                const statusCell = row.querySelectorAll('td')[4];
                let badgeClass, badgeText;
                
                if (stock > 5) {
                    badgeClass = 'stock-in';
                    badgeText = 'In Stock';
                } else if (stock > 0 && stock <= 5) {
                    badgeClass = 'stock-low';
                    badgeText = 'Low Stock';
                } else {
                    badgeClass = 'stock-out';
                    badgeText = 'Out of Stock';
                }
                
                statusCell.innerHTML = '<span class="badge-status ' + badgeClass + '">' + badgeText + '</span>';
                
                const btn = document.querySelector('button[data-id="' + id + '"]');
                btn.dataset.stock = stock;
                
                showToast('Stock updated successfully!', 'success');
                modal.hide();
                
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showToast('Failed to update stock. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error updating stock. Please try again.', 'error');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-save"></i> Update Stock';
        });
    });

    
    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };
        
        toast.innerHTML = `
            <span class="toast-icon"><i class="fas ${icons[type] || icons.info}"></i></span>
            <span>${message}</span>
            <span class="toast-close"><i class="fas fa-times"></i></span>
        `;
        
        toast.querySelector('.toast-close').addEventListener('click', function() {
            removeToast(toast);
        });
        
        container.appendChild(toast);
        
        setTimeout(() => {
            removeToast(toast);
        }, 4000);
    }
    
    function removeToast(toast) {
        if (toast && toast.parentElement) {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 300);
        }
    }
});
</script>
@endpush
@endsection