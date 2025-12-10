<?php

declare(strict_types = 1);

namespace DoEveryApp\Entity;

enum TableNames: string
{
    case REGISTRY                       = 'registry';

    case SESSION                        = 'session';

    case TASK                           = 'task';

    case TASK_CHECK_LIST_ITEM           = 'task_check_list_item';

    case TASK_EXECUTION                 = 'task_execution';

    case TASK_EXECUTION_CHECK_LIST_ITEM = 'task_execution_check_list_item';

    case TASK_GROUP                     = 'task_group';

    case TASK_NOTIFICATION              = 'task_notification';

    case TASK_TIMER                     = 'task_timer';

    case TASK_TIMER_SECTION             = 'task_timer_section';

    case WORKER                         = 'worker';

    case WORKER_CREDENTIAL              = 'worker_credential';
}