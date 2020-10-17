<?php


namespace App;
use Illuminate\Support\Facades\View;
use Dompdf\Dompdf;


class Invoice
{
    protected $pdf;


    public function __construct()
    {
        $this->pdf = new Dompdf;
    }

    public function generate() {
        $this->pdf->loadHtml(
            View::make('invoices.invoice')->render()
    );
        $this->pdf->render();
        return $this->pdf->output();
    }

}