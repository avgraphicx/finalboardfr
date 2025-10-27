<?php

namespace App\DataTransferObjects;

use Carbon\Carbon;

class PaymentExtraction
{
    public function __construct(
        public readonly string $driverId,
        public readonly int $weekNumber,
        public readonly ?int $year,
        public readonly float $totalInvoice,
        public readonly int $totalParcels,
        public readonly int $parcelRowsCount,
        public readonly ?string $warehouse = null
    ) {
    }

    public function weekIdentifier(): string
    {
        $year = $this->year ?? Carbon::now()->year;

        return sprintf('%04d-%02d', $year, $this->weekNumber);
    }

    public function toArray(): array
    {
        return [
            'driver_id' => $this->driverId,
            'week_number' => $this->weekIdentifier(),
            'warehouse' => $this->warehouse,
            'total_invoice' => $this->totalInvoice,
            'total_parcels' => $this->totalParcels,
            'parcel_rows_count' => $this->parcelRowsCount,
        ];
    }
}
