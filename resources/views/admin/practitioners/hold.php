<?php

namespace App\Http\Controllers;

use App\Renewal;
use Illuminate\Http\Request;

class PractitionerCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $year = date('Y');
        $certificates = [];
        $shortfalls = [];
        $renewals = Renewal::whereCdpointsAndPlacementAndCertificate(1, 1, 0)->where('renewal_period_id', '>=', $year)->get();
        foreach ($renewals as $renewal) {
            $total = count($renewal->practitioner->practitionerRequirements);
            $checked = count($renewal->practitioner->practitionerRequirements->where('status', '1'));
            $percentage = ($checked / $total) * 100;

            if ($percentage == 100) {
                $shortfalls[] = array('shortfall' => $percentage, 'renewal_id' => $renewal->id);
                foreach ($shortfalls as $shortfall) {
                    dd($shortfall['renewal_id']);
                }
            }
        }


        return view('admin.practitioner_certificates.index', compact('certificates', 'shortfalls'));
    }

    public function pending()
    {
        //
        $year = date('Y');
        $renewals = Renewal::whereCdpointsOrPlacementOrCertificate(0, 0, 0)->where('renewal_period_id', '>=', $year)->get();
        $with_shortfalls = [];

        foreach ($renewals as $renewal) {
            $total = count($renewal->practitioner->practitionerRequirements);
            $checked = count($renewal->practitioner->practitionerRequirements->where('status', '1'));
            $percentage = ($checked / $total) * 100;

            if ($percentage < 100) {
                $shortfalls[] = array('shortfall' => $percentage, 'renewal_id' => $renewal->id);
                $with_shortfalls[] = array($renewal->id);
                $pending_renewals = Renewal::find($renewal->id);
            }
        }

        dd($pending_renewals);

        //$renewals = $renewals->get();


        //return view('admin.practitioner_certificates.pendings', compact('pending_renewals', 'shortfalls'));

    }

    public function store()
    {
        //
        /* $practitioner = $practitionerRequirement->practitioner;
         $total = count($practitioner->practitionerRequirements);
         $checked = count($practitioner->practitionerRequirements->where('status','1'));

         $percentage =  ($checked/$total) * 100;
         echo number_format($percentage,2).'%';*/

    }


    public function pendings()
    {
        //
        $year = date('Y');
        $pending_renewals = Renewal::whereRenewal_period_idAndCdpointsAndPlacementAndCertificate($year, 0, 0, 0)->get();


        return view('admin.practitioner_certificates.pendings', compact('pending_renewals'));

    }


}
