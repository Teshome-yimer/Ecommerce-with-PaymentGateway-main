<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Download invoice PDF
     */
    public function download(Order $order)
    {
        // Check if user owns this order or is admin
        if (!Auth::user()->is_admin && $order->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // Load relationships
        $order->load(['items.product', 'address', 'user']);

        // Generate PDF
        $pdf = Pdf::loadView('invoice.template', compact('order'));

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Generate filename
        $filename = 'Invoice-' . $order->id . '-' . date('Y-m-d') . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }

    /**
     * View invoice in browser
     */
    public function view(Order $order)
    {
        // Check if user owns this order or is admin
        if (!Auth::user()->is_admin && $order->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // Load relationships
        $order->load(['items.product', 'address', 'user']);

        // Generate PDF and stream to browser
        $pdf = Pdf::loadView('invoice.template', compact('order'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Invoice-' . $order->id . '.pdf');
    }

    /**
     * Preview invoice (HTML version)
     */
    public function preview(Order $order)
    {
        // Check if user owns this order or is admin
        if (!Auth::user()->is_admin && $order->id_user !== Auth::id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // Load relationships
        $order->load(['items.product', 'address', 'user']);

        return view('invoice.preview', compact('order'));
    }
}
