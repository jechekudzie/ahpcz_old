<?php

namespace App\Http\Controllers;

use App\Renewal;
use Illuminate\Http\Request;

class PractitionerCertificateController extends Controller
{

    //displays all up to date certificate
    public function index()
    {
        $current_year = date('Y');
        $no_shortfalls = [];
        $percentage = 0;
        $complete_renewals = Renewal::where('renewal_period_id', '>=', $current_year)->get();
        foreach ($complete_renewals as $complete_renewal) {

            $total = count($complete_renewal->practitioner->practitionerRequirements);
            $checked = count($complete_renewal->practitioner->practitionerRequirements->where('status', '1'));
            $percentage = ($checked / $total) * 100;

            if ($percentage == 100 && ($complete_renewal->renewal_status_id == 1) && ($complete_renewal->cdpoints == 1) && ($complete_renewal->placement == 1)) {
                $no_shortfalls[] = array('shortfall' => $percentage, 'renewal_id' => $complete_renewal->id);
            }

        }

        return view('admin.practitioner_certificates.index', compact('no_shortfalls'));
    }

    //display all pending
    public function pending()
    {
        $year = date('Y');
        $shortfalls = [];
        $percentage = 0;
        $pending_renewals = Renewal::where('renewal_period_id', '>=', $year)->get();
        foreach ($pending_renewals as $pending_renewal) {

            $total = count($pending_renewal->practitioner->practitionerRequirements);
            $checked = count($pending_renewal->practitioner->practitionerRequirements->where('status', '1'));
            $percentage = ($checked / $total) * 100;

            if ($percentage < 100 || ($pending_renewal->renewal_status_id != 1) || ($pending_renewal->cdpoints == 0) || ($pending_renewal->placement == 0)) {
                $shortfalls[] = array('shortfall' => $percentage, 'renewal_id' => $pending_renewal->id);
            }

        }


        return view('admin.practitioner_certificates.pendings', compact('shortfalls'));

    }

    public function collection(Renewal $renewal)
    {
        return view('admin.practitioner_certificates.collection', compact('renewal'));

    }

    public function signOff(Renewal $renewal)
    {
        $renewal->update([
            'certificate' => 1
        ]);

        return redirect('/admin/practitioners/' . $renewal->practitioner->id)->with('message', 'Certificate has been signed off  and is now ready for collection.');

    }

    public function collect(Renewal $renewal)
    {
        $renewal->update([
            'certificate' => 2
        ]);

        return redirect('/admin/practitioners/' . $renewal->practitioner->id)->with('message', 'Certificate has been issued to the practitioner.');

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


}
