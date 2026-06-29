@extends('admin.layouts.app')

@section('title', 'Create Campaign - StyleHub Admin')

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
        font-size: 24px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header h4 i {
        color: #db4444;
        margin-right: 10px;
    }
    .page-header p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }

    .btn-back {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-back:hover {
        background: #e0e0e0;
    }

  
    .form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f0f0f0;
        padding: 28px 30px;
    }

    .form-card .form-label {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
    }
    .form-card .form-label .required {
        color: #dc3545;
        margin-left: 2px;
    }

    .form-card .form-control,
    .form-card .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .form-card .form-control:focus,
    .form-card .form-select:focus {
        border-color: #db4444;
        box-shadow: 0 0 0 3px rgba(219, 68, 68, 0.08);
    }

    .form-card .form-control::placeholder {
        color: #b0b0b0;
    }

    .form-card .form-text {
        font-size: 12px;
        color: #8c8c9c;
        margin-top: 4px;
    }

    .form-card .form-check-input:checked {
        background-color: #db4444;
        border-color: #db4444;
    }

  
    .btn-submit {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
    }
    .btn-submit:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(219, 68, 68, 0.3);
        color: #fff;
    }

    .btn-cancel {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-cancel:hover {
        background: #e0e0e0;
    }

   
    .type-card {
        border: 2px solid #f0f0f0;
        border-radius: 12px;
        padding: 16px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background: #fff;
        height: 100%;
    }
    .type-card:hover {
        border-color: #db4444;
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }
    .type-card.active {
        border-color: #db4444;
        background: #fef0f0;
    }
    .type-card .icon {
        font-size: 28px;
        color: #db4444;
        display: block;
        margin-bottom: 6px;
    }
    .type-card .name {
        font-weight: 600;
        font-size: 14px;
        color: #1a1a2e;
    }
    .type-card .desc {
        font-size: 12px;
        color: #8c8c9c;
        margin-top: 2px;
    }


    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .form-card {
            padding: 16px;
        }
        .form-card .row {
            gap: 4px;
        }
        .type-card {
            padding: 12px 14px;
        }
        .type-card .icon {
            font-size: 22px;
        }
    }
</style>


<div class="page-header">
    <div>
        <h4><i class="fas fa-plus-circle"></i> Create Campaign</h4>
        <p>Create a new marketing campaign</p>
    </div>
    <a href="{{ route('admin.marketing.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>


<div class="form-card">
    <form action="{{ route('admin.marketing.store') }}" method="POST">
        @csrf

        <div class="row g-4">
          
            <div class="col-12">
                <div class="mb-2">
                    <label class="form-label">Campaign Name <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" placeholder="e.g. Summer Sale 2025" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Give your campaign a clear and memorable name.</div>
                </div>
            </div>

        
            <div class="col-12">
                <label class="form-label">Campaign Type <span class="required">*</span></label>
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="type-card active" data-type="Email" onclick="selectType(this)">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                            <div class="name">Email</div>
                            <div class="desc">Newsletter</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="type-card" data-type="Push Notification" onclick="selectType(this)">
                            <span class="icon"><i class="fas fa-bell"></i></span>
                            <div class="name">Push Notification</div>
                            <div class="desc">Real-time alerts</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="type-card" data-type="Social Media" onclick="selectType(this)">
                            <span class="icon"><i class="fas fa-share-alt"></i></span>
                            <div class="name">Social Media</div>
                            <div class="desc">Connect platforms</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="type-card" data-type="SMS" onclick="selectType(this)">
                            <span class="icon"><i class="fas fa-sms"></i></span>
                            <div class="name">SMS</div>
                            <div class="desc">Text messages</div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="type" id="campaignType" value="Email">
                @error('type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

        
            <div class="col-md-4">
                <div class="mb-2">
                    <label class="form-label">Status <span class="required">*</span></label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

    
            <div class="col-md-4">
                <div class="mb-2">
                    <label class="form-label">Total Sent</label>
                    <input type="number" name="sent" class="form-control @error('sent') is-invalid @enderror" 
                           value="{{ old('sent', 0) }}" min="0" placeholder="0">
                    @error('sent') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Number of recipients the campaign was sent to.</div>
                </div>
            </div>

          
            <div class="col-md-4">
                <div class="mb-2">
                    <label class="form-label">Total Opened</label>
                    <input type="number" name="opened" class="form-control @error('opened') is-invalid @enderror" 
                           value="{{ old('opened', 0) }}" min="0" placeholder="0">
                    @error('opened') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="form-text">Number of recipients who opened the campaign.</div>
                </div>
            </div>

        
            <div class="col-12">
                <div class="mb-2">
                    <label class="form-label">Notes <span class="text-muted">(optional)</span></label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes about this campaign...">{{ old('notes') }}</textarea>
                </div>
            </div>

           
            <div class="col-12">
                <hr>
                <div class="d-flex gap-3 flex-wrap">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Create Campaign
                    </button>
                    <a href="{{ route('admin.marketing.index') }}" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>


<script>
    function selectType(element) {
      
        document.querySelectorAll('.type-card').forEach(card => {
            card.classList.remove('active');
        });
      
        element.classList.add('active');
       
        document.getElementById('campaignType').value = element.dataset.type;
    }

 
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.querySelector('input[name="name"]');
        const typeCards = document.querySelectorAll('.type-card');
        
        typeCards.forEach(card => {
            card.addEventListener('click', function() {
                if (!nameInput.value) {
                    const type = this.dataset.type;
                    const suggestions = {
                        'Email': 'Email Campaign',
                        'Push Notification': 'Push Notification Campaign',
                        'Social Media': 'Social Media Campaign',
                        'SMS': 'SMS Campaign'
                    };
                    nameInput.placeholder = 'e.g. ' + (suggestions[type] || 'Campaign');
                }
            });
        });
    });
</script>

@endsection