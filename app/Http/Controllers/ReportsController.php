<?php

namespace App\Http\Controllers;

use App\Renewal;
use App\RenewalStatus;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //

    public function renewal_reports()
    {
        $set = 0;

        $renewals = '';
        if (request('set') == 1) {
            $set = 1;
        }

        $compliant_statuses = RenewalStatus::all();
        $period = request('period');
        $compliant_status = request('compliant_status');
        $payment_status = request('payment_status');
        $profession = request('profession');
        $renewal_category = request('renewal_category');

        if ($set == 1) {
            $renewals = Renewal::all();
        }
        if ($period != null) {
            $renewals = $renewals->where('renewal_period_id', $period);
        }

        if ($compliant_status != null) {
            $renewals = $renewals->where('compliant_status_id', $compliant_status);
        }

        if ($payment_status != null) {
            $renewals = $renewals->where('payment_status_id', $payment_status);
        }
        if ($renewal_category != null) {
            $renewals = $renewals->where('renewal_category_id', $renewal_category);
        }

        return view('admin.reports.renewal', compact('renewals',''));

    }
}
