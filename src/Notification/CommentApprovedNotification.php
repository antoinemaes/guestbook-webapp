<?php

namespace App\Notification;

use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;

use App\Entity\Comment;


class CommentApprovedNotification extends Notification implements EmailNotificationInterface
{
    private $comment;

    public function __construct(Comment $comment)
    {
        parent::__construct($comment->getConference().' : comment approved.');

        $this->comment = $comment;
        $this->importance(Notification::IMPORTANCE_MEDIUM);
    }

    public function asEmailMessage(Recipient $recipient, string $transport = null): ?EmailMessage
    {
        $message = EmailMessage::fromNotification($this, $recipient, $transport);
        $message->getMessage()
            ->htmlTemplate('emails/approved_notification.html.twig')
            ->context(['comment' => $this->comment])
        ;

        return $message;
    }
}