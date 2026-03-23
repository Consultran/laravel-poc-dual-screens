<?php

namespace App\Livewire;

use App\Models\WorkOrder;
use Livewire\Component;

class WorkOrderPanel extends Component
{
    public ?int $selectedWorkOrderId = null;

    public function selectWorkOrder(int $id): void
    {
        $this->selectedWorkOrderId = $id;
    }

    public function render()
    {
        return view('livewire.work-order-panel', [
            'workOrders' => WorkOrder::orderBy('order_number')->get(),
            'selectedWorkOrder' => $this->selectedWorkOrderId
                ? WorkOrder::find($this->selectedWorkOrderId)
                : null,
        ]);
    }
}
