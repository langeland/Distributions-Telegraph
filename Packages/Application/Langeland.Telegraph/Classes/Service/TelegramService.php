<?php


namespace Langeland\Telegraph\Service;


use Langeland\Telegraph\Domain\Model\Telegram;
use Langeland\Telegraph\Domain\Model\Telegraph;
use Langeland\Telegraph\Domain\Repository\TelegramRepository;
use Neos\Flow\Annotations as Flow;

class TelegramService
{

    /**
     * @var TelegramRepository
     * @Flow\Inject
     */
    protected $telegramRepository;

    public function create(Telegraph $telegraph, string $message, string $channel = 'default', bool $instant = false, bool $tag = null): Telegram
    {
        $telegramTempIdentifier = time();

        $template = file_get_contents(FLOW_PATH_PACKAGES . 'Application/Langeland.Telegraph/Resources/Private/PhantomJS/default.html');
        $template = str_replace('###MESSAGE###', $message, $template);
        file_put_contents(FLOW_PATH_TEMPORARY . '/telegram_' . $telegramTempIdentifier . '.html', $template);

        $arguments = [
            'script' => FLOW_PATH_PACKAGES . 'Application/Langeland.Telegraph/Resources/Private/PhantomJS/default_capture.js',
            'template' => 'file://' . FLOW_PATH_TEMPORARY . '/telegram_' . $telegramTempIdentifier . '.html',
            'output' => FLOW_PATH_TEMPORARY . '/telegram_' . $telegramTempIdentifier . '.png'
        ];

        exec('/var/www/application/bin/phantomjs --disk-cache=false ' . implode(' ', $arguments));

        $data = file_get_contents(FLOW_PATH_TEMPORARY . '/telegram_' . $telegramTempIdentifier . '.png');
        $base64 = 'data:image/png;base64,' . base64_encode($data);


        $telegram = new Telegram();

        $telegram
            ->setTelegraph($telegraph)
            ->setChannel($channel)
            ->setInstant($instant)
            ->setTag($tag)
            ->setMessage($message)
            ->setMessageEncoded($base64);

        $this->telegramRepository->add($telegram);

        return $telegram;

    }

}