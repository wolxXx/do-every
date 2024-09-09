<?php

namespace DoEveryApp\Action\Cms;

#[\DoEveryApp\Attribute\Action\Route(
    path        : '/edit-settings',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
        \Fig\Http\Message\RequestMethodInterface::METHOD_POST,
    ],
)]
class EditSettingsAction extends \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (true === $this->isGetRequest()) {
            $data = [];
            return $this->render('action/cms/editSettings', ['data' => $data]);
        }
        $data = [];
        try {
            $data     = $this->getRequest()->getParsedBody();
            $data     = $this->filterAndValidate($data);
            \DoEveryApp\Util\Debugger::dieDebug($data);

        } catch (\Throwable $exception) {
            \var_dump($data);
            #die('');
            throw $exception;
        }
        return $this->render('action/cms/editSettings', ['data' => $data]);
    }



    protected function filterAndValidate(array &$data): array
    {
        $data['email']    = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('email'))
        ;
        $data['password'] = (new \Laminas\Filter\FilterChain())
            ->attach(new \Laminas\Filter\StringTrim())
            ->attach(new \Laminas\Filter\ToNull())
            ->filter($this->getFromBody('password'))
        ;

        $validators = new \Symfony\Component\Validator\Constraints\Collection([
            'email'    => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
            'password' => [
                new \Symfony\Component\Validator\Constraints\NotBlank(),
            ],
        ]);


        $this->validate($data, $validators);

        return $data;
    }
}