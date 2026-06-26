<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MarketingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);
    }

    // ✅ Show marketing page
    public function index()
    {
        // Get campaigns from session or database
        $campaigns = Session::get('marketing_campaigns', $this->getDefaultCampaigns());
        
        return view('admin.marketing.index', compact('campaigns'));
    }

    // ✅ Show create campaign form
    public function create()
    {
        return view('admin.marketing.create');
    }

    // ✅ Store new campaign
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Email,Push Notification,Social Media,SMS',
            'status' => 'required|string|in:active,completed,draft',
            'sent' => 'nullable|integer|min:0',
            'opened' => 'nullable|integer|min:0',
        ]);

        $campaigns = Session::get('marketing_campaigns', $this->getDefaultCampaigns());
        
        $newCampaign = [
            'id' => count($campaigns) + 1,
            'name' => $request->name,
            'type' => $request->type,
            'sent' => $request->sent ?? 0,
            'opened' => $request->opened ?? 0,
            'status' => $request->status,
            'created_at' => now()->format('M d, Y'),
        ];
        
        array_unshift($campaigns, $newCampaign);
        Session::put('marketing_campaigns', $campaigns);

        return redirect()->route('admin.marketing.index')
            ->with('success', 'Campaign created successfully!');
    }

    // ✅ Show single campaign
    public function show($id)
    {
        $campaigns = Session::get('marketing_campaigns', $this->getDefaultCampaigns());
        $campaign = collect($campaigns)->firstWhere('id', (int)$id);
        
        if (!$campaign) {
            return redirect()->route('admin.marketing.index')
                ->with('error', 'Campaign not found!');
        }

        return view('admin.marketing.show', compact('campaign'));
    }

    // ✅ Show edit campaign form
    public function edit($id)
    {
        $campaigns = Session::get('marketing_campaigns', $this->getDefaultCampaigns());
        $campaign = collect($campaigns)->firstWhere('id', (int)$id);
        
        if (!$campaign) {
            return redirect()->route('admin.marketing.index')
                ->with('error', 'Campaign not found!');
        }

        return view('admin.marketing.edit', compact('campaign'));
    }

    // ✅ Update campaign
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Email,Push Notification,Social Media,SMS',
            'status' => 'required|string|in:active,completed,draft',
            'sent' => 'nullable|integer|min:0',
            'opened' => 'nullable|integer|min:0',
        ]);

        $campaigns = Session::get('marketing_campaigns', $this->getDefaultCampaigns());
        
        foreach ($campaigns as $key => $camp) {
            if ($camp['id'] == $id) {
                $campaigns[$key]['name'] = $request->name;
                $campaigns[$key]['type'] = $request->type;
                $campaigns[$key]['status'] = $request->status;
                $campaigns[$key]['sent'] = $request->sent ?? 0;
                $campaigns[$key]['opened'] = $request->opened ?? 0;
                break;
            }
        }
        
        Session::put('marketing_campaigns', $campaigns);

        return redirect()->route('admin.marketing.index')
            ->with('success', 'Campaign updated successfully!');
    }

    // ✅ Delete campaign
    public function destroy($id)
    {
        $campaigns = Session::get('marketing_campaigns', $this->getDefaultCampaigns());
        
        foreach ($campaigns as $key => $camp) {
            if ($camp['id'] == $id) {
                unset($campaigns[$key]);
                break;
            }
        }
        
        Session::put('marketing_campaigns', array_values($campaigns));

        return redirect()->route('admin.marketing.index')
            ->with('success', 'Campaign deleted successfully!');
    }

    // ✅ Toggle campaign status
    public function toggleStatus($id)
    {
        $campaigns = Session::get('marketing_campaigns', $this->getDefaultCampaigns());
        
        foreach ($campaigns as $key => $camp) {
            if ($camp['id'] == $id) {
                $campaigns[$key]['status'] = $camp['status'] == 'active' ? 'completed' : 'active';
                break;
            }
        }
        
        Session::put('marketing_campaigns', $campaigns);

        return redirect()->route('admin.marketing.index')
            ->with('success', 'Campaign status updated!');
    }

    // ✅ Default campaigns
    private function getDefaultCampaigns()
    {
        return [
            [
                'id' => 1,
                'name' => 'Summer Sale 2025',
                'type' => 'Email',
                'sent' => 2456,
                'opened' => 1234,
                'status' => 'active',
                'created_at' => 'Jun 15, 2025'
            ],
            [
                'id' => 2,
                'name' => 'New Arrivals - July',
                'type' => 'Push Notification',
                'sent' => 1890,
                'opened' => 1456,
                'status' => 'active',
                'created_at' => 'Jul 01, 2025'
            ],
            [
                'id' => 3,
                'name' => 'Weekend Flash Sale',
                'type' => 'Social Media',
                'sent' => 3200,
                'opened' => 2100,
                'status' => 'completed',
                'created_at' => 'Jun 28, 2025'
            ],
        ];
    }
}