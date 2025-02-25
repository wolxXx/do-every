<?php

declare(strict_types = 1);

namespace DoEveryApp\Action\Task\Timer;

#[\DoEveryApp\Attribute\Action\Route(
    path   : '/task/timer/status/{id:[0-9]+}',
    methods: [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
)]
class StatusAction extends
    \DoEveryApp\Action\AbstractAction
{
    use \DoEveryApp\Action\Share\SingleIdRoute;
    use \DoEveryApp\Action\Share\Task;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        \DoEveryApp\Util\QueryLogger::$disabled = true;
        if (false === ($task = $this->getTask()) instanceof \DoEveryApp\Entity\Task) {
            return \DoEveryApp\Util\JsonGateway::Factory(response: $this->getResponse(), data: ['message' => 'task not found'], code: 404);
        }
        $running = new \DoEveryApp\Util\Timer()->getRunning(task: $task, worker: \DoEveryApp\Util\User\Current::get());
        $paused  = new \DoEveryApp\Util\Timer()->getPaused(task: $task, worker: \DoEveryApp\Util\User\Current::get());
        $last    = new \DoEveryApp\Util\Timer()->getLast(task: $task, worker: \DoEveryApp\Util\User\Current::get());
        $format    = 'Y-m-d H:i:s';
        $data    = [
            'now' => \Carbon\Carbon::now()->format($format),
            'startedAt' => null,
            'offset'    => null,
            'minutes'   => null,
            'seconds'   => null,
            'message'   => 'not running',
            'slices'    => [],
            'last'      => null,
            'running'   => false,
            'paused'    => false,
        ];
        $timer   = null;

        if (null !== $running) {
            $timer           = $running;
            $data['message'] = 'running';
            $data['running'] = true;
        }

        if (null !== $paused) {
            $timer           = $paused;
            $data['message'] = 'paused';
            $data['paused'] = true;
        }

        if (null === $timer) {
            if (null !== $last) {
                $amount = 0;

                foreach ($last->getSections() as $section) {
                    $sectionOffset = 0;
                    $start         = new \Carbon\Carbon(time: $section->getEnd());
                    $diff          = $start->diff(date: $section->getStart());
                    $sectionOffset += \min(1, $diff->seconds);
                    $sectionOffset += $diff->minutes;
                    $sectionOffset += $diff->hours * 60;
                    $sectionOffset += $diff->days * 24 * 60 * 60;
                    $sectionOffset += $diff->months * 30 * 24 * 60 * 60;
                    $sectionOffset += $diff->years * 12 * 30 * 24 * 60 * 60;

                    $amount += $sectionOffset;


                    $data['slices'][] = [
                        'start'  => $section
                            ->getStart()
                            ->format($format),
                        'end'    => $section
                            ->getEnd()
                            ->format($format),
                        'offset' => $sectionOffset,
                    ];
                }

                $data['last'] = $amount;
            }

            return \DoEveryApp\Util\JsonGateway::Factory(response: $this->getResponse(), data: $data, code: 200);
        }


        $offset    = 0;
        $startedAt = null;
        foreach ($timer->getSections() as $section) {
            if (null === $section->getEnd()) {
                $startedAt        = $section
                    ->getStart()
                    ->format($format)
                ;
                $data['slices'][] = [
                    'start' => $startedAt,
                    'end'   => null,
                ];

                $start = \Carbon\Carbon::now();
                $diff  = $start->diff(date: $section->getStart());
                $data['seconds'] = $diff->seconds;
                $data['minutes'] += $diff->minutes;
                $data['minutes'] += $diff->hours * 60;
                $data['minutes'] += $diff->days * 24 * 60 * 60;
                $data['minutes'] += $diff->months * 30 * 24 * 60 * 60;
                $data['minutes'] += $diff->years * 12 * 30 * 24 * 60 * 60;

                continue;
            }
            $start = new \Carbon\Carbon(time: $section->getEnd());
            $diff  = $start->diff(date: $section->getStart());

            $sectionOffset = 0;

            $sectionOffset += \min(1, $diff->seconds);
            $sectionOffset += $diff->minutes;
            $sectionOffset += $diff->hours * 60;
            $sectionOffset += $diff->days * 24 * 60 * 60;
            $sectionOffset += $diff->months * 30 * 24 * 60 * 60;
            $sectionOffset += $diff->years * 12 * 30 * 24 * 60 * 60;

            $offset += $sectionOffset;

            $data['slices'][] = [
                'start'  => $section
                    ->getStart()
                    ->format($format),
                'end'    => $section
                    ->getEnd()
                    ->format($format),
                'offset' => $sectionOffset,
            ];
        }
        $data['minutes'] += $offset;
        $data['seconds'] += 0;
        $data['offset']    = $offset;
        $data['startedAt'] = $startedAt;

        return \DoEveryApp\Util\JsonGateway::Factory(response: $this->getResponse(), data: $data);
    }
}
