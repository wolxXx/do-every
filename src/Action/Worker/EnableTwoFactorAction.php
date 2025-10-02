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
            \DoEveryApp\Util\FlashMessenger::addDanger(message: $this->translator->needEmailForThisAction());

            return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
        }

        $session = \DoEveryApp\Util\Session::Factory(namespace: self::TWO_FACTOR);

        if (true === $this->isPostRequest()) {
            $stored2Fa      = $session->get(what: self::TWO_FACTOR);
            $stored2FaCode1 = $session->get(what: self::CODE_ONE);
            $stored2FaCode2 = $session->get(what: self::CODE_TWO);
            $stored2FaCode3 = $session->get(what: self::CODE_THREE);
            if (true === \in_array(needle: null, haystack: [$stored2Fa, $stored2FaCode1, $stored2FaCode2, $stored2FaCode3])) {
                \DoEveryApp\Util\FlashMessenger::addDanger(message: $this->translator->defaultErrorMessage());
                $session->reset();

                return $this->redirect(to: \DoEveryApp\Action\Worker\EnableTwoFactorAction::getRoute(id: $worker->getId()));
            }
            $credential = $worker
                ->getPasswordCredential()
                ->setTwoFactorSecret(twoFactorSecret: $stored2Fa)
                ->setTwoFactorRecoverCode1(twoFactorRecoverCode1: $stored2FaCode1)
                ->setTwoFactorRecoverCode2(twoFactorRecoverCode2: $stored2FaCode2)
                ->setTwoFactorRecoverCode3(twoFactorRecoverCode3: $stored2FaCode3)
                ->setTwoFactorRecoverCode1UsedAt(twoFactorRecoverCode1UsedAt: null)
                ->setTwoFactorRecoverCode2UsedAt(twoFactorRecoverCode2UsedAt: null)
                ->setTwoFactorRecoverCode3UsedAt(twoFactorRecoverCode3UsedAt: null)
            ;
            $credential::getRepository()->update(entity: $credential);
            $this
                ->entityManager
                ->flush()
            ;
            \DoEveryApp\Util\FlashMessenger::addSuccess(message: $this->translator->twoFactorEnabled());

            return $this->redirect(to: \DoEveryApp\Action\Worker\IndexAction::getRoute());
        }

        $twoFactorUtility = \DoEveryApp\Util\TwoFactorAuthenticator::Factory();
        $stored2Fa        = $twoFactorUtility->generateSecretKey();
        $stored2FaCode1   = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $stored2FaCode2   = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $stored2FaCode3   = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $session
            ->write(what: self::TWO_FACTOR, data: $stored2Fa)
            ->write(what: self::CODE_ONE, data: $stored2FaCode1)
            ->write(what: self::CODE_TWO, data: $stored2FaCode2)
            ->write(what: self::CODE_THREE, data: $stored2FaCode3)
        ;

        $base64Encode = base64_encode(
            string: new \Endroid\QrCode\Writer\PngWriter()
                        ->write(
                            qrCode: new \Endroid\QrCode\QrCode(
                                        data              : $twoFactorUtility
                                                                ->getQRCodeUrl(
                                                                    login : $worker->getEmail(),
                                                                    secret: $stored2Fa
                                                                ),
                                        size              : 300,
                                        roundBlockSizeMode: \Endroid\QrCode\RoundBlockSizeMode::Shrink,
                                        foregroundColor   : new \Endroid\QrCode\Color\Color(red: 255, green: 255, blue: 255),
                                        backgroundColor   : new \Endroid\QrCode\Color\Color(red: 0, green: 0, blue: 0)
                                    )
                        )
                        ->getString()
        );

        return $this->render(
            script: 'action/worker/enable-two-factor',
            data  : [
                        'worker' => $worker,
                        'code1'  => $stored2FaCode1,
                        'code2'  => $stored2FaCode2,
                        'code3'  => $stored2FaCode3,
                        'image'  => '<img style="max-width: 100%; max-height: 300px;" src="data:image/gif;base64,' . $base64Encode . '">',
                    ]
        );
    }
}
