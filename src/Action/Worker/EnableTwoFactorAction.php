<?php

declare(strict_types=1);

namespace DoEveryApp\Action\Worker;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/worker/enable-two-factor/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class EnableTwoFactorAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\Worker;
    use \DoEveryApp\Action\Share\SingleIdRoute;

    private const string TWO_FACTOR = '2fa';

    private const string CODE_ONE   = '2faCode1';

    private const string CODE_TWO   = '2faCode2';

    private const string CODE_THREE = '2faCode3';

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === ($worker = $this->getWorker()) instanceof \DoEveryApp\Entity\Worker) {
            return $worker;
        }
        if (null === $worker->getEmail()) {
            \DoEveryApp\Util\FlashMessenger::addDanger($this->translator->needEmailForThisAction());

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }

        $session = \DoEveryApp\Util\Session::Factory(self::TWO_FACTOR);

        if (true === $this->isPostRequest()) {
            $stored2Fa      = $session->get(self::TWO_FACTOR);
            $stored2FaCode1 = $session->get(self::CODE_ONE);
            $stored2FaCode2 = $session->get(self::CODE_TWO);
            $stored2FaCode3 = $session->get(self::CODE_THREE);
            if (true === \in_array(null, [$stored2Fa, $stored2FaCode1, $stored2FaCode2, $stored2FaCode3])) {
                \DoEveryApp\Util\FlashMessenger::addDanger($this->translator->defaultErrorMessage());
                $session->reset();

                return $this->redirect(\DoEveryApp\Action\Worker\EnableTwoFactorAction::getRoute($worker->getId()));
            }
            $worker
                ->setTwoFactorSecret($stored2Fa)
                ->setTwoFactorRecoverCode1($stored2FaCode1)
                ->setTwoFactorRecoverCode2($stored2FaCode2)
                ->setTwoFactorRecoverCode3($stored2FaCode3)
                ->setTwoFactorRecoverCode1UsedAt(null)
                ->setTwoFactorRecoverCode2UsedAt(null)
                ->setTwoFactorRecoverCode3UsedAt(null)
            ;
            $worker::getRepository()->update($worker);
            $this
                ->entityManager
                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess($this->translator->twoFactorEnabled());

            return $this->redirect(\DoEveryApp\Action\Worker\IndexAction::getRoute());
        }

        $twoFactorUtility = \DoEveryApp\Util\TwoFactorAuthenticator::Factory();
        $stored2Fa        = $twoFactorUtility->generateSecretKey();
        $stored2FaCode1   = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $stored2FaCode2   = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $stored2FaCode3   = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $session
            ->write(self::TWO_FACTOR, $stored2Fa)
            ->write(self::CODE_ONE, $stored2FaCode1)
            ->write(self::CODE_TWO, $stored2FaCode2)
            ->write(self::CODE_THREE, $stored2FaCode3)
        ;

        $base64Encode = base64_encode(
            (new \Endroid\QrCode\Writer\PngWriter())
                ->write(
                    (\Endroid\QrCode\QrCode::create(
                        $twoFactorUtility
                            ->getQRCodeUrl(
                                $worker->getEmail(),
                                $stored2Fa
                            )
                    ))
                        ->setSize(300)
                        ->setBackgroundColor(new \Endroid\QrCode\Color\Color(0, 0, 0))
                        ->setForegroundColor(new \Endroid\QrCode\Color\Color(255, 255, 255))
                        ->setRoundBlockSizeMode(\Endroid\QrCode\RoundBlockSizeMode::Shrink)
                )
                ->getString()
        );

        return $this->render('action/worker/enable-two-factor', [
            'worker' => $worker,
            'code1'  => $stored2FaCode1,
            'code2'  => $stored2FaCode2,
            'code3'  => $stored2FaCode3,
            'image'  => '<img style="max-width: 100%; max-height: 300px;" src="data:image/gif;base64,' . $base64Encode . '">',
        ]);
    }
}
