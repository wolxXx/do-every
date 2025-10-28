<?php

declare(strict_types = 1);

namespace DoEveryApp\Util\Registry;

enum Key: string
{
    case KEY_ADMIN_USER                   = '7e0b853b-7e45-4e17-9458-89803fcd2c1e';

    case KEY_CRON_LOCK                    = '84c29c0a-cbd9-4bc6-8532-feb785f4c59d';

    case KEY_CRON_STARTED                 = '05226812-dcf8-4e36-89ac-1dccc3e06047';

    case KEY_FILL_TIME_LINE               = '49a4421b-b6f4-458e-a7cd-5253a78305db';

    case KEY_BACKUP_DELAY                 = 'f6b5ea472-1fc6-47e2-8f3b-89fbf41c4a49';

    case KEY_KEEP_BACKUP_DAYS             = 'fbc976e8-629c-4f49-b17c-88a82482def3';

    case KEY_LAST_BACKUP                  = 'e16ede03-9703-4ce3-a075-88d4a64706cb';

    case KEY_LAST_CRON                    = '449b1579-5540-4d06-b076-dfcfea73ff3c';

    case KEY_MAX_GROUPS                   = 'e15e9173-2776-4848-9419-0dfc0112db62';

    case KEY_MAX_TASKS                    = 'd5a3211d-7e3f-4db8-98f0-339036409289';

    case KEY_MAX_WORKERS                  = '0e18481e-767b-41c7-b74a-31b4ffc6bc01';

    case KEY_PRECISION_DUE                = '902069d4-7b4a-4c04-9af5-0d1432ac105d';

    case KEY_NOTIFIER_RUNNING             = 'bd0f21dd-da3c-4986-b660-51c47edf6eeb';

    case KEY_NOTIFIER_LAST_RUN            = '4cf10630-b664-43cd-9693-0effe0934844';

    case KEY_USE_TIMER                    = 'cd72b7ae-af93-4b88-8404-680c76f90b9b';

    case KEY_DAV_USER                     = 'a92e3013-54c6-449c-a977-4850b34a9474';

    case KEY_DAV_PASSWORD                 = '52ea3f65-81f2-4347-86b9-5a9fce56cfdd';

    case KEY_MARKDOWN_TRANSFORMER_ACTIVE  = '941dd2a5-b648-4ce1-9403-cc88b8a22793';

    case KEY_PASSWORD_CHANGE_INTERVAL     = '3615d010-1f86-4b3d-a936-4c2139ae70f0';

    case KEY_EMAIL_CONTENT_SECURITY_NOTES = '7fd30e47-ef45-4423-bdfb-8c983ba0f0bb';

    case KEY_EMAIL_CONTENT_STEPS          = '128a4616-753f-4bac-9d5f-d8dca49fd05a';
}