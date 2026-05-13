<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerCommission;
use App\Services\PartnerService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function __construct(protected PartnerService $partnerService)
    {
    }

    /**
     * List all partners
     */
    public function index()
    {
        $partners = Partner::orderBy('name')
            ->withCount('commissions')
            ->with([
                'commissions' => fn($q) => $q->select('id', 'partner_id', 'commission_amount'),
            ])
            ->paginate(20);

        // Add summary data to each partner
        $partners->getCollection()->transform(function ($partner) {
            $partner->earnings_summary = $this->partnerService->getPartnerEarningsSummary($partner);
            return $partner;
        });

        return view('partners.index', compact('partners'));
    }

    /**
     * Show partner details and earnings
     */
    public function show(Partner $partner)
    {
        $partner->load(['members', 'commissions']);
        $earningsSummary = $this->partnerService->getPartnerEarningsSummary($partner);
        $commissions = $this->partnerService->getPartnerCommissionsWithDetails($partner);

        return view('partners.show', compact('partner', 'earningsSummary', 'commissions'));
    }

    /**
     * Create a new partner
     */
    public function create()
    {
        return view('partners.create');
    }

    /**
     * Store a new partner
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:trainer,affiliate,shop',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        Partner::create($data);

        return redirect()->route('partners.index')->with('success', 'Partner created successfully.');
    }

    /**
     * Edit partner
     */
    public function edit(Partner $partner)
    {
        return view('partners.edit', compact('partner'));
    }

    /**
     * Update partner
     */
    public function update(Request $request, Partner $partner)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'type' => 'required|in:trainer,affiliate,shop',
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $partner->update($data);

        return redirect()->route('partners.show', $partner)->with('success', 'Partner updated successfully.');
    }

    /**
     * Delete partner
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('partners.index')->with('success', 'Partner deleted successfully.');
    }

    /**
     * Mark commissions as paid
     */
    public function markCommissionsAsPaid(Request $request, Partner $partner)
    {
        $data = $request->validate([
            'commission_ids' => 'sometimes|array',
            'commission_ids.*' => 'exists:partner_commissions,id',
        ]);

        $count = $this->partnerService->bulkMarkCommissionsAsPaid(
            $partner,
            $data['commission_ids'] ?? []
        );

        return redirect()->route('partners.show', $partner)
            ->with('success', "Marked {$count} commission(s) as paid.");
    }

    /**
     * Get partner earnings report
     */
    public function earningsReport(Partner $partner)
    {
        $partner->load(['commissions.payment', 'commissions.member']);
        $earningsSummary = $this->partnerService->getPartnerEarningsSummary($partner);
        $commissions = $this->partnerService->getPartnerCommissionsWithDetails($partner);

        return view('partners.earnings-report', compact('partner', 'earningsSummary', 'commissions'));
    }
}
