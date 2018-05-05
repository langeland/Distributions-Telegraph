<?php


namespace Langeland\TelegraphCore\Service;


use Langeland\TelegraphCore\Domain\Model\Telegram;
use Langeland\TelegraphCore\Domain\Model\Telegraph;
use Langeland\TelegraphCore\Domain\Repository\TelegramRepository;
use Neos\Flow\Annotations as Flow;

class TelegramService
{

    /**
     * @var TelegramRepository
     * @Flow\Inject
     */
    protected $telegramRepository;

    public function convert(string $message): string
    {
        \Neos\Utility\Files::createDirectoryRecursively(FLOW_PATH_TEMPORARY . 'telegrams');

        $telegramTempIdentifier = time();

        $template = file_get_contents(FLOW_PATH_PACKAGES . 'Application/Langeland.TelegraphCore/Resources/Private/PhantomJS/default.html');
        $template = str_replace('###MESSAGE###', $message, $template);
        file_put_contents(FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.html', $template);

        $arguments = [
            'script' => FLOW_PATH_PACKAGES . 'Application/Langeland.TelegraphCore/Resources/Private/PhantomJS/default_capture.js',
            'template' => 'file://' . FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.html',
            'output' => FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.png'
        ];

        exec('/var/www/application/bin/phantomjs --disk-cache=false ' . implode(' ', $arguments));

        $im = imagecreatefrompng(FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.png');
        $this->colorConvert($im);
        imagepng($im, FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.png');
        imagedestroy($im);


        $data = file_get_contents(FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.png');
        $base64 = 'data:image/png;base64,' . base64_encode($data);

        return $base64;

    }

    public function create(Telegraph $telegraph, string $message, string $channel = 'default', bool $instant = false, bool $tag = null): Telegram
    {
        \Neos\Utility\Files::createDirectoryRecursively(FLOW_PATH_TEMPORARY . 'telegrams');

        $telegramTempIdentifier = time();

        $template = file_get_contents(FLOW_PATH_PACKAGES . 'Application/Langeland.TelegraphCore/Resources/Private/PhantomJS/default.html');
        $template = str_replace('###MESSAGE###', $message, $template);
        file_put_contents(FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.html', $template);

        $arguments = [
            'script' => FLOW_PATH_PACKAGES . 'Application/Langeland.TelegraphCore/Resources/Private/PhantomJS/default_capture.js',
            'template' => 'file://' . FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.html',
            'output' => FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.png'
        ];

        exec('/var/www/application/bin/phantomjs --disk-cache=false ' . implode(' ', $arguments));

        $im = imagecreatefrompng(FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.png');
        $this->colorConvert($im);
        imagepng($im, FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.png');
        imagedestroy($im);


        $data = file_get_contents(FLOW_PATH_TEMPORARY . 'telegrams/telegram_' . $telegramTempIdentifier . '.png');
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

    protected function colorConvert($im)
    {

        $threshold = 127;

        $img_x = imagesx($im);
        $img_y = imagesy($im);
        for ($x = 0; $x < $img_x; ++$x) {
            for ($y = 0; $y < $img_y; ++$y) {

                $index = imagecolorat($im, $x, $y);
                $rgb = imagecolorsforindex($im, $index);

                if ($index === 0xFFFFFF) {
                    $color = 0xFFFFFF;
                    continue;
                } elseif ((($rgb['red'] + $rgb['green'] + $rgb['blue']) / 3) > $threshold) {
                    $color = 0xFFFFFF;
                } else {
                    $color = 0x000000;
                    continue;
                }

                imagesetpixel($im, $x, $y, $color);
            }
        }

        return (true);
    }

}