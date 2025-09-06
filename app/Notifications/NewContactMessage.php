<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification
{
    use Queueable;

    /**
     * The contact message instance.
     *
     * @var Contact
     */
    public Contact $contact;

    /**
     * Create a new notification instance.
     *
     * @param Contact $contact The contact model instance from the form submission.
     */
    public function __construct(Contact $contact)
    {
        // Assign the received contact object to the public property.
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param object $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param object $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $adminUrl = url('/admin/contacts/' . $this->contact->id); // Optional: Link to view message in admin panel

        return (new MailMessage)
            ->subject('New Contact Message from ' . $this->contact->name)
            ->greeting('Hello Admin!')
            ->line("You have received a new message from your website's contact form.")
            ->line('---')
            ->line('**Name:** ' . $this->contact->name)
            ->line('**Email:** ' . $this->contact->email)
            ->line('**Phone:** ' . ($this->contact->phone ?? 'Not provided'))
            ->line('**Message:**')
            ->line($this->contact->comment)
            ->action('View Message in Admin', $adminUrl) // Optional: Button in the email
            ->line('Thank you!');
    }
}
