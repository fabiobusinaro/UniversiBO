<?php
namespace Universibo\Bundle\LegacyBundle\Notification;

use Universibo\Bundle\LegacyBundle\Entity\Notifica\NotificaItem;
use Universibo\Bundle\LegacyBundle\Framework\MobytSms;

/**
 * SMS Notification Sender
 *
 * @author Davide Bellettini <davide.bellettini@gmail.com>
 */
class MobytSender extends AbstractSender
{
    /**
     * One week TTL
     * @var int
     */
    const DEFAULT_TTL = 604800;

    /**
     * @var MobytSms
     */
    private $mobyt;

    /**
     * @var int
     */
    private $ttl;

    /**
     * Class constructor
     * @param MobytSms $mobyt
     * @param int      $ttl
     */
    public function __construct(MobytSms $mobyt, $ttl = self::DEFAULT_TTL)
    {
        $this->mobyt = $mobyt;
        $this->ttl = intval($ttl);
    }

    protected function doSend(NotificaItem $notification)
    {
        // won't send expired notifications
        if (time() > ($notification->getTimestamp() + $this->ttl)) {
            return true;
        }

        $message = mb_convert_encoding($notification->getMessaggio(), 'iso-8859-1', 'utf-8');
        $result = $this->mobyt->sendSms($notification->getIndirizzo(), $message);


        if ('OK' !== substr($result, 0, 2)) {
            throw new SenderException('Error: '.$result);
        }
    }

    public function supports(NotificaItem $notification)
    {
        return 'sms' === $notification->getProtocollo();
    }
}
