<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\WorkOrder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $wo1 = WorkOrder::create([
            'order_number' => 'WO-1001',
            'customer_name' => 'Smith Transport',
            'status' => 'in_progress',
            'description' => 'Annual compliance review for fleet units 4500-4510. Verify insurance, registration, and safety inspection records are current.',
            'due_date' => '2026-04-15',
        ]);
        Document::create(['work_order_id' => $wo1->id, 'title' => 'Insurance Certificate', 'document_type' => 'certificate', 'filename' => 'smith-insurance-cert-2026.pdf']);
        Document::create(['work_order_id' => $wo1->id, 'title' => 'Vehicle Registration', 'document_type' => 'registration', 'filename' => 'smith-vehicle-reg-4502.pdf']);
        Document::create(['work_order_id' => $wo1->id, 'title' => 'Safety Inspection Report', 'document_type' => 'inspection', 'filename' => 'smith-safety-inspection-q1.pdf']);

        $wo2 = WorkOrder::create([
            'order_number' => 'WO-1002',
            'customer_name' => 'Jones Logistics',
            'status' => 'pending',
            'description' => 'New MC authority filing. Client needs operating authority for interstate freight. Prepare and submit MC application with supporting documents.',
            'due_date' => '2026-04-01',
        ]);
        Document::create(['work_order_id' => $wo2->id, 'title' => 'MC Application', 'document_type' => 'application', 'filename' => 'jones-mc-application.pdf']);
        Document::create(['work_order_id' => $wo2->id, 'title' => 'BOC-3 Filing', 'document_type' => 'filing', 'filename' => 'jones-boc3-filing.pdf']);
        Document::create(['work_order_id' => $wo2->id, 'title' => 'Insurance Certificate', 'document_type' => 'certificate', 'filename' => 'jones-insurance-cert.pdf']);

        $wo3 = WorkOrder::create([
            'order_number' => 'WO-1003',
            'customer_name' => 'Delta Freight',
            'status' => 'completed',
            'description' => 'Add vehicle Unit #7781 to existing IRP registration. All documentation received and verified.',
            'due_date' => '2026-03-20',
        ]);
        Document::create(['work_order_id' => $wo3->id, 'title' => 'Cab Card', 'document_type' => 'registration', 'filename' => 'delta-cab-card-7781.pdf']);
        Document::create(['work_order_id' => $wo3->id, 'title' => 'Title Copy', 'document_type' => 'title', 'filename' => 'delta-title-7781.pdf']);
        Document::create(['work_order_id' => $wo3->id, 'title' => 'Lease Agreement', 'document_type' => 'contract', 'filename' => 'delta-lease-7781.pdf']);
        Document::create(['work_order_id' => $wo3->id, 'title' => 'Proof of Insurance', 'document_type' => 'certificate', 'filename' => 'delta-insurance-7781.pdf']);

        $wo4 = WorkOrder::create([
            'order_number' => 'WO-1004',
            'customer_name' => 'Apex Carriers',
            'status' => 'in_progress',
            'description' => 'Q1 2026 IFTA quarterly fuel tax return. Compile mileage and fuel purchase records across all jurisdictions.',
            'due_date' => '2026-04-30',
        ]);
        Document::create(['work_order_id' => $wo4->id, 'title' => 'Mileage Summary', 'document_type' => 'report', 'filename' => 'apex-mileage-q1-2026.pdf']);
        Document::create(['work_order_id' => $wo4->id, 'title' => 'Fuel Receipts', 'document_type' => 'receipt', 'filename' => 'apex-fuel-receipts-q1.pdf']);
        Document::create(['work_order_id' => $wo4->id, 'title' => 'Prior Quarter Filing', 'document_type' => 'filing', 'filename' => 'apex-ifta-q4-2025.pdf']);

        $wo5 = WorkOrder::create([
            'order_number' => 'WO-1005',
            'customer_name' => 'Mountain View Trucking',
            'status' => 'cancelled',
            'description' => 'Random drug test selection for Q1. Cancelled — client switched to a different TPA provider.',
            'due_date' => '2026-03-15',
        ]);
        Document::create(['work_order_id' => $wo5->id, 'title' => 'Random Selection Letter', 'document_type' => 'letter', 'filename' => 'mtview-random-selection.pdf']);
        Document::create(['work_order_id' => $wo5->id, 'title' => 'MRO Report', 'document_type' => 'report', 'filename' => 'mtview-mro-report.pdf']);
    }
}
