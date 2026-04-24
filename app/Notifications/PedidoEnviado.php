<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class PedidoEnviado extends Notification
{
    use Queueable;

    protected Order $order;

    /**
     * Recibe el pedido que fue marcado como enviado.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Canal de entrega: solo correo.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Contenido del correo.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('🎲 ¡Tu pedido #' . $this->order->id . ' ha sido enviado!')
            ->greeting('¡Hola, ' . $notifiable->name . '!')
            ->line('Tenemos buenas noticias: **tu pedido está en camino**.')
            ->line('📦 **Pedido #' . $this->order->id . '** — Total: $' . number_format($this->order->total, 2));

        if ($this->order->shipping_notes) {
            $mail->line('📝 Nota de envío: ' . $this->order->shipping_notes);
        }

        return $mail
            ->action('Ver mis pedidos', url('/orders'))
            ->line('¡Gracias por comprar en Ludika! 🎉');
    }

    /**
     * Representación en array (no se usa).
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
