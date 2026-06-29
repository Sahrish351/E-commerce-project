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

    public function index()
    {
        
        $campaigns = Session::get('marketing_campaigns', $this->getDefaultCampaigns());
        
        return view('admin.marketing.index', compact('campaigns'));
    }

    
    public function create()
    {
        return view('admin.marketing.create');
    }

 
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