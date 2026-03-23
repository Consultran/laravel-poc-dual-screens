<?php

namespace App\Livewire;

use App\Models\WorkOrder;
use Livewire\Component;

class DocumentPanel extends Component
{
    public ?int $workOrderId = null;

    public function selectWorkOrder(int $id): void
    {
        $this->workOrderId = $id;
    }

    public function render()
    {
        $workOrder = $this->workOrderId ? WorkOrder::with('documents')->find($this->workOrderId) : null;

        return view('livewire.document-panel', [
            'workOrder' => $workOrder,
            'documents' => $workOrder?->documents ?? collect(),
        ]);
    }
}
