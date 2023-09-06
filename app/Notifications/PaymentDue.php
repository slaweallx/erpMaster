<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentDue extends Notification
{
    use Queueable;

    /**
     * The sale instance.
     *
     * @var \App\Models\Sale
     */
    public $sale;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Sale  $sale
     *
     * @return void
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        if ( ! $this->sale->due_amount || ! $this->sale->payment_date) {
            $payment_date = Carbon::parse($this->sale->date)->addDays(15);

            if (now()->gt($payment_date)) {
                return [
                    'message' => __('Payment for sale with reference ').$this->sale->reference.__(' is due'),
                    'sale_id' => $this->sale->id,
                ];
            }
        }

        return [
            'message' => __('Payment for sale with reference ').$this->sale->reference.__(' is due on ').$this->sale->date,
            'sale_id' => $this->sale->id,
        ];
    }
}
